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


## About
This thing is just an idea and very 'work-in-progress'.
It was created to scratch my own itch; Maybe it also works for you.

Suggestions and ideas are always welcome.  
[Create an issue](https://github.com/elwinschmitz/bookcasts/issues/new)
 or take a look at all the '_[things I already thought of but didn't get to yet](https://github.com/elwinschmitz/bookcasts/projects)_'.
