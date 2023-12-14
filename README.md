# Sputnik pdf form

Fill a pdf form and save it in a closed file.

## Requirement

### pdftk port to java >= 3.3.2

https://gitlab.com/pdftk-java/pdftk

### php-pdftk

https://github.com/mikehaertl/php-pdftk

#### Install on mac

```brew install pdftk-java```

#### Install on linux

```wget http://ftp.debian.org/debian/pool/main/p/pdftk-java/pdftk-java_3.3.2-1_all.deb && sudo apt install ./pdftk-java_3.3.2-1_all.deb```

## Usage

* [Example to fill a pdf form and write it in a file](./example/fillFormAndSavePdf.php)
** show how to fill a pdf form with multiple source files and how to overwrite the pdf font file
* [Example to fill a pdf form and send it to browser](./example/fillFormAndSendToBrowser.php)
** show how to send file to browser without saving it

## Changelog

### 0.2.0

* Add support for pdf form with multiple source file
* Add overwrite for the pdf font file
