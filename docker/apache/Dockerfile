FROM httpd:alpine3.16
RUN apk update; \
    apk upgrade;

RUN mkdir -p /var/log/apache2/ && \
    chmod -R 744 /var/log/apache2/

COPY myhttpd.conf /usr/local/apache2/conf/myhttpd.conf

RUN echo "Include /usr/local/apache2/conf/myhttpd.conf" \
    >> /usr/local/apache2/conf/httpd.conf

EXPOSE 8000

CMD /usr/local/apache2/bin/httpd -D FOREGROUND


