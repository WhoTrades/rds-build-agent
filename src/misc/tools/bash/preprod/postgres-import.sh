service skytools3 stop
service pgbouncer stop

#sudo -i -u postgres

#for db in comon1 comon2 comon3 comon4 ftender; do
for db in comon4; do
    echo $db; date;
    sudo -i -u postgres RESTORE_DBNAME=$db bash pgcookbook/bin/restore_dump.sh 2>&1 \
        >>/var/log/postgresql/restore_dump.log | \
        tee -a /var/log/postgresql/restore_dump.log;
done; date

sudo -i -u postgres psql <<EOF
ALTER DATABASE comon1 SET search_path TO public, static, btree_gist, btree_gin, hstore, mantis, adm, pgq, plproxy; ALTER DATABASE comon2 SET search_path TO public, static, btree_gist, btree_gin, hstore, mantis, adm, pgq, plproxy; ALTER DATABASE comon3 SET search_path TO public, static, btree_gist, btree_gin, hstore, mantis, adm, pgq, plproxy; ALTER DATABASE comon4 SET search_path TO public, static, btree_gist, btree_gin, hstore, mantis, adm, pgq, plproxy; ALTER DATABASE ftender SET search_path TO public, static, btree_gist, btree_gin, hstore, mantis, adm, pgq, plproxy, pgbuffercache, pgrowlock, pgstatstatements, pgstattuple;
EOF


service pgbouncer start
service skytools3 start

echo "Finished postgres import"
