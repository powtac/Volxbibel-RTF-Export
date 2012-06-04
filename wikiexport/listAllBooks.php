<?php
/*
 * tests
 * Simon Bruechner, 30.08.2008
 */


require_once dirname(__FILE__).'/config/books.php';

foreach ($books as $name => $bookDetails) {
    echo $name.'<br />';
    foreach ($bookDetails as $key => $value) {
        echo '<blockquote>'.$value['chapter'].'</blockquote>';
    }
}
?>