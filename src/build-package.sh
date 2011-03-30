#!/bin/sh

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/librc

unset GIT_DIR
unset GIT_WORK_DIR

: ${NAME=$1}
: ${VERBOSE="no"}
: ${TMPDIR="/var/tmp"}

: ${VERSION="`date "+%Y.%m.%d.%H.%M"`"}
: ${RELEASE="1"}

NAME=`basename $NAME`

if isnull $NAME; then
  echo "$0 packagename"
  exitf
fi

srcdir=`printf %s/../%s $SCRIPT_PATH $NAME`
specfile=`printf %s/%s.spec $TMPDIR $NAME`

if [ ! -f $srcdir/misc/tools/build/specfile.sh ]; then
  echo "${RED}package \"$NAME\" does not support deploy/build-package.sh system${NORMAL}"
  exitf
fi

. $srcdir/misc/tools/build/specfile.sh

trap "{ rm -f $specfile; }" EXIT

rpmbuild="rpmbuild -ba $specfile"
if verbose; then
  rpmbuild="rpmbuild"
else
  rpmbuild="rpmbuild --quiet"
fi

$rpmbuild -ba $specfile
retval=$?

if [ $retval -eq 0 ]; then
  echo ${GREEN}$NAME $VERSION-$RELEASE${NORMAL}
fi

exit $retval
