<?php
// Example use
include("class_rtf.php");

$rtf = new rtf("rtf_config.php");
$rtf->setPaperSize(5);
$rtf->setPaperOrientation(1);
$rtf->setDefaultFontFace(0);
$rtf->setDefaultFontSize(24);
$rtf->setAuthor("noginn");
$rtf->setOperator("me@noginn.com");
$rtf->setTitle("Volxbibel");
$rtf->addColour("#000000");

require_once dirname(__FILE__).'/../convertWiki.php';
#$rtf->document = convertWiki('http://wiki:wiki@85.10.211.16/wiki/api.php?action=query&prop=revisions&titles=Hauptseite&rvprop=timestamp|user|comment|content&format=php');
$rtf->document = convertWiki('http://at.volxbibel.com/api.php?prop=revisions&action=query&titles=2.Mose_1&rvprop=timestamp|user|comment|content&format=php');
#$rtf->document = '<em>EM</em><i>I</i>';
#var_dump($rtf->document);exit;
$rtf->document =str_replace("</p>\n", '</p>', $rtf->document);

$text = $rtf->parseDocument();

#$rtf->addText($text);
$rtf->getDocument();
?>