#!/bin/sh

# $Id: cmd.sh 33733 2010-08-05 16:29:17Z release $

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/librc

usage() {
  echo "$0  ${GREEN}command${NORMAL} ..."
  echo
  echo "$0  ${GREEN}appendconf${NORMAL}            packagename"
  echo "$0  ${GREEN}rollbackconf${NORMAL}          packagename"
  echo "$0  ${GREEN}clearcache${NORMAL}            packagename cachetype"
  echo "$0  ${GREEN}shellexecute${NORMAL}          packagename command args"
  echo "$0  ${GREEN}drop-dictionary-cache${NORMAL} packagename"
  echo "$0  ${GREEN}acquire-global-lock${NORMAL}   packagename"
  echo "$0  ${GREEN}release-global-lock${NORMAL}   packagename"
}

# Expl.
#   clearcache core template
#   clearcache comon template
#   clearcache core shindig
# Should be atomic
#
clearcache() {
  local packagename=$1
  local cachetype=$2

  if isnull $packagename || isnull $cachetype; then
    echo "$0  ${GREEN}clearcache${NORMAL}            packagename cachetype"
    exitf
  fi

  local cacheglob=""
  case $cachetype in 
    template)  cacheglob="/tmp/mirtesen_*"
                  ;;
    shindig)      cacheglob="/var/cache/shindig/*"
                  ;;
  esac

  if [ x"$cacheglob" = x ]; then
    errx cachetype doesn\'t match pattern
    exitf
  fi

  execute_concurrent $packagename \
  "
    for d in $cacheglob; do
      if [ ! -d \$d ]; then
        continue
      fi
      tmpdir=\`mktemp -u ${TMPDIR:-/tmp}/cache.XXXXXX\`
      sudo mv \$d \$tmpdir
      sudo rm -fr \$tmpdir
    done
  " || errx "clearcache() failed!"
}

drop_dictionary_cache() {
  local packagename=$1; shift

  if isnull $packagename; then
    echo "$0  ${GREEN}drop-dictionary-cache${NORMAL} packagename"
    exitf
  fi

  execute_once $packagename \
  "
    sudo -u apache -H \
      php $PKGDIR/$packagename/misc/tools/cache_invalidator.php \
        --mapper-name Mapper_Dictionary
  "
}

acquire_global_lock() {
  local packagename=$1; shift

  if isnull $packagename; then
    echo "$0  ${GREEN}acquire-global-lock${NORMAL}   packagename"
    exitf
  fi

  execute_once $packagename \
  "
    sudo -u apache -H \
      php $PKGDIR/$packagename/misc/tools/release/acquire_global_lock.php
  "
}

release_global_lock() {
  local packagename=$1; shift

  if isnull $packagename; then
    echo "$0  ${GREEN}release-global-lock${NORMAL}   packagename"
    exitf
  fi

  execute_once $packagename \
  "
    sudo -u apache -H \
      php $PKGDIR/$packagename/misc/tools/release/release_global_lock.php
  "
}

shellexecute() {
  local packagename=$1; shift

  if isnull $packagename; then
    echo "$0  ${GREEN}shellexecute${NORMAL}          packagename command args"
    exitf
  fi

  execute_consistent $packagename "$*"
}
 
# Expl.
#   appendconf packagename
#   appendconf comon
#   appendconf ftender
#
appendconf() {
  local packagename=$1
  local curdate=`date "+%Y-%m-%d"`
  local curuser="${SUDO_USER:-$USER}"
  local conf="/etc/$packagename/config.local.php"
  local comment="/* $curdate $curuser: appendconf() */"
  
  if isnull $packagename; then
    echo "$0  ${GREEN}appendconf${NORMAL}            packagename"
    exitf
  fi

  echo Please input lines HERE and finish your input with Ctrl+D. To interrupt use Ctrl+C.
  local code=`cat`

  if [ x"$code" = x ]; then
    echo nothing to append...exiting.
    exitf
  fi

  echo -e "<?php $code ?>" | php -l > /dev/null || errx

  execute_concurrent $packagename \
  "
  [ -e $conf ] && [ -r $conf ] || exit $EXIT_FAILURE
  sudo cp -a $conf ${conf}.bak

  (
    echo; cat<<'EOF'
$comment
$code
EOF
  ) | sudo tee -a $conf > /dev/null
  " || errx "appendconf() failed!"
}

rollbackconf() {
  local packagename=$1
  local conf="/etc/$packagename/config.local.php"

  if isnull $packagename; then
    echo "$0  ${GREEN}rollbackconf${NORMAL}          packagename"
    exitf
  fi

  execute_concurrent $packagename \
  "
    [ -e ${conf}.bak ] && [ -r ${conf}.bak ] || exit $EXIT_FAILURE

    sudo cp -a ${conf}.bak $conf
  " || errx "rollbackconf() failed!"
}

whatwedo=$1; shift;
optarg1=$1;  shift;
optarg2=$1; 

if isnull $whatwedo; then
  usage
  exitf
fi

case "$whatwedo" in
  appendconf)             appendconf $optarg1
                          ;;
  rollbackconf)           rollbackconf $optarg1
                          ;;
  clearcache)             clearcache $optarg1 $optarg2
                          ;;
  shellexecute)           shellexecute $optarg1 $*
                          ;;
  drop-dictionary-cache)  drop_dictionary_cache $optarg1
                          ;;
  acquire-global-lock)    acquire_global_lock $optarg1
                          ;;
  release-global-lock)    release_global_lock $optarg1
                          ;;
  *)                      usage; exitf;
                          ;;
esac

# vim: set sw=2 ts=2 et:
