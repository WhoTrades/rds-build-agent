#!/bin/sh

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/librc

unset GIT_DIR
unset GIT_WORK_DIR

: ${NAME=$1}
: ${VERBOSE="no"}
: ${TMPDIR="/var/tmp"}

: ${VERSION="`date "+%Y.%m.%d.%H.%M"`"}

NAME=`basename $NAME`

if isnull $NAME; then
  echo "$0 packagename"
  exitf
fi

srcdir=`printf %s/../%s $SCRIPT_PATH $NAME`
specfile=`printf %s/%s.spec $TMPDIR $NAME`

beverbose() {
  local retval

  case "$VERBOSE" in
    0|[nN][oO]) retval=1;;
    *)          retval=0;;
  esac

  return $retval
}

logging() {
  if beverbose; then
    cat -
  else
    cat - > /dev/null
  fi
}

. $srcdir/misc/tools/build/specfile.sh

trap "{ rm -f $specfile; }" EXIT

rpmbuild="rpmbuild -ba $specfile"
if beverbose; then
  rpmbuild="rpmbuild"
else
  rpmbuild="rpmbuild --quiet"
fi

$rpmbuild -ba $specfile
retval=$?

if [ $retval -eq 0 ]; then
  echo ${GREEN}$NAME $VERSION${NORMAL}
fi

exit $retval
