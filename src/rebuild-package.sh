#!/bin/bash

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/librc

unset GIT_DIR
unset GIT_WORK_DIR

: ${NAME=$1}
: ${VERBOSE="yes"}
: ${TMPDIR="/var/tmp"}

: ${VERSION=$2}
: ${release=$3}
: ${taskId=$4}
: ${rdsDomain=$5}
: ${createTag=$6}

NAME=`basename $NAME`

if isnull $NAME; then
  echo "$0 packagename version"
  exitf
fi

BUILD="/home/release/build"
#rm -rf $BUILD/*

BUILDTMP="/home/release/buildtmp"
rm -rf $BUILDTMP/*

BUILDROOT="/home/release/buildroot/${NAME}-${VERSION}"
rm -rf $BUILDROOT/*

SRCDIR=`printf %s/../build/%s $SCRIPT_PATH $NAME`
rm -rf $SRCDIR/phing-task

git clone ssh://git.whotrades.net/srv/git/phing-task $SRCDIR/phing-task
cd $SRCDIR/phing-task
git remote update
git checkout master
git reset --hard origin/master
git clean -f -d
cd $SCRIPT_PATH

ln -sf phing-task/build/$NAME/build.xml $SRCDIR/build.xml

mkdir -p $BUILDROOT/var/pkg/${NAME}-${VERSION}
phing -Dname=$NAME -Ddestdir=$BUILDROOT/var/pkg/${NAME}-${VERSION} -DtaskId=${taskId} -DrdsDomain=${rdsDomain} -Drepository.createtag=0 -Dversion=${VERSION} -Dproject=${NAME} -Ddictionary.sqlite.update=true -Drelease=$release  -Drepositories.update=true -f $SRCDIR/build.xml build
code=$?
[ $code != "0" ] && exit $code

# Create deb-package
echo "2.0" > $BUILDTMP/debian-binary

echo "TAR directory $BUILDROOT"
cd $BUILDROOT
tar -cf - * | gzip > $BUILDTMP/data.tar.gz

cd $BUILDTMP
echo "Package: ${NAME}-${VERSION}" > ./control
echo "Architecture: all" >> ./control
echo "Version: ${VERSION}" >> ./control
echo "Maintainer: Package Builder <vdm+release@whotrades.net>" >> ./control
echo "Priority: optional" >> ./control
echo "Description: WhoTrades.com ${NAME} sources" >> ./control
echo " WhoTrades.com ${NAME} sources" >> ./control
tar -cf - ./control | gzip > ./control.tar.gz

ar -qS "${NAME}-${VERSION}_all.deb" debian-binary control.tar.gz data.tar.gz

cd /var/www/whotrades_repo
reprepro export
reprepro createsymlinks
reprepro -S admin -C non-free -P extra includedeb wheezy $BUILDTMP/${NAME}-${VERSION}_all.deb
RETVAL=$?

if [ $RETVAL -eq 0 ]; then
  echo ${GREEN}$NAME-$VERSION${NORMAL}
  php deploy/releaseLogger.php $NAME $VERSION "built"
fi

cd $SCRIPT_PATH
exit $RETVAL
