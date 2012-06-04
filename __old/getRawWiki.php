<?php
/*
 * Volxbibel RTF Export
 * Simon Bruechner, 29.08.2008
 */


function getRawWiki($url) {
    require_once 'HTTP/Request.php';

    #echo $url;

    $req1 =& new HTTP_Request(WIKI_SERVER.'/api.php?action=login&lgname='.WIKI_USER.'&lgpassword='.WIKI_PASSWORD.'&format=phpfm', array('allowRedirects' => true));
    $req1->sendRequest();
    #echo '<pre>';
    #var_dump($req1->getResponseCookies());

    $cookiesToAtach = array('volxbibel_db_atUserID', 'volxbibel_db_atUserName', 'volxbibel_db_atToken');



    $req =& new HTTP_Request($url, array('allowRedirects' => true));
    foreach ($req1->getResponseCookies() as $cookie) {
        foreach ($cookie as $key => $value) {
            if ($key === 'name') {
                if (in_array($value, $cookiesToAtach)) {
                    $req->addCookie($value, $cookie['value']);
                }
            }
        }
    }
    $req->sendRequest();

    $allResponse = unserialize($req->getResponseBody());

    #var_dump($allResponse);
    #exit;

    #$rawWiki = $allResponse['query']['pages'][1]['revisions'][0]['*'];
    $rawWiki = $allResponse['query']['pages'][72]['revisions'][0]['*'];

    $rawWiki = /*utf8_decode*/($rawWiki);
    #var_dump($rawWiki);
    #exit;

    return $rawWiki;
}


// debug
//echo '<pre>';
//echo getRawWiki('http://wiki:wiki@85.10.211.16/wiki/api.php?action=query&prop=revisions&titles=Hauptseite&rvprop=timestamp|user|comment|content&format=php');
?>