#!/usr/bin/env bash

# $Id: cmd.sh 33733 2010-08-05 16:29:17Z release $

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/librc

usage() {
  echo "$0  ${GREEN}command${NORMAL} ..."
  echo
  echo "$0  ${GREEN}sync-conf${NORMAL}             packagename"
  echo "$0  ${GREEN}shell-execute${NORMAL}         packagename command args"
}

shellexecute() {
  local groupName=$1;   shift
  local packagename=$1; shift

  if isnull $groupName || isnull $packagename; then
    echo "$0  ${GREEN}shell-execute${NORMAL}         packagename command args"
    exitf
  fi

  execute_consistent $groupName "$*"
}

syncconf() {
  local groupName=$1
  local packageName=$2

  if isnull $groupName || isnull $packageName; then
    echo "$0  ${GREEN}sync-conf${NORMAL}             packageName"
    exitf
  fi

  local files=`find /etc/$packageName/ -type f | grep -v sync-conf.new`
  for file in $files
  do
      confbody=`cat $file`
      execute_concurrent $packageName \
      "
      if [ ! -d /etc/$packageName ]; then
        sudo mkdir /etc/$packageName
        sudo chown release:release /etc/$packageName
      fi
      cat<<'EOF' | tee ${file}.sync-conf.new > /dev/null
$confbody
EOF
      [ \$? -eq 0 ] || exit $EXIT_FAILURE
      "
      [ $? -eq 0 ] || exit 12
  done

  for file in $files
  do
    execute_concurrent $packageName "mv ${file}.sync-conf.new ${file}" || errx "sync-conf() failed!"
  done
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
  sync-conf)              syncconf $groupname $packagename
                          ;;
  shell-execute)          shellexecute $groupname $packagename $*
                          ;;
  *)                      usage; exitf;
                          ;;
esac

# vim: set sw=2 ts=2 et:
