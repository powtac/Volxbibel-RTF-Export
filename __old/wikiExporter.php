<?php
/*
 * Volxbibel RTF Export
 * Simon Bruechner, 30.08.2008
 */


class wikiExporter {

    var $_rawWiki;
    var $_html;
    var $_rtf;

    function setWikiPageNames($listOfWikiPageNames = array()) {
        if (is_array($listOfWikiPageNames)) {
            $this->_wikiPageNames = $listOfWikiPageNames;
        } else {
            $this->_wikiPageNames = (string)$listOfWikiPageNames;
        }
    }

    function wikiExporter() {

    }

    function getRawWiki() {
        return $this->_rawWiki;
    }

    function convertRawWiki2HTML() {
        return $this->_html;
    }

    function convertHTML2Rft() {
        return $this->_rtf;
    }
    
    function sendHTTP_Rtf() {
        if (count($this->_errors) === 0) {
            if (!headers_sent()) {
                header('Content-Type: text/rtf');
                echo $this->_rtf;
            } else {
                $this->setError('Headers already send, sending RTF not possible');
            }
        }
    }
    
    /**
     * Alias for sendHTTP_Rtf()
     */
    function send() {
        return $this->sendHTTP_Rtf();
    }
    
    function setError($error) {
        $this->_errors[] = $error;
    }
    
    function getErrors() {
        return $this->_errors;
    }
    
    function __destruct() {
        foreach ($this->_errors as $error) {
            echo '<pre>'.__CLASS__.$error.'</pre><br />';
        }
    }
}
?>