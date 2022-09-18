<?php
ini_set('max_execution_time', '600');
set_time_limit(600);



	 function do_ajax_product_import($file) {
		global $wpdb;


	
		

		//check_ajax_referer( 'wc-product-import', 'security' );
       
		// if ( ! $this->import_allowed() || ! isset( $_POST['file'] ) ) { // PHPCS: input var ok.
		// 	wp_send_json_error( array( 'message' => __( 'Insufficient privileges to import products.', 'woocommerce' ) ) );
		// }

		include_once WC_ABSPATH . 'includes/admin/importers/class-wc-product-csv-importer-controller.php';
		include_once WC_ABSPATH . 'includes/import/class-wc-product-csv-importer.php';
        
		// $file   = wc_clean( wp_unslash( $_POST['file'] ) ); // PHPCS: input var ok.
		// $params = array(
		// 	'delimiter'       => ! empty( $_POST['delimiter'] ) ? wc_clean( wp_unslash( $_POST['delimiter'] ) ) : ',', // PHPCS: input var ok.
		// 	'start_pos'       => isset( $_POST['position'] ) ? absint( $_POST['position'] ) : 0, // PHPCS: input var ok.
		// 	'mapping'         => isset( $_POST['mapping'] ) ? (array) wc_clean( wp_unslash( $_POST['mapping'] ) ) : array(), // PHPCS: input var ok.
		// 	'update_existing' => isset( $_POST['update_existing'] ) ? (bool) $_POST['update_existing'] : false, // PHPCS: input var ok.
		// 	'lines'           => apply_filters( 'woocommerce_product_import_batch_size', 30 ),
		// 	'parse'           => true,
		// );
      





            
			

          		$params = array(
			'delimiter'       => ',', 
			'start_pos'       => 0, // PHPCS: input var ok.
			'mapping'         => array(
                'from' => array("my_sku","towar_id","kod","cku","attribute_1_name","attribute_1_value","attribute_1_visible","attribute_2_name","attribute_2_value","attribute_2_visible","nazwa","skrot","attribute_3_name","attribute_3_value","attribute_3_visible","attribute_4_name","attribute_4_value","attribute_4_visible","attribute_5_name","attribute_5_value","attribute_5_visible","attribute_6_name","attribute_6_value","attribute_6_visible","attribute_7_name","attribute_7_value","attribute_7_visible","attribute_8_name","attribute_8_value","attribute_8_visible","waga","wysokosc","szerokosc","glebokosc","attribute_9_name","attribute_9_value","attribute_9_visible","attribute_10_name","attribute_10_value","attribute_10_visible","attribute_11_name","attribute_11_value","attribute_11_visible","attribute_12_name","attribute_12_value","attribute_12_visible","il_kg_litrow","kod_CN","podlega_OO","podlega_MPP","status_do_zamowien","nowosc_od","nowosc_przez","koszty_transportu","koszty_przechowywania","koszty_inne","min_cena_sprzedazy_PCPOS","aktywny_w_SI","nazwa_w_SI","cena_zakupu","cena_detal","cena_hurtowa","cena_nocna","cena_dodatkowa","cena_detal_przed_prom","cena_hurtowa_przed_prom","cena_nocna_przed_prom","cena_dodatkowa_przed_prom","marza_suger","narzut_nocny","rabat_hurtowy","rabat_dodatkowy","status_ceny","opakowanie_id","ilosc_w_opakowaniu","czy_tandem","czy_karton","czy_artykul","artykul_id","kategoria_id","producent_id","dostawca_id","dost_id","dost_id2","opis1","opis2","opis3","opis4","notatki","uwagi_do_dostaw","nr_drukarki","folder_zdjec","plik_zdjecia","magazyn_id2","stan_magazynu2","stan_magazynu_min2","stan_magazynu_max2","blokada_stanu2","rezerwacja_ilosci2","magazyn_id3","stan_magazynu3","stan_magazynu_min3","stan_magazynu_max3","blokada_stanu3","rezerwacja_ilosci3","magazyn_id4","stan_magazynu4","stan_magazynu_min4","stan_magazynu_max4","blokada_stanu4","rezerwacja_ilosci4","magazyn_id","stan_magazynu","stan_magazynu_min","stan_magazynu_max","blokada_stanu","rezerwacja_ilosci","kod2","ilosc_w_kodzie2","opis5","poziom_cen2","kod3","ilosc_w_kodzie3","opis6","poziom_cen3","kod4","ilosc_w_kodzie","opis","poziom_cen","parametry","data_aktualizacji","visibility","type"),

                'to' => array("sku","","","","attributes:name1","attributes:value1","attributes:visible1","attributes:name2","attributes:value2","attributes:visible2","name","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","type")


            ), // PHPCS: input var ok.ff
			'update_existing' => true, // PHPCS: input var ok.
			'lines'           => 40,
			'parse'           => true,
		);

		// Log failures.
		if ( 0 !== $params['start_pos'] ) {
			$error_log = array_filter( (array) get_user_option( 'product_import_error_log' ) );
		} else {
			$error_log = array();
		}




		$importer         = WC_Product_CSV_Importer_Controller::get_importer( $file, $params );
		
		
		
		




		$results          = $importer->import();
        
		var_dump($results);
  
		$percent_complete = $importer->get_percent_complete();
		$error_log        = array_merge( $error_log, $results['failed'], $results['skipped'] );

		update_user_option( get_current_user_id(), 'product_import_error_log', $error_log );

		if ( 100 === $percent_complete ) {
			// @codingStandardsIgnoreStart.
			$wpdb->delete( $wpdb->postmeta, array( 'meta_key' => '_original_id' ) );
			$wpdb->delete( $wpdb->posts, array(
				'post_type'   => 'product',
				'post_status' => 'importing',
			) );
			$wpdb->delete( $wpdb->posts, array(
				'post_type'   => 'product_variation',
				'post_status' => 'importing',
			) );
			// @codingStandardsIgnoreEnd.

			// Clean up orphaned data.
			$wpdb->query(
				"
				DELETE {$wpdb->posts}.* FROM {$wpdb->posts}
				LEFT JOIN {$wpdb->posts} wp ON wp.ID = {$wpdb->posts}.post_parent
				WHERE wp.ID IS NULL AND {$wpdb->posts}.post_type = 'product_variation'
			"
			);
			$wpdb->query(
				"
				DELETE {$wpdb->postmeta}.* FROM {$wpdb->postmeta}
				LEFT JOIN {$wpdb->posts} wp ON wp.ID = {$wpdb->postmeta}.post_id
				WHERE wp.ID IS NULL
			"
			);
			// @codingStandardsIgnoreStart.
			$wpdb->query( "
				DELETE tr.* FROM {$wpdb->term_relationships} tr
				LEFT JOIN {$wpdb->posts} wp ON wp.ID = tr.object_id
				LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
				WHERE wp.ID IS NULL
				AND tt.taxonomy IN ( '" . implode( "','", array_map( 'esc_sql', get_object_taxonomies( 'product' ) ) ) . "' )
			" );
			// @codingStandardsIgnoreEnd.

			// Send success.
			// wp_send_json_success(
			// 	array(
			// 		'position'   => 'done',
			// 		'percentage' => 100,
			// 		'url'        => add_query_arg( array( '_wpnonce' => wp_create_nonce( 'woocommerce-csv-importer' ) ), admin_url( 'edit.php?post_type=product&page=product_importer&step=done' ) ),
			// 		'imported'   => count( $results['imported'] ),
			// 		'failed'     => count( $results['failed'] ),
			// 		'updated'    => count( $results['updated'] ),
			// 		'skipped'    => count( $results['skipped'] ),
			// 	)
			// );
		} else {
			// wp_send_json_success(
			// 	array(
			// 		'position'   => $importer->get_file_position(),
			// 		'percentage' => $percent_complete,
			// 		'imported'   => count( $results['imported'] ),
			// 		'failed'     => count( $results['failed'] ),
			// 		'updated'    => count( $results['updated'] ),
			// 		'skipped'    => count( $results['skipped'] ),
			// 	)
			// );
		}
	}




	

$var =$_POST;

foreach($var as $v){
    foreach ($v as $adr){
        $string = '/home4/smakolyk/' . $adr;
        var_dump($string);
       // do_ajax_product_import($string);
    }



    
}



?>