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
    static $cookies = null;

    if ($cookies === null) {
        
        $apiUrl = WIKI_SERVER.'api.php?action=login&lgname='.WIKI_USER.'&lgpassword='.WIKI_PASSWORD.'&format=php';

        $loginRequest = new HTTP_Request($apiUrl, array('allowRedirects' => true));
        $loginRequest->sendRequest();
        $cookiesToAttach = array('volxbibel_db_atUserID', 'volxbibel_db_atUserName', 'volxbibel_db_atToken');

        foreach ($loginRequest->getResponseCookies() as $cookie) {
            foreach ($cookie as $key => $value) {
                if ($key === 'name') {
                    if (in_array($value, $cookiesToAttach)) {
                        $cookies[$value] = $cookie['value'];
                    }
                }
            }
        }
    }

    $httpRequest = new HTTP_Request($url, array('allowRedirects' => true));
    foreach ($cookies as $key => $value) {
        $httpRequest->addCookie($key, $value);
    }

    $httpRequest->sendRequest();
    $return = $httpRequest->getResponseBody();

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

    $wiki = new Text_Wiki_Mediawiki($rules);
    $wiki->setRenderConf('Xhtml', 'Url', 'target', '');
    $wiki->setRenderConf('Xhtml', 'wikilink', 'view_url', 'http://'.$_SERVER['SERVER_NAME'].'/');

    $wiki->parse($text);
    $output = $wiki->render();

    return $output;
}
