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

for server in $(execute_concurrent $packagename 'echo ""')
do
        # Trim ":" symbol
        server=${server:0:-1}
        if [ -n "$package" ]; then
            echo -n "Removing from..."
            echo `date` "     " ssh $server "rm -rf /var/pkg/$package/" >> /var/tmp/remove.log
            ssh $server "rm -rf /var/pkg/$package/" >> /var/tmp/remove.log
        fi
done