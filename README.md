### How to use
+ Rename `/config/config.template.php` into `config.php`.
+ Set the constant `WIKI_SERVER`, to the domain and path to your MediaWiki installation, with `http://` but no trailing `/`. 
+ Set `WIKI_USER` and `WIKI_PASSWORD` for a wiki user which has the rights to export data from the MediaWiki.

### Requirements
* PHP > 5

PEAR Packages and all their dependencies, see `/config/bootstrap.php`: 
* HTTP_Request
* Text_Wiki
* Text_Wiki_Mediawiki

They can be installed by `pear install --force --alldeps Text_Wiki_Mediawiki`.

### Support or Contact
Please fill in a [Issue](https://github.com/powtac/Volxbibel-RTF-Export/issues).

### Author
[Simon Brüchner](http://www.bruechner.de) 2008, 2012

### License
[MIT](http://de.wikipedia.org/wiki/MIT-Lizenz) for all the code I coded. There is also a rtf library in the libs folder but I don't know where it is from...