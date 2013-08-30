#!/bin/bash

RENV=$1
YES=$2

usage()
{
    echo ""
    echo "  Usage: ./deploy/dump-db-cleanup.sh (ENV=dev|tst|predprod|prod|--all) [--yes]"
    echo ""
    exit 1
}

if [ "$YES" != "" ]; then
    if [ "$YES" != "--yes" ]; then
        usage;
    fi;
fi;

case $RENV in
    dev)
          append="dev"
          ;;
    tst)
          append="tst"
          ;;
    predprod)
          append="predprod"
          ;;
    prod)
          append="prod"
          ;;
    --all)
          append=""
          ;;
    *)
          usage;
esac


prefix="dump_`echo $append`"

files=`ls -1 $prefix* 2>/dev/null`
count=`echo $files | wc -l`

if [ "$count" == "0" ]; then
    echo ""
    echo "  Nothing to clean"
    echo ""
    exit 0
fi;
if [ "$files" == "" ]; then
    echo ""
    echo "  Nothing to clean"
    echo ""
    exit 0
fi;

echo "  Files: "
ls -1 $prefix*
echo ""
echo "  clean? (press Enter for clean or Ctrl-C for break)"
if [ "$YES" != "--yes" ]; then
    read
else
    echo ""
fi;

set -e

rm -f `echo $files | tr "\n" " "`

echo "Cleaned"
exit 0