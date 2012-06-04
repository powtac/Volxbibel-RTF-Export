<?php
/*
 * tests
 * Simon Bruechner, 29.08.2008
 */
// debug
//require_once dirname(__FILE__).'/getRawWiki.php';
//$text = getRawWiki($url);

function convertWiki($text) {

    #var_dump($text);

    require_once 'Text/Wiki.php';
    require_once 'Text/Wiki/Render/Xhtml/Url.php';
    require_once 'Text/Wiki/Mediawiki.php';

    $rules = array(
      'Prefilter',
      'Delimiter',
      'Raw',
      'Preformatted',
      'Heading',
      'Toc',
      'Horiz',
      'Break',
      'List',
      'Deflist',
      'Table',
      'Newline',
      'Paragraph',
      'Url',
      'Wikilink',
      'Freelink',
      'Emphasis',
      'Tighten',
    );



    $text = preg_replace('~\{\{.{1,25}\}\}~', '', $text);
    $text = str_replace('__TOC__', '', $text);
    $text = str_replace('[[Kategorie:Jesus Rockt]]', '', $text);

#$text = utf8_encode($text);
    $text = htmlentities($text, NULL, 'UTF-8');
//    var_dump($text);
//    exit;
    $text = str_replace(array('&bdquo;', '&sbquo;', '“', '&ldquo;'), '"', $text).' ';

    $text = html_entity_decode($text);
    #$text = utf8_decode($text);

#var_dump($text);exit;
    $wiki = &new Text_Wiki_Mediawiki($rules);
    $wiki->setRenderConf('Xhtml', 'Url', 'target', '');
    $wiki->setRenderConf('Xhtml', 'wikilink', 'view_url', 'http://'.$_SERVER['SERVER_NAME'].'/');

    $wiki->parse($text);
    $output = $wiki->render();

    #echo ($output); exit;
    return /*html_entity_decode*/($output);
}
?>