FROM centos:7
# CentOS is EOL https://www.redhat.com/en/blog/centos-linux-vs-rhel
# mirrorlist no longer available
# https://kb.filewave.com/books/linux-tips-and-tricks/page/updating-centos-repo-files-after-mirrorlist-end-of-life
# Alternative is to use vault.centos.org and switch from mirrorlist to baseurl
RUN sed -i s/mirror.centos.org/vault.centos.org/g /etc/yum.repos.d/*.repo && \
    sed -i s/^#.*baseurl=http/baseurl=http/g /etc/yum.repos.d/*.repo && \
    sed -i s/^mirrorlist=http/#mirrorlist=http/g /etc/yum.repos.d/*.repo && \
    sed -i 's/mirrorlist/#mirrorlist/g' /etc/yum.repos.d/CentOS-* && \
    sed -i 's|#baseurl=http://mirror.centos.org|baseurl=http://vault.centos.org|g' /etc/yum.repos.d/CentOS-*
RUN yum update -y && yum install -y httpd php
RUN rm /etc/localtime -f && ln -s /usr/share/zoneinfo/America/Los_Angeles /etc/localtime
COPY ["./conf/httpd.conf", "/etc/httpd/conf/httpd.conf"]
COPY ["./conf/php.ini", "/etc/php.ini"]
COPY ["./server/", "/var/www/html/"]
EXPOSE 80
CMD /usr/sbin/httpd -DFOREGROUND
