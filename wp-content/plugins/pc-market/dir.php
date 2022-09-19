<?php


include_once '/home4/smakolyk/public_html/pcwordpress/wp-load.php';

$handle = opendir('/home4/smakolyk');

while (false !== ($entry = readdir($handle))) {

    if(str_contains($entry,'test')){

        $entries[]=$entry;
    
    }
}



echo '
<script>
window.csv=[];
</script>
';


foreach($entries as $entry){

echo '
<script>
window.csv.push("'. $entry .'");
</script>
';

}

wp_enqueue_script( 'ajax-script' );
wp_localize_script("ajax-script", "php_vars", array(
      "entries" => $entries
    )
  );

?>