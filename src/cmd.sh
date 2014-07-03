#!/bin/bash

# $Id: cmd.sh 33733 2010-08-05 16:29:17Z release $

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/librc

usage() {
  echo "$0  ${GREEN}command${NORMAL} ..."
  echo
  echo "$0  ${GREEN}create-conf${NORMAL}           packagename"
  echo "$0  ${GREEN}duplicate-conf${NORMAL}        packagename"
  echo "$0  ${GREEN}append-conf${NORMAL}           packagename"
  echo "$0  ${GREEN}rollback-conf${NORMAL}         packagename"
  echo "$0  ${GREEN}sync-conf${NORMAL}             packagename"
  echo "$0  ${GREEN}clearcache${NORMAL}            packagename cachetype"
  echo "$0  ${GREEN}shell-execute${NORMAL}         packagename command args"
  echo "$0  ${GREEN}drop-dictionary-cache${NORMAL} packagename"
  echo "$0  ${GREEN}acquire-global-lock${NORMAL}   packagename"
  echo "$0  ${GREEN}release-global-lock${NORMAL}   packagename"
  echo "$0  ${GREEN}dictionary-update${NORMAL}     packagename"
}

# Expl.
#   clearcache core template
#   clearcache comon template
#   clearcache core shindig
# Should be atomic
#
clearcache() {
  local groupname=$1
  local packagename=$2
  local cachetype=$3

  if isnull $groupname || isnull $packagename || isnull $cachetype; then
    echo "$0  ${GREEN}clearcache${NORMAL}            packagename cachetype"
    exitf
  fi

  local cacheglob=""
  case $cachetype in 
    template)  cacheglob="/tmp/comon_*"
                  ;;
    shindig)   cacheglob="/var/cache/shindig/*"
                  ;;
  esac

  if [ x"$cacheglob" = x ]; then
    errx cachetype doesn\'t match pattern
    exitf
  fi

  execute_concurrent $groupname \
  "
    for d in $cacheglob; do
      if [ ! -d \$d ]; then
        continue
      fi
      tmpdir=\`mktemp -u ${TMPDIR:-/tmp}/cache.XXXXXX\`
      mv \$d \$tmpdir
      rm -fr \$tmpdir
    done
  " || errx "clearcache() failed!"
}

drop_dictionary_cache() {
  local groupname=$1
  local packagename=$2

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}drop-dictionary-cache${NORMAL} packagename"
    exitf
  fi

  execute_once $groupname \
  "
    sudo -u www-data -H \
      php $PKGDIR/$packagename/misc/tools/runner.php \
        --tool=CacheInvalidator --mapper-name=Mapper_Dictionary
  "
}

dictionary_update() {
  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}dictionary-update${NORMAL}             packagename"
    exitf
  fi

  sh update-data-static.sh
  drop_dictionary_cache $1 $2
  clearcache $1 $2 template
}

acquire_global_lock() {
  local groupname=$1
  local packagename=$2

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}acquire-global-lock${NORMAL}   packagename"
    exitf
  fi

  execute_once $groupname \
  "
    sudo -u apache -H \
      php $PKGDIR/$packagename/misc/tools/runner.php \
        --tool=GlobalLock --acquire
  "
}

release_global_lock() {
  local groupname=$1
  local packagename=$2

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}release-global-lock${NORMAL}   packagename"
    exitf
  fi

  execute_once $groupname \
  "
    sudo -u apache -H \
      php $PKGDIR/$packagename/misc/tools/runner.php \
        --tool=GlobalLock --release
  "
}

shellexecute() {
  local groupname=$1;   shift
  local packagename=$1; shift

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}shell-execute${NORMAL}         packagename command args"
    exitf
  fi

  execute_consistent $groupname "$*"
}
 
duplicateconf() {
  local groupname=$1
  local packagename=$2
  local conf="/etc/$packagename/config.local.php"

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}duplicate-conf${NORMAL}        packagename"
    exitf
  fi

  execute_concurrent $groupname \
  "
  [ -r $conf ] || exit $EXIT_FAILURE
  cp -a ${conf} ${conf}.bak
  " || errx "duplicate-conf() failed!"
}

createconf() {
  local groupname=$1
  local packagename=$2
  local confpath="/etc/$packagename/"
  local conf="/etc/$packagename/config.local.php"

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}duplicate-conf${NORMAL}        packagename"
    exitf
  fi

  execute_concurrent $groupname \
  "
  mkdir ${confpath}
  
  touch ${conf}
  " || errx "create-conf() failed!"
}

# Expl.
#   appendconf packagename
#   appendconf comon
#   appendconf ftender
#
appendconf() {
  local groupname=$1
  local packagename=$2
  local curdate=`date "+%Y-%m-%d"`
  local curuser="${SUDO_USER:-$USER}"
  local conf="/etc/$packagename/config.local.php"
  local comment="/* $curdate $curuser: append-conf() */"
  
  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}append-conf${NORMAL}           packagename"
    exitf
  fi

  echo Please input lines HERE and finish your input with Ctrl+D. To interrupt use Ctrl+C.
  local code=`cat`

  if [ x"$code" = x ]; then
    echo nothing to append...exiting.
    exitf
  fi

  echo -e "<?php $code ?>" | php -l > /dev/null || errx

  duplicateconf $groupname $packagename

  execute_concurrent $groupname \
  "
  cp -a $conf ${conf}.append-conf.new
  [ \$? -eq 0 ] || exit $EXIT_FAILURE

  (
    echo; cat<<'EOF'
$comment
$code
EOF
  ) | tee -a ${conf}.append-conf.new > /dev/null
  [ \$? -eq 0 ] || exit $EXIT_FAILURE

  mv ${conf}.append-conf.new ${conf}
  " || errx "append-conf() failed!"
}

syncconf() {
  local groupname=$1
  local packagename=$2
  local conf="/etc/$packagename/config.local.php"

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}sync-conf${NORMAL}             packagename"
    exitf
  fi

  if [ ! -r $conf ]; then
    errx "Source file \"$conf\" does not exists"
  fi

  php -l $conf > /dev/null || errx 

  confbody=`cat $conf`

  duplicateconf $groupname $packagename

  execute_concurrent $groupname \
  "
  cat<<'EOF' | tee ${conf}.sync-conf.new > /dev/null
$confbody
EOF
  [ \$? -eq 0 ] || exit $EXIT_FAILURE

  mv ${conf}.sync-conf.new ${conf}
  " || errx "sync-conf() failed!"
}

rollbackconf() {
  local groupname=$1
  local packagename=$2
  local conf="/etc/$packagename/config.local.php"

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}rollback-conf${NORMAL}         packagename"
    exitf
  fi

  execute_concurrent $groupname \
  "
    [ -s ${conf}.bak ] || exit $EXIT_FAILURE

    mv ${conf}.bak $conf
  " || errx "rollback-conf() failed!"
}

groupname=
while getopts hg:n opt
do
  case "$opt" in
    g)
      groupname="$OPTARG"
      ;;
    n)
      DRYRUN="t"
      ;;
    h)
      usage
      exitf
      ;;
  esac
done
shift `expr $OPTIND - 1`

whatwedo=$1; shift;
optarg1=$1;  shift;
optarg2=$1;  # do not shift here!

if isnull $whatwedo; then
  usage
  exitf
fi

packagename=$optarg1
if isnull $groupname; then
  groupname=$packagename
fi

case "$whatwedo" in
  append-conf)            appendconf $groupname $packagename
                          ;;
  create-conf)            createconf $groupname $packagename
                          ;;
  duplicate-conf)         duplicateconf $groupname $packagename
                          ;;
  rollback-conf)          rollbackconf $groupname $packagename
                          ;;
  sync-conf)              syncconf $groupname $packagename
                          ;;
  clearcache)             clearcache $groupname $packagename $optarg2
                          ;;
  shell-execute)          shellexecute $groupname $packagename $*
                          ;;
  drop-dictionary-cache)  drop_dictionary_cache $groupname $packagename
                          ;;
  acquire-global-lock)    acquire_global_lock $groupname $packagename
                          ;;
  release-global-lock)    release_global_lock $groupname $packagename
                          ;;
  dictionary-update)      dictionary_update $groupname $packagename
                          ;;
  *)                      usage; exitf;
                          ;;
esac

# vim: set sw=2 ts=2 et:
