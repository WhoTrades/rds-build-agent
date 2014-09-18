#!/bin/bash

dsh -M -c -g all -- "/sbin/iptables -F INPUT"
