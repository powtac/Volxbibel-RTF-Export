<?php
/*
 * Basic functions for the export
 * Simon Bruechner 2008, 2012
 */


/**
 *
 * @staticvar string $c
 * @param <type> $url
 * @return <type> 
 */
function http($url) {
    static $c = NULL;

    if ($c === NULL) {
        $req1 =& new HTTP_Request(WIKI_SERVER.'api.php?action=login&lgname='.WIKI_USER.'&lgpassword='.WIKI_PASSWORD.'&format=php', array('allowRedirects' => true));
        $req1->sendRequest();
        $cookiesToAtach = array('volxbibel_db_atUserID', 'volxbibel_db_atUserName', 'volxbibel_db_atToken');

        foreach ($req1->getResponseCookies() as $cookie) {
            foreach ($cookie as $key => $value) {
                if ($key === 'name') {
                    if (in_array($value, $cookiesToAtach)) {
                        $c[$value] = $cookie['value'];
                    }
                }
            }
        }
    }

    $req =& new HTTP_Request($url, array('allowRedirects' => true));
    foreach ($c as $key => $value) {
        $req->addCookie($key, $value);
    }

    $req->sendRequest();
    $return = $req->getResponseBody();

    return $return;
}

/**
 *
 * @param <type> $string
 * @param <type> $templateNr
 * @return <type>
 */
function makeUrl($string, $templateNr = 0) {
    $string = urlencode($string);

    $template[0] = WIKI_SERVER.'api.php?prop=revisions&action=query&titles='.TEMPLATE_PAGE_NAME.'&rvprop=content&format=php';
    $template[1] = WIKI_SERVER.'api.php?action=query&prop=links&titles='.TEMPLATE_PAGE_NAME.'&format=php';

    $return = str_replace(TEMPLATE_PAGE_NAME, $string, $template[$templateNr]);
    return $return;
}


function convertWiki($text) {
    
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

    $text = htmlentities($text, NULL, 'UTF-8');
    $text = str_replace(array('&bdquo;', '&sbquo;', '“', '&ldquo;'), '"', $text).' ';

    $text = html_entity_decode($text);

    $wiki = &new Text_Wiki_Mediawiki($rules);
    $wiki->setRenderConf('Xhtml', 'Url', 'target', '');
    $wiki->setRenderConf('Xhtml', 'wikilink', 'view_url', 'http://'.$_SERVER['SERVER_NAME'].'/');

    $wiki->parse($text);
    $output = $wiki->render();

    return $output;
}
