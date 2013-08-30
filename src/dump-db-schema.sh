#!/bin/bash

DUMPER=/usr/bin/pg_dump
RENV=$1
prefix="dump_`echo $RENV`_`date +%s`"

usage()
{
    echo ""
    echo "  Usage: deploy/dump-db-schema.sh (ENV=dev|tst|predprod|prod) (dbname|--all) [--yes]"
    echo ""
    exit 1
}

not_configured()
{
    echo "This env is not configured ($RENV)"
    exit 2
}


#syntax checks
DBNAME=$2
if [ "$DBNAME" == "" ]; then
    usage;
fi

if [ "$3" != "--yes" ]; then
    if [ "$3" != "" ]; then
      usage;
    fi;
fi;

case "$RENV" in
    dev)
       user="comon"
       password=0
       envname="DEV envinonment"

       bases_comon1="devdb.whotrades.net"
       bases_comon2="devdb.whotrades.net"
       bases_comon3="devdb.whotrades.net"
       bases_comon4="devdb.whotrades.net"
       bases_ftender="devdb.whotrades.net"
     ;;
    tst)
       user="comon"
       password=0
       envname="TEST envinonment"

       bases_comon1="tstap.whotrades.net"
       bases_comon2="tstap.whotrades.net"
       bases_comon3="tstap.whotrades.net"
       bases_comon4="tstap.whotrades.net"
       bases_ftender="tstap.whotrades.net"
     ;;
    predprod)
       not_configured
       user="comon"
       password=1
       envname="Pred-Prod envinonment"
     ;;
    prod)
       not_configured
       host=""
       user="comon"
       password=1
       envname="PROD envinonment"
     ;;
    *)
     usage;
esac

echo "Using $envname !";
echo -n "ok? (press Enter to run dump, or Ctrl-C to cancel): "
if [ "$3" != "--yes" ]; then
    read
else
    echo ""
fi
echo "dumping: "

for i in `echo "${!bases_*}" | tr " " "\n"`
do
  base=`echo $i | sed -e 's/^bases_//g'`
  host="${!i}"
  if [ "$DBNAME" != "--all" ]; then
    if [ "$DBNAME" != "$base" ]; then
       continue;
    fi;
  fi;
  echo -n "    base: "
  echo -n $base
  echo -n "  host:"
  echo -n $host
  echo -n " ... "
  pg_dump --host $host -U comon -s --no-privileges --no-owner $base > $prefix.$base.schema.sql
  echo "ok"
done

echo "dump files is:"
ls -1 $prefix.*