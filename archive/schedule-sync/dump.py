#!/usr/bin/env python

import hashlib
import requests
import os
import time
import urllib

from datetime import datetime
from xml.dom import minidom

from HTMLParser import HTMLParser
from htmlentitydefs import name2codepoint

from settings import *

import unicodedata

os.getenv('PYTHONIOENCODING', 'utf-8')

sched_org_url = "http://scale12x2014.sched.org/api"
sched_org_session = "/session"
sched_org_export = "/export"
sched_org_add = "/add"
sched_org_mod = "/mod"

class MLStripper(HTMLParser):
    def __init__(self):
        self.reset()
        self.fed = []
    def handle_data(self, d):
        self.fed.append(d)
    def get_data(self):
        return ''.join(self.fed)

def strip_tags(html):
    s = MLStripper()
    s.feed(html)
    return s.get_data()

class TimeSpanParser(HTMLParser):
    def __init__(self):
        HTMLParser.__init__(self)
        self.results = {}

    def handle_starttag(self, tag, attrs):
        property = None
        for attr in attrs:
            if attr[0] == 'class':
                property = attr[1] 
                self.results[property] = ""
            elif attr[0] == 'content':
                self.results[property] = attr[1]
            else:
                pass

def add_talk(talk_id, talk_data):

    #session_key
    #name
    #session_start
    #session_end
    #session_type
    #description
    #venue
    #address
    #scale_speaker

    request = "{0}{1}{2}?api_key={3}&session_start={4}&session_end={5}" .\
              format(sched_org_url,
                     sched_org_session,
                     sched_org_add,
                     sched_org_api_key,
                     talk_data['start_time'],
                     talk_data['end_time'],
              )

    payload = {'session_key': talk_id,
               'name': talk_data['title'],
               'session_type': talk_data['topic'],
               'description': talk_data['short_abstract'],
               'venue': talk_data['room'],
               'scale_speaker': talk_data['scale_speaker'],
               } 

    r = requests.get(request, params=payload)
    print r.url

def mod_talk(talk_id, mod_items):

    request = "{0}{1}{2}?api_key={3}" .\
              format(sched_org_url,
                     sched_org_session,
                     sched_org_mod,
                     sched_org_api_key,
              )

    payload = {'session_key': talk_id}

    if 'title' in mod_items:
        payload['name'] = mod_items['title']

    if 'topic' in mod_items:
        payload['session_type'] = mod_items['topic']

    if 'short_abstract' in mod_items:
        payload['description'] = mod_items['short_abstract']

    if 'room' in mod_items:
        payload['venue'] = mod_items['room']

    if 'scale_speaker' in mod_items:
        payload['scale_speaker'] = mod_items['scale_speaker']

    r = requests.get(request, params=payload)

def download_schedule(xml):
    #dom = minidom.parse(urllib.urlopen(xml))
    dom = minidom.parse("sign.xml")
    return dom

def main():

    schedule_xml = "https://www.socallinuxexpo.org/scale/13x/sign.xml"
    dom = download_schedule("http://www.socallinuxexpo.org/scale/13x/sign.xml")

    parser = TimeSpanParser()

    talks_from_xml = {}
    for node in dom.getElementsByTagName('node'):
        title = node.getElementsByTagName('Title')[0].childNodes[0].nodeValue
        room = node.getElementsByTagName('Room')[0].childNodes[0].nodeValue
        day = node.getElementsByTagName('Day')[0].childNodes[0].nodeValue
        talk_time = node.getElementsByTagName('Time')[0].childNodes[0].nodeValue

        if len(node.getElementsByTagName('Speaker')[0].childNodes) > 0:
            speaker = node.getElementsByTagName('Speaker')[0].childNodes[0].nodeValue
        else:
            speaker = ""

        if len(node.getElementsByTagName('Topic')[0].childNodes) > 0:
            topic = node.getElementsByTagName('Topic')[0].childNodes[0].nodeValue
        else:
            topic = ''

        if len(node.getElementsByTagName('Short-abstract')[0].childNodes) > 0:
            short_abstract = node.getElementsByTagName('Short-abstract')[0].childNodes[0].nodeValue
        else:
            short_abstract = ''

        if len(node.getElementsByTagName('Photo')[0].childNodes) > 0:
            photo = node.getElementsByTagName('Photo')[0].childNodes[0].nodeValue
        else:
            photo = ""

        parser.feed(talk_time)
        start_time = datetime.strptime(parser.results['date-display-start'], \
                    "%Y-%m-%dT%H:%M:%S-08:00").strftime("%Y-%m-%d+%I:%M%p").lower()

        end_time = datetime.strptime(parser.results['date-display-end'], \
                   "%Y-%m-%dT%H:%M:%S-08:00").strftime("%Y-%m-%d+%I:%M%p").lower()

        m = hashlib.md5()
        m.update("{0} {1}" . format(room, start_time))
        talk_id = m.hexdigest()
        talks_from_xml[talk_id] = {}
        talks_from_xml[talk_id]['title'] = title
        talks_from_xml[talk_id]['topic'] = topic
        talks_from_xml[talk_id]['room'] = room
        talks_from_xml[talk_id]['scale_speaker'] = speaker
        talks_from_xml[talk_id]['start_time'] = start_time
        talks_from_xml[talk_id]['end_time'] = end_time
        #talks_from_xml[talk_id]['short_abstract'] = strip_tags(short_abstract)[1:].replace('  ',' ')
        talks_from_xml[talk_id]['short_abstract'] = short_abstract

    for talk in talks_from_xml:
        title = unicodedata.normalize('NFKD', talks_from_xml[talk]['title']).encode('ascii','ignore')[:40]
        day = talks_from_xml[talk]['start_time'].split('+')[0]
        start_time = talks_from_xml[talk]['start_time'].split('+')[1]
        end_time = talks_from_xml[talk]['end_time'].split('+')[1]
        print '{0}|{1}|{2}|{3}|{4}'.format(title, talks_from_xml[talk]['room'], start_time, end_time, day)

if __name__ == "__main__":
    main()
