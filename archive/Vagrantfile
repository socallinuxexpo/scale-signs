# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "geerlingguy/centos7"

  config.vm.network "private_network", ip: "192.168.168.168"

  config.vm.synced_folder "./server/signs", "/var/www/html/signs"
  config.vm.synced_folder "./noc", "/var/www/html/noc"

  config.vm.provision "shell", inline: <<-SHELL
    yum update -y
    yum install httpd php -y
    ifup enp0s8
    service httpd start
    rm /etc/localtime -f
    ln -s /usr/share/zoneinfo/America/Los_Angeles /etc/localtime
    echo "visit http://192.168.168.168/signs"
  SHELL

end
