<?php 
/* check inventory tracking & counts */
function check_inventory($bigc_product_id) {
	
	$lowStock = 0;
	$minInventory = 1000;
	$hasTracking = 0;

	$ch = curl_init();
	$api_url = get_option('bigcommerce_store_url').'catalog/products/'.$bigc_product_id;
	curl_setopt($ch, CURLOPT_URL,$api_url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"content-type: application/json",
		"x-auth-token: " . get_option('bigcommerce_access_token')
	));
    $result = curl_exec($ch);
    curl_close($ch);
    $product = json_decode($result, true);

	//echo '<pre>';
	//print_r($product);
	//echo '</pre>';

	if(isset($product) && $product != '' && $product['data']['inventory_tracking'] != "none"):
		
		$hasTracking = 1;
		$currentInventory = $product['data']['inventory_level'];

		//overwrite min inventory settings if set on product
		if($product['data']['inventory_warning_level'] > 0):
			$minInventory = $product['data']['inventory_warning_level'];
		endif;

		if($product['data']['inventory_tracking'] == "product"):
			$currentInventory = $product['data']['inventory_level'];
		endif;

		if($product['data']['inventory_tracking'] == "variant"):
			//iterate variants from BigC API
			$ch = curl_init();
			$api_url = get_option('bigcommerce_store_url').'catalog/products/'.$bigc_product_id.'/variants';
			curl_setopt($ch, CURLOPT_URL,$api_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"content-type: application/json",
				"x-auth-token: " . get_option('bigcommerce_access_token')
			));
			$result = curl_exec($ch);
			curl_close($ch);
			$variants = json_decode($result, true);

			if(is_array($variants['data'])):

				//reset count in case added from product data
				$currentInventory = '';
				$lowStock = array();

				foreach($variants as $variant):

					foreach($variants['data'] as $thisVariant):

						if($thisVariant['inventory_warning_level'] > 0):
							$minInventory = $thisVariant['inventory_warning_level'];
						endif;

						$currentInventory = $thisVariant['inventory_level'];

						if($currentInventory <= $minInventory):
							$lowStock[$thisVariant['id']] = $thisVariant['sku'];
						endif;	
					
					endforeach;
					
				endforeach;
			endif;			
		endif;


		if(is_array($lowStock)):
			if(count($lowStock) == 0):
				$lowStock = 0;
			endif;
		else:
			if($hasTracking == 1 && $currentInventory <= $minInventory):
				$lowStock = 1;
			endif;
		endif;
		
	endif;

	return $lowStock;
}

/* end check inventory tracking & results */
?>