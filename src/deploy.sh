#!/bin/sh


SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/librc

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
  local groupname=$1
  local packagename=$2
  local packageversion=$3
  local force=$4

  if isnull $groupname || isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}install${NORMAL}  packagename packageversion"
    exitf
  fi

  php deploy/releaseLogger.php $packagename $packageversion "install-inprogress"

  rpmpackage="$packagename-$packageversion.el5.local.noarch.rpm"
  
  execute_concurrent $groupname "sudo time -f ">> Time: %e" rpm -i $REPO/$rpmpackage" || errx "install() failed!"

  php deploy/releaseLogger.php $packagename $packageversion "installed"
}

use() {
  local groupname=$1
  local packagename=$2
  local packageversion=$3

  package=$packagename-$packageversion

  if isnull $groupname || isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}use${NORMAL}  packagename packageversion"
    exitf
  fi

  execute_concurrent $groupname \
  "
  cd $PKGDIR; 
  [ -d $package ] && sudo ln -nsf $package $packagename
  " || errx "use() failed!"

  php deploy/releaseLogger.php $packagename $packageversion "use"
}

# gracefully restart apache if it's running
httpd_graceful() {
  local groupname=$1
  local packagename=$2
  local packageversion=$3

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}graceful${NORMAL} packagename packageversion"
    exitf
  fi

  execute_concurrent $groupname \
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
  local groupname=$1
  local packagename=$2
  local packageversion=$3

  if isnull $groupname || isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}deploy${NORMAL}  packagename packageversion"
    exitf
  fi

  install        $groupname $packagename $packageversion
  use            $groupname $packagename $packageversion
  httpd_graceful $groupname $packagename $packageversion
}

remove() {
  local groupname=$1
  local packagename=$2
  local packageversion=$3

  if isnull $groupname || isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}remove${NORMAL}  packagename packageversion"
    exitf
  fi

  rpmpackage="$packagename-$packageversion.el5.local"

  execute_concurrent $groupname \
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
}

status() {
  local groupname=$1
  local packagename=$2

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}status${NORMAL}  packagename"
    exitf
  fi

  execute_concurrent $groupname \
  "
  cd $PKGDIR;
  [ -e $packagename ] && ls -ld $packagename | awk '{ print \$NF }'
  " || errx "status() failed!"
}

groupname=
DRYRUN=
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

whatwedo=$1;        shift
packagename=$1;     shift
packageversion=$1;  shift
force=$1;  			shift

if isnull $whatwedo; then
  usage
  exitf
fi

if isnull $groupname; then
  groupname=$packagename
fi

case "$whatwedo" in
  deploy)  deploy  $groupname $packagename $packageversion
           ;;
  install) install $groupname $packagename $packageversion $force
           ;;
  use)     use     $groupname $packagename $packageversion
           ;;
  status)  status  $groupname $packagename
           ;;
  remove)  remove  $groupname $packagename $packageversion
           ;;
  *)       usage; exitf;
           ;;
esac

# vim: set sw=2 ts=2 et:
