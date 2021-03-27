#!/bin/bash
sed -i "s/allow_url_include = Off/allow_url_include = On/g" /usr/local/etc/php/php.ini
sed -i "s/listen 80 default_server;/listen 88 default_server;/g" /etc/nginx/sites-enabled/default
sed -i "s/listen [::]:80 default_server;/listen [::]:88 default_server;/g" /etc/nginx/sites-enabled/default
service apache2 restart
/usr/local/php5/sbin/php-fpm start &
service nginx start
redis-server &
rm /var/www/html/flag_
mysql -u root -proot -e "update mysql.user set host=\"%\" where host=\"localhost\";create user 'test'@'127.0.0.1';update mysql.user set select_priv=\"Y\" where user=\"test\";flush privileges;create database run;"
mysql -u root -proot run < /run.sql
while ((1))
do
		sleep 60
done
