<?php
/**
 * Holt die Kapitel von Jesus Rockt und baut einen Download Link zusammen
 */
require_once dirname(__FILE__).'/config/bootstrap.php';


define('CHAPTER_LIST_WIKI_ARTICLE', 'Jesus_Rockt_Die_Kapitel');

$chapter = http(makeUrl(CHAPTER_LIST_WIKI_ARTICLE));

echo '<pre>';
$chapter = unserialize($chapter);
$chapter = $chapter['query']['pages'][2426]['revisions'][0]['*'];

$chapter = explode('----', $chapter);
$chapter = trim($chapter[1]);

$chapter = str_replace(array('[[', ']]'), '', $chapter);

$chapter = trim($chapter);

$chapter = explode("\n\n", $chapter);


$query = '';
foreach ($chapter as $chapt) {
    $tmp =           str_replace(array(' ', '?'), array(' ', '%3F'), htmlentities($chapt, ENT_NOQUOTES, 'UTF-8'));

    $raw = unserialize(http(makeUrl($tmp)));

    echo '<br>';
    echo '<a href="'.WIKI_SERVER.'/index.php/'.$tmp.'">'.$tmp.'</a> ';

    if (!is_array($raw) OR !isset($raw['query']['pages'][-1]['missing'])) {
        echo ' <span style="color:green;font-weight:bold">Kapitelname OK</span>';
        echo ' <a href="./index.php?page_name='.$tmp.'">Export</a>';
    } else {
        echo ' <span style="color:red">Kapitelname nicht Ok, bitte checke auf <a href="'.WIKI_SERVER.'/index.php/'.CHAPTER_LIST_WIKI_ARTICLE.'">der Kapitelliste</a> ob der Eintrag "<strong>'.$chapt.'</strong>" auf den exakt gleich geschrieben Artikel verlinkt und ob er einen Inhalt hat!</span>';
    }


    #$query .= $tmp.'|';
}

#$query = trim($query, '|');

#echo '<br /><br /></pre><a href="./getPageNbr.php?notsort=1&page_name='.$query.'">Jesus Rockt exportieren</a>';


// Query mit allen Büchern funktioniert nicht weil sort auf wiki seite angewendet wird wenn die artikel geholt werden.