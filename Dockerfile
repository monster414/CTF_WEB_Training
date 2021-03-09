FROM ctfhub/base_web_httpd_mysql_php_74

ARG DEBIAN_FRONTEND=noninteractive

COPY run.sql /run.sql
COPY init.sh /init.sh
COPY libzip-1.2.0.tar.gz /usr/local/src
COPY zip-1.15.5.tgz /usr/local/src
RUN rm -fr /var/www/html && \
	chmod +x /init.sh && \
	apt-get -y install zlib1g zlib1g-dev && \
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
	echo -n "extension=zip.so" >> /usr/local/etc/php/php.ini
COPY ./html /var/www/html
CMD /init.sh
