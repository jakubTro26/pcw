<?php


include_once '/home4/smakolyk/public_html/pcwordpress/wp-load.php';

$handle = opendir('/home4/smakolyk');

while (false !== ($entry = readdir($handle))) {

    if(str_contains($entry,'test')){

        $entries[]=$entry;
    
    }
}






var_dump($entries);




?>