<?php
/*
 * Volxbibel RTF Export
 * Simon Bruechner, 2008, 2012
 */

require_once dirname(__FILE__).'/config/bootstrap.php';


function getAllChaptersOfBook($bookName) {
    global $books;
    foreach ($books[$bookName] as $value) {
        $return[] = $value['chapter'];
    }
    
    return $return;
}



if (!isset($_REQUEST[URL_PARAM_PAGE_NAME])) {
    echo '<html><head><title>Volxbibel AT Export</title>';
    echo '<style type="text/css">
      .chapter {
        display:block;
        margin-right:7px;
        float:left;
        border:1px solid white; 
      }
      
      .book {
        width:100%;
        border:1px solid white; 
        border-bottom: 1px solid gray;      
        clear:both;
        font-size:36px;
        padding-top:45px;
        display:block;
      }

      .chapters {
        margin-left:5px; 
      }
      
      a {
        text-decoration:none;
        color:black; 
      }
      
      .chapter:hover {
        background-color:#f0f0f0;
        border:1px solid black; 
      }

      .book:hover {
        background-color:#f0f0f0;
        border-bottom:1px solid black; 
      }
      #widmung {
        text-align:center;
        color:gray;
        padding-top:20px;
      }
    </style></head><body>';
    
    foreach ($books as $name => $bookDetails) {
        if ($name === 'Hiob') {
        	echo '<br clear="both" /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
        }
        echo '<a class="book" title="Das Buch '.htmlentities($name, ENT_NOQUOTES, 'UTF-8').' als Word-Datei downloaden." href="?'.URL_PARAM_PAGE_NAME.'='.implode('|', getAllChaptersOfBook($name)).'">'.htmlentities($name, ENT_NOQUOTES, 'UTF-8').'</a><div class="chapters">';
        foreach ($bookDetails as $key => $value) {
            echo '<a class="chapter" title="Das Kapitel '.htmlentities($value['chapter'], ENT_NOQUOTES, 'UTF-8').' als Word-Datei downloaden." href="?'.URL_PARAM_PAGE_NAME.'='.$value['chapter'].'">'.str_replace(array(' ', '?'), array(' ', '%3F'), htmlentities($value['chapter'], ENT_NOQUOTES, 'UTF-8')).'</a>';
        }
        echo '</div>';
    }
    echo '<br clear="both" />';
    echo '<div id="widmung">Gewidmet Martin D., f&uuml;r die Predigt auf der Mainstage 2008.</div></body></html>';
}

if (isset($_REQUEST[URL_PARAM_PAGE_NAME])) {
    $rawWikiCollection = '';

    $url = makeUrl($_REQUEST[URL_PARAM_PAGE_NAME]);

    $response = http($url);
    
    if (is_array(unserialize($response))) {
        
        $responseArray = unserialize($response);
        
        if (isset($responseArray['error'])) {
            echo '<pre>';
            echo var_export($responseArray['error']);
            echo '</pre>';
            die('An wiki error ocoured! Maybe this wiki does not allow to request that many pages at once!<br >Please increase gXXlimit in the config.');
        }
        
        $pages = $responseArray['query']['pages'];

        @natsort($pages);
        
        // Debug or not
        if (false) {
    
            foreach ($pages as $key => $page) {
                echo '<h1>'.$pages[$key]['title'].'</h1>';
                echo '<textarea cols="200" rows="20">'.$responseArray['query']['pages'][$key]['revisions'][0]['*'].'</textarea>';
            }
        
        } else {
            // rawHTML
            foreach ($pages as $key => $page) {

                $rawArray[$pages[$key]['title']] = $pages[$key]['revisions'][0]['*'];
                
                // only for sorting right!
                $sorted[$pages[$key]['title']] = $pages[$key]['title'];
            }
            
            // natsort works only this way with this second array $sorted.
            natsort($sorted);


            foreach ($rawArray as $key => $value) {
                $sorted[$key] = $value;
            }

            foreach ($sorted as $key => $value) {
                $rawWikiArray[] = '<h1>'.$key.'</h1>'.$value;
            }


            
            $rawWiki = implode(RTF_PAGE_BREAK_PATTERN, $rawWikiArray);
            
            $header  = 'Export aus dem at.volxbibel.com-Wiki.<br />';
            $header .= 'Am '.date('d.m').'<span />.'.date('Y').' um '.date('H:i').' Uhr.<br /><br />';
            
            $rawWiki = $header.$rawWiki;
            
            // HTML
            require_once dirname(__FILE__).'/libs/convertWiki.php';
            $html = convertWiki($rawWiki);
            
            // RTF
            require_once dirname(__FILE__).'/libs/rtf/class_rtf.php';
            
            $rtf = new rtf(dirname(__FILE__).'/libs/rtf/rtf_config.php');
            $rtf->setPaperSize(5);
            $rtf->setPaperOrientation(1);
            $rtf->setDefaultFontFace(0);
            $rtf->setDefaultFontSize(24);
            $rtf->setAuthor("Martin Dreyer");
            $rtf->setOperator("me@example.com");
            $rtf->setTitle("Volxbibel");
            $rtf->addColour("#000000");
            $rtf->document = $html;

            #$rtf->document = str_replace("</p>\n", '</p>', $rtf->document);    // for what?         
            $rtf->document = str_replace(htmlentities('<span />'), '', $rtf->document);            
            $rtf->document = str_replace(htmlentities('<div class="kapiteluebersicht">'), '', $rtf->document);            
            $rtf->document = str_replace(htmlentities('&rsquo;'), '"', $rtf->document);            
            #$rtf->document = str_replace(htmlentities('&hellip;'), '...', $rtf->document);            
           
			
			
            $rtf->parseDocument();
            
            if (!headers_sent()) {
                $rtf->getDocument();
            } else {
                die ('headers...');   
            }
            
        }

    } else {
//        echo '<pre>';
//        echo htmlentities($response);   
//        echo '</pre>';
    }
    
}






// Still required, dont delete!
//
// debug, just list all links from the main chapter pages
//echo '<pre>';
//
//$subfix = '\'),';
//$prefix = $subfix."\n".'    array(\'chapter\' => \'';
//$firstPrefix = str_replace($subfix, '', $prefix);
//$error = '';
//$linkToExclude = 'Benutzer:';
//
//foreach ($books2 as $book) {
//    
//    $url = makeUrl($book, 1);
//    $response = http($url);
//    $responseArray = unserialize($response);
//    foreach ($responseArray['query']['pages'] as $key => $page) {
//        if ($book !== $responseArray['query']['pages'][$key]['title']) {
//            die ('Wrong title!');  
//        }
//        $book = utf8_decode($book);
//        
//        if (!is_array($responseArray['query']['pages'][$key]['links'])) {
//            $error .= 'In book "'.$book.'" links to the chapters are missing! <br />';
//        } else {
//        
//            foreach ($responseArray['query']['pages'][$key]['links'] as $key => $links) {
//                if (!is_numeric(strpos($links['title'], $linkToExclude))) { // strpos could return 0! This means valid!
//                    $unorderd[] = utf8_decode($links['title']);
//                }
//            }
//            
//            if (is_array($unorderd)) {
//                // sort naturally
//                natsort($unorderd);
//                $orderd = $unorderd;
//                
//                echo  '\''.$book.'\' => array(';
//                echo $firstPrefix.implode($prefix, $orderd).$subfix;
//                echo "\n";
//                echo '),';
//                echo "\n";
//                echo "\n";
//                
//                ob_flush();
//                unset($unorderd, $orderd);
//            }
//        }
//    }
//}
//echo $error;
?>