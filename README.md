```
 __      __   _   _          _     _      ____  _______ ______
 \ \    / /__| |_| |__   ___| |__ (_)_ __| __ )|__   __|  ____|
  \ \/\/ / _ \ __| '_ \ / _ \ '_ \| | '__|  _ \   | |  | |__   
   \_/\_/  __/ |_| | | |  __/ |_) | | |  | |_) |  | |  |  __|  
            \___|\__|_| |_|\___|_.__/|_|_|  |____/   |_|  |_____| 
 
           Volxbibel Wiki -> RTF Export
```

The Volxbibel RTF Export is a small PHP application for converting pages
from a MediaWiki installation into Rich Text Format files. It was initially
created to generate printable versions of the collaborative "Volxbibel"
Bible translation. The exporter logs in to the wiki, fetches the requested
pages via the MediaWiki API, transforms the wiki markup into HTML using
PEAR's Text_Wiki_Mediawiki parser and finally renders an RTF document
with a lightweight RTF library.

## Technologies
- PHP (>=5)
- [PEAR HTTP_Request](http://pear.php.net/package/HTTP_Request) for HTTP
  communication with the wiki
- [PEAR Text_Wiki_Mediawiki](http://pear.php.net/package/Text_Wiki_Mediawiki)
  for converting wiki syntax to HTML
- A simple PHP based RTF library located in `wikiexport/libs/rtf`

## Project structure
- `wikiexport` contains the PHP scripts, configuration files and the RTF
  library used for the export.
- `__old` holds early experiments and is kept for reference only.

The configuration is done in `wikiexport/config/config.php`. Copy the
`config.template.php` file and adjust the constants `WIKI_SERVER`,
`WIKI_USER` and `WIKI_PASSWORD` so that the script can access your
MediaWiki installation. Once configured, calling `index.php` will produce
an RTF file containing the selected pages.

### How to use
+ Rename `/config/config.template.php` into `config.php`.
+ Set the constant `WIKI_SERVER`, to the domain and path to your MediaWiki installation, with `http://` but no trailing `/`.
+ Set `WIKI_USER` and `WIKI_PASSWORD` for a wiki user which has the rights to export data from the MediaWiki.

### Requirements
* PHP > 5

PEAR Packages and all their dependencies, see `/config/bootstrap.php`:
* HTTP_Request
* Text_Wiki_Mediawiki

They can be installed by `pear install --force --alldeps HTTP_Request Text_Wiki_Mediawiki`.

### Support and Contact
Please fill in a [Issue](https://github.com/powtac/Volxbibel-RTF-Export/issues).

### Author
[Simon Brüchner](http://www.bruechner.de) 2008, 2012

### License
[MIT](http://de.wikipedia.org/wiki/MIT-Lizenz) for all the code I coded. There is also a [rtf](https://github.com/powtac/Volxbibel-RTF-Export/tree/master/wikiexport/libs/rtf) library in the libs folder but I don't know where it is from...

### Module overview
The project is organized in a few main directories:

```
Volxbibel-RTF-Export
├── wikiexport
│   ├── config       # configuration and helper functions
│   ├── libs         # bundled libraries such as the RTF exporter
│   ├── index.php    # main export script
│   └── jesusrockt.php  # helper for Jesus Rockt chapters
├── __old            # archived scripts
└── README.md
```

The `wikiexport/config` folder contains PHP scripts for setting up the
exporter and listing the available books. The `libs/rtf` folder bundles
the third‑party library used to create RTF files. `index.php` builds the
RTF document using data pulled from the MediaWiki API.
