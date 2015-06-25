DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

if [ $1 -ne "" ]; then
    yes | env PGHOST=pg-0-1.comon.local env PGDATABASE=comon1 sudo sh $DIR/update-data-static.sh;
    sudo -u www-data php /home/dev/dev/comon/misc/tools/runner.php --tool=CacheInvalidator -v --memcache;
fi

sudo -u www-data php /home/dev/dev/comon/misc/tools/runner.php --tool=DictionaryLoaderGetText --path=/tmp/Dictionary/locale -vvv;

