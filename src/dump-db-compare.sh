#!/bin/bash

set -e

. ./deploy/librc

tool=dev/comon/misc/tools/deprecated/dump/compare.php
php=/usr/local/bin/php

renv='dev'
lenv='tst'

echo " "
echo " $GREEN Clean up old dumps$NORMAL"
echo " "
bash ./deploy/dump-db-cleanup.sh $lenv --yes
bash ./deploy/dump-db-cleanup.sh $renv --yes

echo " "
echo " $GREEN Make new dumps$NORMAL"
echo " "
bash ./deploy/dump-db-schema.sh $lenv --all --yes
bash ./deploy/dump-db-schema.sh $renv --all --yes

echo " "
echo " $GREEN Compare new dumps$NORMAL"
echo " "

bases=(comon1 comon2 comon3 comon4 ftender)
fails=()

for i in ${bases[@]}
do
 left=`ls -1 dump_* | grep $i | grep $lenv`
 right=`ls -1 dump_* | grep $i | grep $renv`
 dumpName="$i.dbdiff"

 echo -n "Compare $i ... "
 $php $tool $left $right > $dumpName
 $status = $?
 if [ "$status" == "0" ]; then
    echo "$GREENok$NORMAL"
 else
    echo "$REDnot equals$NORMAL"
    fails+=($i)
 fi;
done

for fail in ${fail[@]}; do
 dumpName = "$fail.dbdiff";
 echo "Not equals dump for $fail in file: $dumpName";
done

echo " "
echo "  $GREENDone$NORMAL"
echo " "