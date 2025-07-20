```
 __      __   _   _          _     _      ____  _______ ______
 \ \    / /__| |_| |__   ___| |__ (_)_ __| __ )|__   __|  ____|
  \ \/\/ / _ \ __| '_ \ / _ \ '_ \| | '__|  _ \   | |  | |__
   \_/\_/  __/ |_| | | |  __/ |_) | | |  | |_) |  | |  |  __|
            \___|\__|_| |_|\___|_.__/|_|_|  |____/   |_|  |_____|

           Volxbibel Wiki -> RTF Export
```

# Volxbibel RTF Export

Dieses Repository enthaelt ein PHP-Skript, das Inhalte aus einer MediaWiki-Installation sammelt und in ein Rich-Text-Format-Dokument (RTF) umwandelt. Ziel ist es, komplette Kapitel der Volxbibel offline oder zum Ausdrucken bereitzustellen.

## Zweck
Der Exporter ruft die definierten Seiten ueber die MediaWiki-API ab, wandelt das Wiki-Markup mit `Text_Wiki_Mediawiki` in HTML um und erzeugt daraus mithilfe einer RTF-Bibliothek ein zusammenhaengendes Dokument. So lassen sich einzelne Buecher der Volxbibel komfortabel weiterverarbeiten.

## Technologien
- PHP (>=5)
- [PEAR HTTP_Request](http://pear.php.net/package/HTTP_Request) fuer die HTTP-Kommunikation
- [PEAR Text_Wiki_Mediawiki](http://pear.php.net/package/Text_Wiki_Mediawiki) zur Umwandlung von Wiki-Syntax in HTML
- Eine einfache PHP-basierte RTF-Bibliothek in `wikiexport/libs/rtf`

## Installation
1. `wikiexport/config/config.template.php` nach `config.php` kopieren.
2. In `config.php` `WIKI_SERVER` auf die Basis-URL des Wikis ohne abschliessenden `/` setzen.
3. `WIKI_USER` und `WIKI_PASSWORD` mit einem Benutzer fuellen, der die noetigen Leserechte besitzt.
4. Benoetigte PEAR-Pakete installieren:

```bash
pear install --force --alldeps HTTP_Request Text_Wiki_Mediawiki
```

## Voraussetzungen
- PHP 5 oder neuer
- PEAR-Pakete `HTTP_Request` und `Text_Wiki_Mediawiki`

## Nutzung
`wikiexport/index.php` kann im Browser oder per Kommandozeile aufgerufen werden. Das Skript liest die in `wikiexport/config/books.php` hinterlegten Kapitel und bietet ein fertiges RTF zum Download an.

## Projektstruktur
```text
Volxbibel-RTF-Export
├── wikiexport
│   ├── config       # Konfiguration und Hilfsfunktionen
│   ├── libs         # eingebundene Bibliotheken, u.a. die RTF-Bibliothek
│   ├── index.php    # Haupteinstieg zum Export
│   └── jesusrockt.php  # Beispiel fuer einzelne Kapitel
├── __old            # Archiv alter Skripte
└── README.md
```
Die Konfigurationsdateien regeln, welche Buecher exportiert werden. Unter `libs/rtf` liegt die Bibliothek zur Erstellung der RTF-Dateien.

## Lizenz
Der Grossteil des Codes steht unter der [MIT-Lizenz](http://de.wikipedia.org/wiki/MIT-Lizenz). Die RTF-Bibliothek im Ordner `libs/rtf` stammt von Dritten und kann eine abweichende Lizenz besitzen.

## Kontakt
Fragen oder Fehler bitte als [Issue](https://github.com/powtac/Volxbibel-RTF-Export/issues) melden.

Autor: [Simon Bruechner](http://www.bruechner.de) (2008, 2012)
