#!/usr/bin/env python

import gtk
import webkit
import socket

#ip = socket.gethostbyaddr_ex(socket.gethostname())
# returns: ('hostname.domain', ['hostname'], ['192.168.0.2'])
#ip = socket.gethostbyaddr(socket.gethostname())[-1][0]
#ip = socket.gethostbyname_ex(socket.gethostname())

import fcntl
import struct

def get_ip_address(ifname):
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    return socket.inet_ntoa(fcntl.ioctl(
        s.fileno(),
        0x8915,  # SIOCGIFADDR
        struct.pack('256s', ifname[:15])
    )[20:24])[10:13]

#ip = get_ip_address('eth0')  # '192.168.0.110'
#ip = 'SCALE:'+ip
#print ip


def close_func(webview):
 # Byebye!
 gtk.main_quit()
 return True

def create_func(webview, webframe):
 # Return the original webview, and now it can be closed...
 return webview

webview = webkit.WebView()
#webview.get_settings().props.user_agent += ip
webview.get_settings().props.enable_private_browsing = True
webview.get_settings().props.enable_default_context_menu = False
webview.get_settings().props.javascript_can_open_windows_automatically = True

webview.connect('close-web-view', close_func)
webview.connect('create-web-view', create_func)
webview.open('http://signs.scale.lan/signs')
#webview.open('http://signs.socallinuxexpo.org/index.php?year=2016&month=1&day=21&hour=10&minute=30')


#scroller = gtk.ScrolledWindow()
#scroller.add(webview)

win = gtk.Window()
win.fullscreen()
#win.add(scroller)
win.add(webview)
win.show_all()

gtk.main()
