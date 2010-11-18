#!/bin/sh

# $Id: cmd.sh 33733 2010-08-05 16:29:17Z release $

PATH="/bin:/sbin:/usr/bin:/usr/sbin:${PATH}"; export PATH
LC_ALL=C; export LC_ALL

TPUT=`which tput`
RED=`$TPUT setaf 1`
GREEN=`$TPUT setaf 2`
YELLOW=`$TPUT setaf 3`
NORMAL=`$TPUT op`
EXIT_FAILURE="1"

errx() {
  local message="$*"
  echo $message${RED}...terminating.${NORMAL}
  exit 1
}

exitf() {
  exit $EXIT_FAILURE
}

isnull() {
  local retval="1"
  local variable="$1"

  if [ x$variable == x ]; then retval="0"; fi

  return $retval
}

execute_concurrent() {
  local packagename=$1
  shift
  local command="$*"
  local groupname=$packagename

  dsh -M -c -g $groupname -- "$command"
}

execute() {
  local packagename=$1
  shift
  local command="$*"
  local groupname=$packagename

  dsh -M -g $groupname -- "$command"
}

usage() {
  echo "$0  ${GREEN}command${NORMAL} ..."
  echo
  echo "$0  ${GREEN}appendconf${NORMAL}   packagename"
  echo "$0  ${GREEN}rollbackconf${NORMAL} packagename"
  echo "$0  ${GREEN}clearcache${NORMAL}   packagename cachetype"
  echo "$0  ${GREEN}shellexecute${NORMAL} packagename command args"
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
    echo "$0  ${GREEN}clearcache${NORMAL}  packagename cachetype"
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

shellexecute() {
  local packagename=$1; shift

  if isnull $packagename; then
    echo "$0  ${GREEN}shellexecute${NORMAL}  packagename command args"
    exitf
  fi

  execute_concurrent $packagename "$*"
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
    echo "$0  ${GREEN}appendconf${NORMAL}  packagename"
    exitf
  fi

  echo Please input lines HERE and finish your input with Ctrl+D. To interrupt use Ctrl+C.
  local code=`cat`

  if [ x"$code" = x ]; then
    echo nothing to append...exiting.
    exitf
  fi

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
    echo "$0  ${GREEN}rollbackconf${NORMAL}  packagename"
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
  appendconf)   appendconf $optarg1
                ;;
  rollbackconf) rollbackconf $optarg1
                ;;
  clearcache)   clearcache $optarg1 $optarg2
                ;;
  shellexecute) shellexecute $optarg1 $*
                ;;
  *)            usage; exitf;
                ;;
esac

# vim: set sw=2 ts=2 et:
