#!/bin/sh

# $Id$

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
  echo "$0  ${GREEN}appendconf${NORMAL} packagename"
#  echo "$0  ${GREEN}clearcache${NORMAL}"
}

# Expl.
#   clearcache core template
#   clearcache comon template
#   clearcache core shindig
# Should be atomic
#
clearcache() {
  local groupname=$1
  local cachetype=$2

  if isnull $groupname || isnull $cachetype; then
    echo "$0  ${GREEN}clearcache${NORMAL}  groupname cachetype"
    exitf
  fi
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
  ) | sudo tee -a $conf
  "
}

whatwedo=$1; shift;
optarg1=$1;  shift;

if isnull $whatwedo; then
  usage
  exitf
fi

case "$whatwedo" in
  clearcache)   clearcache
                ;;
  appendconf)   appendconf $optarg1
                ;;
  *)      usage; exitf;
          ;;
esac

# vim: set sw=2 ts=2 et:
