#!/bin/bash

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/../librc

packagename=$1
packageversion=$2

package="$packagename-$packageversion"

if isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}install${NORMAL}  packagename packageversion"
    exitf
fi

execute_concurrent $packagename "sudo apt-get update; sudo apt-get -y --force-yes install $package" || errx "install() failed!"

