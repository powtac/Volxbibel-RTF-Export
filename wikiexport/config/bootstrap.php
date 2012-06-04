<?php
/*
 * Volxbibel RTF Export
 * Simon Brüchner 2012
 */

error_reporting(E_ALL ^ E_DEPRECATED);

header('Content-type: text/html; charset=utf-8');

require_once dirname(__FILE__).'/config.php';

// required PEAR libs
require_once 'HTTP/Request.php';
require_once 'Text/Wiki.php';
require_once 'Text/Wiki/Render/Xhtml/Url.php';
require_once 'Text/Wiki/Mediawiki.php';

require_once dirname(__FILE__).'/basic.php';
require_once dirname(__FILE__).'/books.php';

