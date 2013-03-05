#!/usr/bin/env bash
set -e

[[ -L /var/www/froxlor ]] && exit
cd /var/www/

mysql -e "ALTER TABLE froxlor.panel_databases ADD allow_external_access INT(1) DEFAULT 0"
tar xjf /tmp/froxlor-dev-20130305.tar.bz2
chown -R froxlorlocal:froxlorlocal froxlor-dev/
mv froxlor froxlor-stock
ln -s froxlor-dev froxlor

# Cleanup
rm /tmp/froxlor-dev-20130305.tar.bz2
sed -i /froxlor/d /etc/apt/sources.list
sudo apt-get update && sudo apt-get upgrade -y && sudo apt-get clean

