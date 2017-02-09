#!/bin/bash
set -e

SCRIPT_PATH=$(dirname $(readlink -f $0))

. $SCRIPT_PATH/../librc

packagename=$1
packageversion=$2

package="$packagename-$packageversion"

if isnull $packagename || isnull $packageversion; then
    echo "$0  ${GREEN}install${NORMAL}  packagename packageversion"
    exitf
fi

execute_concurrent $packagename "sudo mkdir /var/pkg/$package/ && sudo chown release:release /var/pkg/$package/"

maxProcessCount=5
(for server in $(execute_concurrent $packagename 'echo ""')
do
        # Trim ":" symbol
        server=${server:0:-1}
        echo $server
done)|xargs -I {} -P $maxProcessCount bash $SCRIPT_PATH/publish-one.sh $package {}

echo "[" `date` "] finished"
