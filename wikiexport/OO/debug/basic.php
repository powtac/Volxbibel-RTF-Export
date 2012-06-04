<?php
/**
 * Basic functions for the export
 */


/**
 *
 * @staticvar string $c
 * @param <type> $url
 * @return <type> 
 */
function http($url) {
    require_once 'HTTP/Request.php';

    static $c = NULL;

    if ($c === NULL) {
        $req1 =& new HTTP_Request('http://at.volxbibel.com/api.php?action=login&lgname='.WIKI_USER.'&lgpassword='.WIKI_PASSWORD.'&format=php', array('allowRedirects' => true));
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

    $template[0] = 'http://at.volxbibel.com/api.php?prop=revisions&action=query&titles='.TEMPLATE_PAGE_NAME.'&rvprop=content&format=php';
    $template[1] = 'http://at.volxbibel.com/api.php?action=query&prop=links&titles='.TEMPLATE_PAGE_NAME.'&format=php';

    $return = str_replace(TEMPLATE_PAGE_NAME, $string, $template[$templateNr]);
    return $return;
}