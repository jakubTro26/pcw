<?php
/*
Plugin Name: pc-market
Plugin URI:w
Description: pc-market
Author: Jakub Troczyńki
Author URI: ttroczynski5@gmail.com
*/

// Hook for adding admin menusf
add_action('admin_menu', 'mt_add_pages');


add_action('admin_menu', 'menu');


function menu(){
  
        
        
       

        wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.6.1.js' );
        wp_enqueue_script( 'jquery' );

        wp_register_script( 'custom-scripts', site_url() . '/wp-content/plugins/pc-market/script.js' );
        wp_enqueue_script( 'custom-scripts' );
        wp_localize_script("custom-scripts", "php_vars", array(
              "ajaxurl" => site_url() . '/wp-content/plugins/pc-market/import_one.php',
              "another_var" => get_bloginfo("name")
            )
          );
    
}

// action function for above hook
function mt_add_pages() {
    

    // Add a new top-level menu (ill-advised):
    add_menu_page(__('pcmarket','pcmarket'), __('pcmarket','pcmarket'), 'manage_options', 'mt-top-level-handle', 'mt_toplevel_page' );

   

    
}


add_action('cron','cron_function');

 function cron_function(){

       // $myfile = fopen("/home4/smakolyk/public_html/test_dwa/cron.txt", "w") or die("Unable to open file!");
		$file1 = '/home4/smakolyk/public_html/test_dwa/cron.txt';

        $current = file_get_contents($file1);
        file_put_contents($file1, print_r('kuba',true),FILE_APPEND);


        //require_once ABSPATH  . 'wp-content/plugins/pc-market/convert.php';


}

 

// toplevel
function mt_toplevel_page() {
    echo "<h2>" . __( 'pcmarket' ) . "</h2>";


   
        add_filter( 'woocommerce_product_csv_importer_check_import_file_path', '__return_false' );
        wp_enqueue_style( 'custom-design', site_url() . '/wp-content/plugins/pc-market/design.css' );
     
      

    if ( isset( $_GET['action'] ) ) {
        $action = wp_unslash( $_GET['action'] );
      
    }

  


    ?>

        

        <div class=wrapper1>
            <div class="konwertuj">
                <div class="opis1">
                    konwertuj pliki XML do jednego pliku csv
                </div>
                <a  href="<?php echo site_url(); ?>/wp-admin/admin.php?page=mt-top-level-handle&action=convert" class="button1">
                    <button class="buttons1">
                        konwertuj plik xml
                    </button>
                </a>
               
            
            </div>
            <div class="loadDiv">
                    <img class="loading" style="display:none;" src="loading.gif">
                    <img class="accept" style="display:none;" src="accept.png">
            </div>
        </div>
        <div class="wrapper2">
        <a  class="button2">
                    <button class="buttons2">
                        importuj pliki csv
                    </button>
                </a>

        </div>
        <div class="wrapper3">
        <a  href="<?php echo site_url(); ?>/wp-admin/admin.php?page=mt-top-level-handle&action=update" class="button2">
                    <button class="buttons3">
                        updatuj plik csv
                    </button>
                </a>

        </div>
        <div class="wrapper4">
        <a  href="<?php echo site_url(); ?>/wp-admin/admin.php?page=mt-top-level-handle&action=echo" class="button2">
                    <button class="buttons4">
                        echo
                    </button>
                </a>

        </div>
        <div class="wrapper5">
        <a  class="button2">
                    <button class="buttons5">
                        chunk
                    </button>
                </a>

        </div>
        <div class="wrapper6">
        <a  class="button2">
                    <button class="buttons6">
                        import_one
                    </button>
                </a>

        </div>
        <div class="wrapper7">
        <a  href="<?php echo site_url(); ?>/wp-admin/admin.php?page=mt-top-level-handle&action=abs"  class="button2">
                    <button class="buttons7">
                        abspath
                    </button>
                </a>

        </div>
        <script
  src="https://code.jquery.com/jquery-3.6.1.js"
  integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
  crossorigin="anonymous"></script>
    





    <?php


if($action=='convert'){



    //require_once ABSPATH  . 'wp-content/plugins/pc-market/convert2.php';

}

if($action=='import'){

    //ini_set('max_execution_time', '600');
   // set_time_limit(600);

    //require_once ABSPATH .  'wp-content/plugins/pc-market/import.php';



}

if($action=='update'){


   // require_once ABSPATH .  'wp-content/plugins/pc-market/update.php';



}
if($action=='echo'){


     require_once ABSPATH .  'wp-content/plugins/pc-market/dir.php';
 
 
 
 }
 if($action=='abs'){


    global $wp_scripts;
    echo "<h2>Enqueued JS Scripts</h2><ul>";
    foreach( $wp_scripts->queue as $handle ) :
        echo "<li>" . $handle . "</li>";
    endforeach;
    echo "</ul>";



}



}



?>