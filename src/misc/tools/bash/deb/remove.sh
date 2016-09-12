#!/bin/bash

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/../librc

packagename=$1
packageversion=$2

if isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}remove${NORMAL}  packagename packageversion"
    exitf
fi

package="$packagename-$packageversion"

execute_concurrent packagename \
"
cd $PKGDIR;
[ -e ${package} ] || exit 1
currversion=\`ls -ld $packagename | awk '{ print \$NF }'\`
if [ \$currversion = ${packagename}-${packageversion} ]; then
    echo ERROR: version $packageversion of package $packagename is being used...skipped
    exit 1
fi
sudo apt-get -y --force-yes purge ${package}
sudo apt-get -y --force-yes clean
"

