#!/bin/bash

DIR="$(cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

. $DIR/mongo.conf

YESTERDAY=`date "+%Y%m%d" --date="1 days ago"`
F=0

for DB in $DBS; do
    ssh $MONGOSERVER "if [ -d /var/backup/${DB}.${YESTERDAY} ]; then echo '${DB}.${YESTERDAY}'; exit 0; fi; exit 15"
    if [ "$?" = "0" ]; then
        F=1
    fi
done

if [ "$F" = "1" ]; then
        exit 1
fi
