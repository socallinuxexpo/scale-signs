#!/usr/bin/env python

import urllib
from xml.dom import minidom

schedule_xml = "https://www.socallinuxexpo.org/scale12x/sign.xml"

def download_schedule(xml):
    dom = minidom.parse(urllib.urlopen(xml))
    return dom

dom = download_schedule("https://www.socallinuxexpo.org/scale12x/sign.xml")

for node in dom.getElementsByTagName('node'):
    print node.getElementsByTagName("Title")[0]
