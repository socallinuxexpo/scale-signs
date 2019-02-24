# scale-signs

digital signs for the Southern California Linux Expo

## Background

This codebase is currently in **maintenance mode** and has been since SCaLE 15x. There is another project underway to redo both the client and server components. Maintenance of this project will continue through at least SCaLE 17x in parallel to the new project. This code has served SCaLE well for the last decade with attendees coming to expect quality electronic signs are part of the core conference experience. The new project will look to build on much of the functionality and style that has been established.

### Server

* php5.4 with Apache httpd
* pulls an XML version of the conference speaking schedule down for the public socallinuxexpo.org web server
* pulls a twitter feed of SCaLE related hashtags
* sends fully formatted HTML to clients with the scale logo, wifi password, a scrolling schedule, sponsor logos, and relevant tweets

### Client

* python script using the GTK library to simulate a full screen web browser which typically runs on raspberry pis

### Views

* Full Schedule - The index.php page will display a carousel with a grid view of all currently running and upcoming sessions. The PI displays should use this view.
* Room View - The index.php page can be called with a room argument to display a room specific view that will alternate the upcoming or current session with a picture of the speaker or the room sponsor(s). Example: `http://$sign_server/?room=ballroom-a`. The keys in the $room_lookup_table in room.php can be referenced for a full list of room names.
* Debugging / Development - It is sometimes necessary to test alternate times. In order to do this the following variables must be modified in the `uri: $year, $month, $day, $hour, $minute`. Example: `http://$sign_server/?year=2019&month=3&day=7&hour=9&minute=10`. This can be used with either the Full Schedule or Room view.

### Yearly Tasks

There is a bit of manual effort necessary from year to year. These tasks include, but might not be limitted to:
* update the logo for the curent year at `/server/images/header.png`
* Do a search and replace for the previous scale version (example: replace all occurances of 16x with 17x)
* verify proper XML is being supplied by drupal from the url reflected in the `$url` variable in `room.php` and `scroll.php`
* set `$starttime` in `scroll.php` which should reflect midnight of the first night of current year show
* set `$starttime` in `room.php` to match scroll.php
* set `$room_lookup_table` in `room.php` to match all rooms being used for the current year
* update `$shorten_topics` in `scroll.php` to reflect the updated track list, matching exactly the keys to what is being supplied by the xml from drupal
* update `$shorten_topics` in `room.php` to match `scroll.php`
* create a style for each of the keys in `$shorten_topics` in `style.css`
* update the sponsor images in `/server/images/sponsors/` to reflect the current year's sponsors, making them 220x220
* update `$sponsors` in `room.php` matching the value to each sponsor image file name
* update `$sponsors_to_rooms` in `room.php` matching proper sponsor(s) to room and day by key from `$sponsors`
* verify OAUTH keys and secrets being passed to `$settings` in `twitter.php` via `secrets.env` are functional

### Conference Operations

* git
* docker
* docker-compose

#### DST Issues

If DST changes during SCaLE, the next morning `$starttime` in `scroll.php` and `room.php` will need to be adjusted by an hour otherwise the schedule will be off. This should be as simple as following the instructions in the comments at the top of each file.

#### Build and start Service

1. `git pull $this_repo`
2. copy `samples-secrets.env` to `secrets.env` and populate with correct values
3. `docker-compose up -d`

#### Update from repo

1. `git pull $this_repo`
2. `docker-compose down`
3. `docker-compose build`
4. `docker-compose up -d`

#### Troubleshooting Basics

* `docker-compose ps`
* `docker-compose logs [-f]`
* `docker-compose top`

### Local Testing:

* docker
* docker-compose

1. `touch secrets.env` to omit secrets or copy `sample-secrets.env` to `secrets.env` and populate to test with them
2. `docker-compose build`
3. `docker-compose up -d`
4. browse to `http://localhost`
