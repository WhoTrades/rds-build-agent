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
: ${BUILD=$7}
: ${BUILDTMP=$8}
: ${BUILDTMP=$9}

NAME=`basename $NAME`

if isnull $NAME; then
  echo "$0 packagename version"
  exitf
fi

SRCDIR=$BUILD/$NAME

rm -rf $BUILDTMP/*
rm -rf $BUILDROOT/*
rm -rf $SRCDIR/phing-task

if [ ! -d $SRCDIR ]; then
    mkdir $SRCDIR
fi

cd $BUILDTMP

git archive --format tar --remote ssh://git.whotrades.net/srv/git/sparta master services/phing-task|tar -xv > phing-task.log
code=$?
if [ $code -ne 0 ]; then
    echo "Error during fetching phing-task"
    cat phing-task.log
    exit 11
fi

cd $SCRIPT_PATH
ln -sf $BUILDTMP/services/phing-task/build/$NAME/build.xml $SRCDIR/build.xml
ln -s $BUILDTMP/services/phing-task/ $SRCDIR/phing-task

mkdir -p $BUILDROOT/var/pkg/${NAME}-${VERSION}
phing \
    -Dname=$NAME \
    -Ddestdir=$BUILDROOT/var/pkg/${NAME}-${VERSION} \
    -DtaskId=${taskId} \
    -DrdsDomain=${rdsDomain} \
    -Drepository.createtag=${createTag} \
    -Dversion=${VERSION} \
    -Dproject=${NAME} \
    -Drelease=$release  \
    -Drepositories.update=true \
    -f $SRCDIR/build.xml \
    build

code=$?
if [ $code -ne 0 ]; then
    echo "Build failed"
    exit 12
fi

