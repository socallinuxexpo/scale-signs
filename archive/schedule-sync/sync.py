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

    request = "{0}{1}{2}?api_key={3}&format=json&strip_html=Y&custom_data=Y&session_start={4}&session_end={5}" .\
              format(sched_org_url,
                     sched_org_session,
                     sched_org_add,
                     sched_org_api_key,
                     talk_data['start_time'],
                     talk_data['end_time'],
                     session_endt,
              )

    payload = {'session_key': talk_id,
               'name': talk_data['title'],
               'session_start': talk_data['start_time'],
               'session_type': talk_data['topic'],
               'description': talk_data['short_abstract'],
               'venue': talk_data['room'],
               'scale_speaker': talk_data['scale_speaker'],
               } 

    r = requests.get(request, params=payload)
    print r.url

def modify_talk(talk_id, talk_data):
    print talk_id, talk_data

def download_schedule(xml):
    #dom = minidom.parse(urllib.urlopen(xml))
    dom = minidom.parse("sign.xml")
    return dom

def main():

    schedule_xml = "https://www.socallinuxexpo.org/scale12x/sign.xml"
    dom = download_schedule("http://www.socallinuxexpo.org/scale12x/sign.xml")

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

        topic = node.getElementsByTagName('Topic')[0].childNodes[0].nodeValue
        short_abstract = node.getElementsByTagName('Short-abstract')[0].childNodes[0].nodeValue

        if len(node.getElementsByTagName('Photo')[0].childNodes) > 0:
            photo = node.getElementsByTagName('Photo')[0].childNodes[0].nodeValue
        else:
            photo = ""

        parser.feed(talk_time)
        start_time = datetime.strptime(parser.results['date-display-start'], \
                    "%Y-%m-%dT%H:%M:%S-08:00").strftime("%Y-%m-%d+%H:%M%p").lower()

        end_time = datetime.strptime(parser.results['date-display-end'], \
                   "%Y-%m-%dT%H:%M:%S-08:00").strftime("%Y-%m-%d+%H:%M%p").lower()

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
        talks_from_xml[talk_id]['short_abstract'] = strip_tags(short_abstract)

    request = "{0}{1}{2}?api_key={3}&format=json&strip_html=Y&custom_data=Y" .\
              format(sched_org_url,
                     sched_org_session,
                     sched_org_export,
                     sched_org_api_key)

    r = requests.get(request)
    r.encoding = 'utf-8'
    json_results = r.json()

    talks_from_sched_org = {}
    for item in json_results:
        talk_id = item['event_key']
        talks_from_sched_org[talk_id] = {}

        talks_from_sched_org[talk_id]['title'] = item['name']
        talks_from_sched_org[talk_id]['room'] = item['venue']

        if 'scale_speaker' in item:
            talks_from_sched_org[talk_id]['scale_speaker'] = item['scale_speaker']
        else:
            talks_from_sched_org[talk_id]['scale_speaker'] = ""

        talks_from_sched_org[talk_id]['start_time'] = item['event_start']
        talks_from_sched_org[talk_id]['end_time'] = item['event_end']

        if 'description' in item:
            talks_from_sched_org[talk_id]['short_abstract'] = item['description']
        else:
            talks_from_sched_org[talk_id]['short_abstract'] = ""

    for talk in talks_from_xml:
        print talk
        if talk in talks_from_sched_org:
            print "talk in sched.org, compare values"
        else:
            print "talk not in sched.org, add"
            #add_talk(talk, talks_from_xml[talk])        

if __name__ == "__main__":
    main()
