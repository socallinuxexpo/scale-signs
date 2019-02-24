FROM centos:7
RUN yum update -y && yum install -y httpd php
RUN rm /etc/localtime -f && ln -s /usr/share/zoneinfo/America/Los_Angeles /etc/localtime
COPY ["./conf/httpd.conf", "/etc/httpd/conf/httpd.conf"]
COPY ["./conf/php.ini", "/etc/php.ini"]
COPY ["./server/", "/var/www/html/"]
EXPOSE 80
CMD /usr/sbin/httpd -DFOREGROUND
