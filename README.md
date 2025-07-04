# Volxbibel RTF Export

Dieses Repository enthält ein PHP-Skript, das Inhalte aus einer MediaWiki-Installation sammelt und in ein Rich-Text-Format-Dokument (RTF) umwandelt. Ziel ist es, komplette Kapitel der Volxbibel offline oder zum Ausdrucken bereitzustellen.

## Zweck
Der Exporter ruft die definierten Seiten über die MediaWiki-API ab, wandelt das Wiki-Markup mit `Text_Wiki_Mediawiki` in HTML um und erzeugt daraus mithilfe einer RTF-Bibliothek ein zusammenhängendes Dokument. So lassen sich einzelne Bücher der Volxbibel komfortabel weiterverarbeiten.

## Installation
1. `wikiexport/config/config.template.php` nach `config.php` kopieren.
2. In `config.php` `WIKI_SERVER` auf die Basis-URL des Wikis ohne abschließenden `/` setzen.
3. `WIKI_USER` und `WIKI_PASSWORD` mit einem Benutzer füllen, der die nötigen Leserechte besitzt.
4. Benötigte PEAR-Pakete installieren:

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
│   └── jesusrockt.php  # Beispiel für einzelne Kapitel
├── __old            # Archiv alter Skripte
└── README.md
```
Die Konfigurationsdateien regeln, welche Bücher exportiert werden. Unter `libs/rtf` liegt die Bibliothek zur Erstellung der RTF-Dateien.

## Lizenz
Der Großteil des Codes steht unter der [MIT-Lizenz](http://de.wikipedia.org/wiki/MIT-Lizenz). Die RTF-Bibliothek im Ordner `libs/rtf` stammt von Dritten und kann eine abweichende Lizenz besitzen.

## Kontakt
Fragen oder Fehler bitte als [Issue](https://github.com/powtac/Volxbibel-RTF-Export/issues) melden.

Autor: [Simon Brüchner](http://www.bruechner.de) (2008, 2012)
