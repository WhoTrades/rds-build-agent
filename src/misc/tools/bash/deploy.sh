#!/bin/bash

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

  if isnull $groupname || isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}install${NORMAL}  packagename packageversion"
    exitf
  fi

  package="$packagename-$packageversion"

  execute_concurrent $groupname "apt-get update; apt-get -y --force-yes install $package" || errx "install() failed!"
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
  [ -d ${package} ] && ln -nsf ${package} $packagename
  " || errx "use() failed!"
}

# gracefully reload nginx if it's running
nginx_reload() {
  local groupname=$1
  local packagename=$2
  local packageversion=$3

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}reload${NORMAL} packagename packageversion"
    exitf
  fi

  execute_concurrent $groupname \
  "
  /etc/init.d/nginx status >/dev/null 2>&1;
  if [ \$? -eq 0 ]; then
    /etc/init.d/nginx reload >/dev/null
  else
    # We should exit correctly if nginx is not present or is not running
    exit 0
  fi
  " || errx "nginx reload failed!"
}

fpm_reload() {
  local groupname=$1
  local packagename=$2
  local packageversion=$3

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}reload fpm${NORMAL} packagename packageversion"
    exitf
  fi

  execute_concurrent $groupname \
  "
  /etc/init.d/php5-fpm status >/dev/null 2>&1;
  if [ \$? -eq 0 ]; then
    /etc/init.d/php5-fpm reload >/dev/null
  else
    # We should exit correctly if nginx is not present or is not running
    exit 0
  fi
  " || errx "php5-fpm reload failed!"
}

deploy() {
  local groupname=$1
  local packagename=$2
  local packageversion=$3

  if isnull $groupname || isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}deploy${NORMAL}  packagename packageversion"
    exitf
  fi

  install      $groupname $packagename $packageversion
  use          $groupname $packagename $packageversion
  fpm_reload   $groupname $packagename $packageversion
}

remove() {
  local groupname=$1
  local packagename=$2
  local packageversion=$3

  if isnull $groupname || isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}remove${NORMAL}  packagename packageversion"
    exitf
  fi

  package="$packagename-$packageversion"

  execute_concurrent $groupname \
  "
  cd $PKGDIR;
  [ -e ${package} ] || exit 1
  currversion=\`ls -ld $packagename | awk '{ print \$NF }'\`
  if [ \$currversion = ${packagename}-${packageversion} ]; then
    echo ERROR: version $packageversion of package $packagename is being used...skipped
    exit 1
  fi
  apt-get -y --force-yes purge ${package}
  "
}

status() {
  local groupname=$1
  local packagename=$2

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}status${NORMAL}  packagename"
    exitf
  fi

#  package="$packagename-$packageversion"
  package="$packagename"
#  echo $package

  execute_concurrent $groupname \
  "
  cd $PKGDIR;
  ls -ld $packagename | awk '{ print \$NF }'
  " || errx "status() failed!"

#  execute_concurrent $groupname \
#  "
#  cd $PKGDIR;
#  [ -e ${package} ] && ls -ld $packagename | awk '{ print \$NF }'
#  " || errx "status() failed!"
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
  install) install $groupname $packagename $packageversion
           ;;
  use)     use     $groupname $packagename $packageversion
           ;;
  status)  status  $groupname $packagename
           ;;
  remove)  remove  $groupname $packagename $packageversion
           ;;
  fpm)     fpm_reload  $groupname $packagename $packageversion
	    ;;
  *)       usage; exitf;
           ;;
esac
