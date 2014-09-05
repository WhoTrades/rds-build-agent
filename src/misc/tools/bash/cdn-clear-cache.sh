#!/bin/bash

dsh -M -c -g sc -- "rm -rf /var/cache/nginx/static/*"
