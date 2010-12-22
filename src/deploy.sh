#!/bin/sh

PATH="/bin:/sbin:/usr/bin:/usr/sbin:${PATH}"; export PATH
LC_ALL=C; export LC_ALL

REPO="http://build.local/RPMS/noarch"
PKGDIR="/var/pkg"

TPUT=`which tput`
RED=`$TPUT setaf 1`
GREEN=`$TPUT setaf 2`
YELLOW=`$TPUT setaf 3`
NORMAL=`$TPUT op`

EXIT_FAILURE="1"
DSH_CONFDIR=$HOME/.dsh

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

groupname_exists() {
  local groupname=$1
  local retval="0"

  if [ -r $DSH_CONFDIR/group/$groupname ]; then
    retval="1"
  fi

  return $retval
}
  

execute_concurrent() {
  local packagename=$1
  shift
  local command="$*"
  local groupname=$packagename

  if groupname_exists $groupname; then
    echo "groupname \"$groupname\" doesn't exists"
    exitf
  fi

  dsh -M -c -g $groupname -- "$command"
}

execute() {
  local packagename=$1
  shift
  local command="$*"
  local groupname=$packagename

  if groupname_exists $groupname; then
    echo "groupname \"$groupname\" doesn't exists"
    exitf
  fi

  dsh -M -g $groupname -- "$command"
}

usage() {
  echo "$0  ${GREEN}command${NORMAL} ..."
  echo 
  echo "$0  ${GREEN}deploy${NORMAL}  packagename  packageversion" 
  echo "$0  ${GREEN}install${NORMAL} packagename  packageversion"
  echo "$0  ${GREEN}use${NORMAL}     packagename  packageversion"
  echo "$0  ${GREEN}remove${NORMAL}  packagename  packageversion"
  echo "$0  ${GREEN}status${NORMAL}  packagename"
}

install() {
  local packagename=$1
  local packageversion=$2

  if isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}install${NORMAL}  packagename packageversion"
    exitf
  fi

  rpmpackage="$packagename-$packageversion.el5.local.noarch.rpm"
  
  execute_concurrent $packagename "sudo rpm -i $REPO/$rpmpackage" || errx "install() failed!"
}

use() {
  local packagename=$1
  local packageversion=$2

  package=$packagename-$packageversion

  if isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}use${NORMAL}  packagename packageversion"
    exitf
  fi

  execute_concurrent $packagename \
  "
  cd $PKGDIR; 
  [ -d $package ] && sudo ln -nsf $package $packagename
  " || errx "use() failed!"
}

# gracefully restart apache if it's running
httpd_graceful() {
  local packagename=$1
  local packageversion=$2

  if isnull $packagename; then
    echo "$0  ${GREEN}graceful${NORMAL} packagename packageversion"
    exitf
  fi

  execute_concurrent $packagename \
  "
  sudo /sbin/service httpd status >/dev/null 2>&1;
  if [ \$? -eq 0 ]; then
    sudo /sbin/service httpd graceful >/dev/null
  else
    # We should exit correctly if httpd is not present or is not running
    exit 0
  fi
  " || errx "\"service httpd graceful\" failed!"
}

deploy() {
  local packagename=$1
  local packageversion=$2

  if isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}deploy${NORMAL}  packagename packageversion"
    exitf
  fi

  install $packagename $packageversion
  use $packagename $packageversion
  httpd_graceful $packagename $packageversion
}

remove() {
  local packagename=$1
  local packageversion=$2

  if isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}remove${NORMAL}  packagename packageversion"
    exitf
  fi

  rpmpackage="$packagename-$packageversion.el5.local"

  execute_concurrent $packagename \
  "
  cd $PKGDIR;
  [ -e $packagename ] || exit 1
  currversion=\`ls -ld $packagename | awk '{ print \$NF }'\`
  if [ \$currversion = $packagename-$packageversion ]; then
    echo ERROR: version $packageversion of package $packagename is being used...skipped
    exit 1
  fi
  sudo rpm -e $rpmpackage
  "
#  execute_concurrent $packagename `printf 'for package in $(rpm -q %s | sort | head -n 5); do echo $package; done' $packagename`
}

status() {
  local packagename=$1

  if isnull $packagename; then
    echo "$0  ${GREEN}status${NORMAL}  packagename"
    exitf
  fi

  execute_concurrent $packagename \
  "
  cd $PKGDIR;
  [ -e $packagename ] && ls -ld $packagename | awk '{ print \$NF }'
  " || errx "status() failed!"
}

whatwedo=$1;        shift
packagename=$1;     shift
packageversion=$1;  shift

if isnull $whatwedo; then
  usage
  exitf
fi

case "$whatwedo" in
  deploy) deploy $packagename $packageversion
          ;;
  install) install $packagename $packageversion
          ;;
  use)    use $packagename $packageversion
          ;;
  status) status $packagename
          ;;  
  remove) remove $packagename $packageversion
          ;;
  *)      usage; exitf;
          ;;
esac

# vim: set sw=2 ts=2 et:
