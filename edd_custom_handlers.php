<?php
//EDD Redirect customer at checkout when their cart is empty

function vd_edd_empty_cart_redirect() {
	$cart 		= function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : false;
	$redirect 	= site_url( 'shop' ); // URL to your shop
	if ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() && ! $cart ) {
		wp_redirect( $redirect, 301 ); 
		exit;
	}
}
add_action( 'template_redirect', 'vd_edd_empty_cart_redirect' );

// forgot password link to login form on checkout page

function vd_add_forgot_pswd_checkout (){

	$lostpswd = site_url('lostpassword');
	echo '<p><a class="lost-password" href=" '. $lostpswd . '">Lost Password?</a></p>';
}
add_action('edd_checkout_login_fields_after', 'vd_add_forgot_pswd_checkout');

// Register payment icons in custom order.

function pw_edd_payment_icon($icons) {

    $icons['/wp-content/themes/vectordefector/assets/images/icons/americanexpress.png'] = 'Custom AMEX';
    $icons['/wp-content/themes/vectordefector/assets/images/icons/mastercard.png'] = 'Custom Mastercard';
    $icons['/wp-content/themes/vectordefector/assets/images/icons/visa.png'] = 'Custom Visa';
    $icons['/wp-content/themes/vectordefector/assets/images/icons/discover.png'] = 'Custom Discover';
    return $icons;
}
add_filter('edd_accepted_payment_icons', 'pw_edd_payment_icon');


//Restrict Shipping Countries
function edd_restrict_country( $countries ) {

	$hasShipping = 0;

	$cart_contents = edd_get_cart_contents();

	if($cart_contents) {

		foreach ($cart_contents as $item) {
			$hasShipping = get_post_meta($item['id'], '_edd_enable_shipping', true);
		}	

		$keepCountries = array('US' => 'United States', 'CA' => 'Canada', 'UK' => 'United Kingdom', 'AU' => 'Australia', 'DE' => 'Germany', 'FR' => 'France','NO' => 'Norway', 'ES' => 'Spain', 'SE' => 'Sweden', 'IL' => 'Israel', 'IT' => 'Italy');

		//only display countries we're allowed to ship to at checkout (if the product is shippable)
		if($hasShipping == 1) {
			$countries = $keepCountries;
		}

	}

	return $countries;
}

// Change product image thumbnail size on Easy Digital Downloads checkout page
add_filter( 'edd_checkout_image_size', 'filter_edd_checkout_image_size', 10, 1 );

function filter_edd_checkout_image_size( $array ) {
    return array( 100, 0 );
}

add_filter( 'edd_countries', 'edd_restrict_country' );

// Pass new customer info via CURL
function vd_edd_on_complete_purchase($payment_id) {

	// Basic payment meta
	$payment_meta = edd_get_payment_meta($payment_id);

	if($payment_meta) {

		$vdFormName = '[Form Name]';
						
		//full form
		$curlUrl .= '&firstName='.urlencode($payment_meta['user_info']['first_name']).'&lastName='.urlencode($payment_meta['user_info']['last_name']).'&emailAddress='.$payment_meta['email'].'&State='.$payment_meta['user_info']['address']['state'].'&company='.$payment_meta['company'].'&country='.$payment_meta['user_info']['address']['country'];

		//echo $curlUrl;
		$ct = 1;

		if( isset( $payment_meta['cart_details'] ) ) {
		 	$cart_items = $payment_meta['cart_details'];

			$items = '';

			if($ct < count($cart_items)) {
				$csv = ' / ';
			} else {
				$csv = '';
			}

			foreach( $cart_items as $key => $product ) {
				$items .= esc_attr( $product["name"] ).' - $'.esc_attr( $product["item_price"] ).$csv;
			}

			$eloquaUrl .= '&productsPurchased='.urlencode($items);

			$ct++;
		}

		//add if UTMs
		if( isset( $payment_meta['eddct_campaign'] ) ) {
			$campaign_info = $payment_meta['eddct_campaign'];
			$eloquaUrl .= '&utm_source='.$campaign_info['source'].'&utm_medium='.$campaign_info['medium'].'&utm_campaign='.$campaign_info['name'];
		}

		//exit;

		// create the cURL resource  
		$ch = curl_init();    

		// set cURL options  
		curl_setopt($ch, CURLOPT_URL, $eloquaUrl);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLINFO_HEADER_OUT, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Length: 0"
		));

		// execute request and retrieve the response  
		$data = curl_exec($ch);  

		// close resources and return the response  
		curl_close($ch);  

	}


}
add_action( 'edd_complete_purchase', 'vd_edd_on_complete_purchase' );

// Additional filter to disable Easy Digital Downloads Enhanced E-commerce tracking for Google Tag Manager
add_action( 'wp_head', 'edd_remove_scripts', 5);
	
function edd_remove_scripts() {
	
		if(function_exists('EDD_Enhanced_Ecommerce_Tracking')):
			//remove extra output script (ours comes from GTM)
			remove_action( 'wp_head', array(EDD_Enhanced_Ecommerce_Tracking()->implementation, 'output_script' ));
			remove_action( 'admin_head', array(EDD_Enhanced_Ecommerce_Tracking()->implementation, 'output_script' ));
		endif;
	
	}
	

