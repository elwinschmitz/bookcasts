📚🔈 BookCasts
==============

Turn audiobooks into podcasts.

Do you have a folder of audio-files?
Do you want to listen to it in your favorite podcast-app?


## Requirements
- Webhosting space (enough to fit your audio-files)
- PHP running on it


## Setup:
- Copy the file `bookcast.xml.php` into your folder of audio-files.
- Add an optional `coverart.jpg/jpeg/png` file
- Add an optional `metadata` or `metadata.ini` file with , for example, this contents: (all optional)
  ```ini
  language = en
  copyright = 2019, The Publisher
  description = A description of the audio-book.
  link = https://example.com/book/
  ```

- Upload the folder to your webhost.
- Add the URL (`your-webhost.example.com/this-bookcast/bookcast.xml.php`) to your podcast-app.
- Start downloading & listening!


## Configuration / Options
You can tweak the following options: (in the top of `bookcast.xml.php`):

- `META_DATA_FILE_NAME`  
	If you want to use a different metadata file.
- `COVER_ART_FILE_NAME`  
	If you want to include different image-files/formats.
- `AUDIO_FILE_TYPES`  
	If you want to use different audio-files.

The syntax used is from `glob()`, see an explanation in the  [PHP manual](https://www.php.net/manual/en/function.glob.php).


## Supported / Testing
- The output is a valid feed, according to [W3C Feed Validation Service](https://validator.w3.org/feed/).
- The feed works (good enough) in [Overcast](https://overcast.fm/).
- It might also work in your favorite podcast-app, who knows.


## About
This thing is just an idea and very 'work-in-progress'.
It was created to scratch my own itch; Maybe it also works for you.

Suggestions and ideas are always welcome.  
[Create an issue](https://github.com/elwinschmitz/bookcasts/issues/new)
 or take a look at all the '_[things I already thought of but didn't get to yet](https://github.com/elwinschmitz/bookcasts/projects)_'.
