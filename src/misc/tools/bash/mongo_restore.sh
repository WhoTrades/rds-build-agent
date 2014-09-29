#!/bin/bash

if [[ -z "$1" || -z "$2" ]]; then
    echo "Usage: `basename $0` <source_db_dir> <dest_mongodb>"
    exit 1
fi

. /opt/bin/mongo.conf

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
    ssh -q $MONGOSERVER "zcat /var/backup/${FROMDB}/${COL}.json.gz | mongoimport -d ${DESTDB} --collection ${COL}" &
done


jobs -p -l > /tmp/mongo_restore.txt

while read -r -a job; do
    pid=${job[1]}

    wait $pid;
    if [ $? != "0" ]; then
       let "FAIL+=1"
       FAILED+=("${job[3]} ${job[4]}")
    fi
done < /tmp/mongo_restore.txt

echo "FINISHED"

for ix in ${!FAILED[*]}
do
    printf "Failed command:   %s\n" "${FAILED[$ix]}"
done

exit FAIL_COUNT
