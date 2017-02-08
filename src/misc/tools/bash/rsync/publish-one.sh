#!/bin/bash
set -e

echo "[" `date` "] Start deploy to $2..."

rsync -rlpEAXogtz /home/release/buildroot/$1/var/pkg/$1/ $2:/var/pkg/$1
code = $?

echo "[" `date` "] Finished deploy to $2, code=$code..."

exit $code
