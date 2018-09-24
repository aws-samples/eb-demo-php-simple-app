#!/bin/sh
set -ex

/usr/bin/mysql \
    -u $RDS_USERNAME \
    -p$RDS_PASSWORD \
    -h $RDS_HOSTNAME \
    $RDS_DB_NAME \
    -e 'CREATE TABLE IF NOT EXISTS urler(id INT UNSIGNED NOT NULL AUTO_INCREMENT, author VARCHAR(63) NOT NULL, message TEXT, PRIMARY KEY (id))'
