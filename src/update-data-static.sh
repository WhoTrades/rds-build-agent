#!/bin/sh

TPUT=`which tput`
RED=`$TPUT setaf 1`
GREEN=`$TPUT setaf 2`
YELLOW=`$TPUT setaf 3`
NORMAL=`$TPUT op`

: ${PGHOST=pg-0-1.core.local}; export PGHOST
: ${PGUSER=comon};          export PGUSER
: ${PGDATABASE=comon1};      export PGDATABASE
: ${PGPASSFILE=~/.pgpass};     export PGPASSFILE

if [ -r $HOME/.update-data-static ]; then
  . $HOME/.update-data-static
fi

yesnoexit() {
  echo -n "Are you SURE (y/N)? "
  read ans

  if [ x"$ans" != "xy" ]; then
    echo "${YELLOW}...exiting.${NORMAL}"
    exit 0
  fi
}

execute() {
  local file=$1

  cat <<EOF | psql
\\set ON_ERROR_STOP on
SET statement_timeout TO 0;
BEGIN;
\\i $file
COMMIT;
EOF
  retval=$?

  return $retval
}
rm -rfv ./data_static
wget http://mdr.dev.whotrades.net/release/data_static

SCRIPT_PATH=$(dirname $(readlink -f $0))

MYHOME=$(dirname $(dirname $SCRIPT_PATH))
#DATA_STATIC=$MYHOME/misc/db/data_static.sql
DATA_STATIC=./data_static
echo
echo "PGHOST     = ${GREEN}${PGHOST}${NORMAL}"
echo "PGUSER     = ${GREEN}${PGUSER}${NORMAL}"
echo "PGDATABASE = ${GREEN}${PGDATABASE}${NORMAL}"
echo "PGPASSFILE = ${GREEN}${PGPASSFILE}${NORMAL}"
echo

echo -n "We are going to update data static. "
yesnoexit

execute $DATA_STATIC
if [ $? -ne 0 ]; then
  echo ${RED}'!!'${NORMAL}
  echo ${RED}'!! Error while performing SQL commands!'${NORMAL}
  echo ${RED}'!!'${NORMAL}
  echo ${RED}'!! Please correct all errors and continue.'${NORMAL}
  echo ${RED}'!!'${NORMAL}
fi

# vim: set sw=2 ts=2 et:
