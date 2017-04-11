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
  echo "$0 ${RED}DEPRECATED${NORMAL} Use deb/publish.sh instead OR rpm/publish.sh instead"
  exitf;
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
  [ -d ${package} ] && sudo ln -nsf ${package} $packagename && sudo touch /var/www/${packagename} && ([ -d /etc/cron1-wt.d ] && touch /etc/cron-wt.d || true)
  " || errx "use() failed!"
}

remove() {
    echo "$0 ${RED}DEPRECATED${NORMAL} Use deb/remove.sh instead OR rpm/remove.sh instead"
    exitf;
}

status() {
  local groupname=$1
  local packagename=$2

  if isnull $groupname || isnull $packagename; then
    echo "$0  ${GREEN}status${NORMAL}  packagename"
    exitf
  fi

  package="$packagename"

  execute_concurrent $groupname \
  "
  cd $PKGDIR;
  ls -ld $packagename | awk '{ print \$NF }'
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
