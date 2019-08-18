# Personal video streaming and downloading platform
Similar to Plex if you will

**Please read carefully and do as said if you want this to work properly.**

## Requirements
- Python 2.*, [ffmpeg](https://ffmpeg.org/download.html) and [bento4](https://www.bento4.com/downloads/) need to be installed and accessible in the website directory.
- `__future__` and `pathlib` extensions for python (use `python -m pip install pathlib` in the shell)
- Php, http and mysql server ([Wamp](http://www.wampserver.com/) for Windows, [Mamp](https://www.mamp.info) for Mac/Windows and Lamp for Linux are recommended)
- [Port redirections](#port-redirections)
- Disk space...


## Installation
Clone repo, setup php server to the cloning directory (see the documentation of the installed server).

### Folder organisation for movies and tv shows
- videos
     - movies
          - Movie1
               - vid
                    - manifest.mpd
                    - ... (mpeg-dash files)
               - thumb.jpg (thumbnail that will be displayed in the website, 4:3 format ratio is best)
               - vid.mp4 (file for download)
          - Movie2
          - ...
     - shows
          - Show1
               - S1
                    - E1
                         - vid
                              - manifest.mpd
                              - ...
                         - vid.mp4
                    - ...
               - ...
               - thumb.jpg
          - Show2
          - ...


### Converting .mp4 or .mkv to mpeg-dash format
The mpeg-dash format is the best for streaming as it fragments media files into 1 to 4 second chunks, sent separately to the client navigator.

To convert media files, use the ffmpeg and bento4 executables.

Use ffmpeg to convert all formats into mp4. For matroska (mkv), you can ask ffmpeg to copy streams to save time (`-c:copy` option).

Then, use mp4fragment from bento4 to fragment mp4 files : (this step is needed in order for the conversion to proceed)
`mp4fragment file.mp4 fragmented.mp4`

Finally use mp4dash to convert mp4 into mpeg-dash :
`mp4dash -o output_folder --mpd-name=manifest.mpd --use-segment-timeline --force fragmented.mp4`

To include subtitles, add `--subtitles` if the subtitles are encapsulated in the mp4 file, or `[+format=webvtt,+language='en']subtitles.srt` for external files.

#### Python utility for tv shows
For tv shows, we've created a small python script that automates the process.

Navigate to the `videos/shows/ShowTitle/S1/E1` folder for instance. Copy all episodes there and rename them `E1.mp4`, `E2.mp4`, `E3.mp4`... They can be either mp4 or mkv files.

You can use the filenamesRemoveSpacesAndParentheses.py utility to remove all spaces and parentheses of file names inside a folder.

If you have external subtitles, place them besides the episode files and name them `E1.srt`, `E2.srt`...

Copy mp4ToMpdThroughFragment.py into the folder and launch it. The utility will ask if you wish to include subtitles or not, and if they are internal or external subtitles.

When the utility has finished running, delete it.


## Setting up the mysql database
Your mysql server should contain a database called `streaming_server`. There should be two tables : `movies` and `users_watched`

Table configuration : [imgur.com/a/D18iNMM](https://imgur.com/a/D18iNMM)

You should create a user, having access to the `streaming_server` database (username: phpuser ; password: phpuser).

### Filling the database
Request a key at [omdbapi.com](http://omdbapi.com). In filldb/index.php, lines 78 and 134, replace `!!!YOUR-OMDB-KEY!!!` with your own key.

To fill the database, in your browser, navigate to localhost/filldb. (Your php/html server needs to be set up and launched)

All release dates known by the omdb database should be filled already. Fill the remaining ones for movies and click the "Submit movies to db".

Repeat for tv shows.

## Port redirections
You should, in your internet router configuration, redirect ports 80 and 3306 ports to your local machine (the one that hosts the server).

This will allow external devices to connect to your website from the internet.

You should have a fixed ip or sign up for dynamic ip services such as [no-ip.com](https://www.noip.com) or [dyn.com](https://dyn.com/dns/).

## Done !
If you followed properly theses instructions and set up properly your http/php server, you should be able to access your movies and tv shows from anywhere in th world.

Simply connect to your home ip in any browser.



