#!/bin/bash

NAME=$1
VERSION=$2
BUILDTMP=$3
BUILDROOT=$4

echo "Publishing using DEB driver"

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
fi

cd $SCRIPT_PATH
exit $RETVAL
