#!/bin/bash

if [[ -z "$1" || -z "$2" ]]; then
    echo "Usage: `basename $0` <source_db_dir> <dest_mongodb>"
    exit 1
fi

DIR="$(cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

. $DIR/mongo.conf

FROMDB=$1
DESTDB=$2

ssh -q $MONGOSERVER "echo \"db.dropDatabase();\" | mongo $DESTDB"
FAIL_COUNT=0
FAILED=()

COLS=`ssh -q $MONGOSERVER "ls /var/backup/${FROMDB}/"`
#echo "ssh -q ${MONGOSERVER} \"ls /var/backup/${FROMDB}/\""
#echo $COLS
for COL in $COLS; do
    COL=`echo $COL | sed -e 's/\.json\.gz//'`
    echo "Restore collection: $COL"
    ssh -q $MONGOSERVER "zcat /var/backup/${FROMDB}/${COL}.json.gz | mongoimport -d ${DESTDB} --collection ${COL}"
    if [ $? != "0" ]; then
        echo "Failed to import $MONGOSERVER $COL"
        exit 1
    fi
done
