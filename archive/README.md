# scale-signs

digital signs for the Southern California Linux Expo

## Background

This codebase is currently in **maintenance mode** and has been since SCaLE 15x. There is another project underway to redo both the client and server components. Maintenance of this project will continue through at least SCaLE 17x in parallel to the new project. This code has served SCaLE well for the last decade with attendees coming to expect quality electronic signs are part of the core conference experience. The new project will look to build on much of the functionality and style that has been established.

### Server

* php5 on apache
* pulls an XML version of the conference speaking schedule down for the public socallinuxexpo.org web server
* pulls a twitter feed of SCaLE related hashtags
* sends fully formatted HTML to clients with the scale logo, wifi password, a scrolling schedule, sponsor logos, and relevant tweets

### Client

* python script using the GTK library to simulate a full screen web browser which typically runs on raspberry pis

### Local Testing:

  * vagrant 2.1
  * virtualbox 5.2

`vagrant up`
