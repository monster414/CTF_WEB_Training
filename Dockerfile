FROM ctfhub/base_web_httpd_mysql_php_74

ARG DEBIAN_FRONTEND=noninteractive

COPY run.sql /run.sql
COPY init.sh /init.sh
COPY ./src/libzip-1.2.0.tar.gz /usr/local/src/libzip-1.2.0.tar.gz
COPY ./src/zip-1.15.5.tgz /usr/local/src/zip-1.15.5.tgz
COPY ./src/php-5.2.17.tar.gz /usr/local/src/php-5.2.17.tar.gz
COPY ./src/php-5.2.17.patch /usr/local/src/php-5.2.17.patch
COPY ./src/php-5.2.17-fpm-0.5.14.diff.gz /usr/local/src/php-5.2.17-fpm-0.5.14.diff.gz
RUN rm -fr /var/www/html && \
	chmod +x /init.sh && \
	apt-get update && \
	apt-get -y install zlib1g zlib1g-dev redis-server libxml2-dev vim apache2-dev nginx && \
	cd /usr/local/src/ && \
	tar -zxvf libzip-1.2.0.tar.gz && \
	cd libzip-1.2.0 && \
	./configure && \
	make && make install && \
	cd /usr/local/src/ && \
	tar -xf zip-1.15.5.tgz && \
	cd zip-1.15.5 && \
	/usr/local/bin/phpize && \
	./configure --with-php-config=/usr/local/bin/php-config && \
	make && make install && \
	echo -n "extension=zip.so" >> /usr/local/etc/php/php.ini && \
	cd /usr/local/src/ && \
	tar -zxvf php-5.2.17.tar.gz && \
	gzip -cd php-5.2.17-fpm-0.5.14.diff.gz | patch -d php-5.2.17 -p1 && \
	cd php-5.2.17 && \
	patch -p0 -b < ../php-5.2.17.patch && \
	./configure --prefix=/usr/local/php5 --enable-fpm --enable-fastcgi && \
	make clean && make && make install && \
	cp /usr/local/src/php-5.2.17/php.ini-recommended /usr/local/php5/lib/php.ini
COPY ./html /var/www/html
COPY ./src/default /etc/nginx/sites-enabled/default
COPY ./src/php-fpm.conf /usr/local/php5/etc/php-fpm.conf
CMD /init.sh
