#!/bin/bash

set -e

renv='prod'
lenv='tst'

bash ./deploy/dump-db-cleanup.sh $lenv --yes
bash ./deploy/dump-db-cleanup.sh $renv --yes
bash ./deploy/dump-db-schema.sh $lenv --all --yes
bash ./deploy/dump-db-schema.sh $renv --all --yes

