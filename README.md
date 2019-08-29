📚🔈 BookCasts
==============

Turn audiobooks into podcasts.  

Do you have a folder of audio-files?
Do you want to listen to it in your favorite podcast-app?

## Requirements
- Webhosting space (enough to fit your audio-files)
- PHP running on it

## Setup:
- Copy the file `php/bookcast.xml.php` into your folder of audio-files.
- Edit the `$channel = [ ... ];`-object to include all titles, descriptions and URLs.
- Upload the folder to your webhost.
- Add the URL (`your-webhost.example.com/this-bookcast/bookcast.xml.php`) to your podcast-app.
- Start downloading & listening!

(And yes, you've basically just created a podcast-feed by hand; But I'm working on it...)
