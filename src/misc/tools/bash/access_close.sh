#!/bin/bash

DBSERVERS="fre-tstwt-db1 fre-tstwt-db2"
DBPORTS="5432 5450"
MGSERVERS="fre-tstwt-mg1"
MGPORTS="28017 27017"
REDISSERVERS="fre-tstwt-ms1"
REDISPORTS="6380"
IPTABLES="/sbin/iptables"
F=0

check_ec() {
    EC=$?
    if [ "$EC" -ne "0" ]; then
        F=1
    fi
}

for S in $DBSERVERS; do
    for P in $DBPORTS; do
        ssh $S "$IPTABLES -I INPUT -p tcp --dport $P -j DROP"
        check_ec
        ssh $S "$IPTABLES -I INPUT -p tcp -s fre-tstwt-ms1 --dport $P -j ACCEPT"
        check_ec
        ssh $S "$IPTABLES -I INPUT -p tcp -s 127.0.0.1 --dport $P -j ACCEPT"
        check_ec
    done
done

for S in $MGSERVERS; do
    for P in $MGPORTS; do
        ssh $S "$IPTABLES -I INPUT -p tcp --dport $P -j DROP"
        check_ec
        ssh $S "$IPTABLES -I INPUT -p tcp -s 127.0.0.1 --dport $P -j ACCEPT"
        check_ec
    done
done

for S in $REDISSERVERS; do
    for P in $REDISPORTS; do
        ssh $S "$IPTABLES -I INPUT -p tcp --dport $P -j DROP"
        check_ec
        ssh $S "$IPTABLES -I INPUT -p tcp -s fre-tstwt-ms1 --dport $P -j ACCEPT"
        check_ec
    done
done

if [ "$F" -ne "0" ]; then
    echo "Error!"
    exit 1
fi
