count=`ps -Af|grep $0|grep -v grep|grep -v sudo|wc -l`
if [ $count -gt 2 ]; then
    ps -Af|grep $0|grep -v grep|grep -v sudo
    echo "Double run"
    exit 1;
fi
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

if [ $1 -ne "" ]; then
    yes | env PGHOST=pg-0-1.comon.local env PGDATABASE=comon1 sudo sh $DIR/update-data-static.sh;
    sudo -u www-data php /home/dev/dev/comon/misc/tools/runner.php --tool=CacheInvalidator -v --memcache;
fi

sudo -u www-data php /home/dev/dev/comon/misc/tools/runner.php --tool=DictionaryLoaderGetText --path=/tmp/Dictionary/locale -vvv;

