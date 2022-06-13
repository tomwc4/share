/**
 * NEW WP BLOCK METHOD TESTING
**/

 /*
//filter by post type, this can also be done with block_editor_settings_all
function filter_allowed_block_types( $allowed_block_types, $post ) {

	if ( $post->post_type == 'post' ):
		$allowed_block_types = array(
			'core/freeform', // Classic Editor Block
		);
	endif;

	//example with custom post type
	if ( $post->post_type == 'event' ):
			$allowed_block_types = array(
				'core/paragraph',
				'core/image',
				//'core/gallery',
				//'core/cover',
				//'core/video',
				'core/list',
				'core/heading',
				'core/buttons',
				//'core/columns',
				'core/separator',
				'core/spacer',
				//'atomic-blocks/ab-button', //can do plugin block types too
			);
	endif;

	//returns true if all active, or an array list of allowed blocks	
	return $allowed_block_types;
}

add_filter( 'allowed_block_types', 'filter_allowed_block_types', 10, 2 );
//add_filter( 'allowed_block_types_all', 'filter_allowed_block_types', 10, 2 ); // toggles all blocks on/off, previous is preferred
*/

/*
* SUGGEST: USE THIS CODE TO CONTROL BLOCK SETTINGS, THEN USE THEME.JSON TO CONTROL DEFAULT STYLES
*/

//filter by global settings or user roles
function wp_block_editor_settings( $editor_settings, $editor_context ) {

	$user = wp_get_current_user();
	$roles = $user->roles;
	
	$theme_json = WP_Theme_JSON_Resolver::get_merged_data( $editor_settings );

	if ( WP_Theme_JSON_Resolver::theme_has_support() ):
		$editor_settings['styles'][] = array(
			'css'            => $theme_json->get_stylesheet( 'block_styles' ),
			'__unstableType' => 'globalStyles',
		);
		$editor_settings['styles'][] = array(
			'css'                     => $theme_json->get_stylesheet( 'css_variables' ),
			'__experimentalNoWrapper' => true,
			'__unstableType'          => 'globalStyles',
		);
	endif;

	$editor_settings['__experimentalFeatures'] = $theme_json->get_settings();

	/*
	echo '<pre>';
	print_r($editor_settings);
	echo '</pre>';	
	exit;
	*/

	//if(!in_array('administrator',$roles) && !in_array('editor',$roles)):

	if(in_array( $editor_context->post->post_type, [ 'post' ], true )): //filter by post type

		$editor_settings['allowedBlockTypes'] = array(
			'core/freeform' //only show classic editor
		);

	else:
		$editor_settings['allowedBlockTypes'] = array(
				'core/paragraph',
				'core/image',
				'core/gallery',
				'core/cover',
				'core/video',
				'core/list',
				'core/heading',
				'core/buttons',
				'core/columns',
				'core/separator',
				'core/spacer',
			);
	endif;
	
	$editor_settings['__experimentalFeatures']['appearanceTools'] = 0;
	$editor_settings['__experimentalFeatures']['className'] = 0;
	$editor_settings['__experimentalFeatures']['customClassName'] = 0;
	$editor_settings['__experimentalFeatures']['anchor'] = 0;

	$editor_settings['__experimentalFeatures']['border']['color'] = 0;
	$editor_settings['__experimentalFeatures']['border']['radius']  = 0;
	$editor_settings['__experimentalFeatures']['border']['style']  = 0;
	$editor_settings['__experimentalFeatures']['border']['width']  = 0;

	$editor_settings['__experimentalFeatures']['color']['text'] = 0;
	//$editor_settings['__experimentalFeatures']['color']['background'] = 0;
	$editor_settings['__experimentalFeatures']['color']['link'] = 0;
	//$editor_settings['__experimentalFeatures']['color']['custom'] = 0;
	$editor_settings['__experimentalFeatures']['color']['customDuotone'] = 0;
	$editor_settings['__experimentalFeatures']['color']['customGradient'] = 0;
	$editor_settings['__experimentalFeatures']['color']['defaultGradients'] = 0;
	//$editor_settings['__experimentalFeatures']['color']['defaultPalette'] = 0;
	$editor_settings['__experimentalFeatures']['color']['defaultDuotone'] = 0;	

	$editor_settings['__experimentalFeatures']['spacing']['blockGap'] = 0;
	$editor_settings['__experimentalFeatures']['spacing']['margin'] = 0;
	$editor_settings['__experimentalFeatures']['spacing']['padding'] = 0;
	$editor_settings['__experimentalFeatures']['spacing']['units'] = [];

	$editor_settings['__experimentalFeatures']['typography']['customFontSize'] = 0;
	$editor_settings['__experimentalFeatures']['typography']['dropCap'] = 0;
	$editor_settings['__experimentalFeatures']['typography']['fontStyle'] = 0;
	$editor_settings['__experimentalFeatures']['typography']['fontWeight'] = 0;
	$editor_settings['__experimentalFeatures']['typography']['letterSpacing'] = 0;
	$editor_settings['__experimentalFeatures']['typography']['lineHeight'] = 0;
	$editor_settings['__experimentalFeatures']['typography']['textDecoration'] = 0;
	$editor_settings['__experimentalFeatures']['typography']['textTransform'] = 0;

	//still working on these:

	$editor_settings['__experimentalFeatures']['blocks']['core/button']['spacing'] = 0;
	$editor_settings['__experimentalFeatures']['blocks']['core/button']['typography'] = 0;
	$editor_settings['__experimentalFeatures']['blocks']['core/button']['border']['radius'] = 0;
	$editor_settings['__experimentalFeatures']['blocks']['core/button']['color']['background'] = 0;
	$editor_settings['__experimentalFeatures']['blocks']['core/button']['color']['custom'] = 0;
	$editor_settings['__experimentalFeatures']['blocks']['core/button']['width'] = 0;
	$editor_settings['__experimentalFeatures']['blocks']['core/button']['defaultStylePicker'] = 0;

	//endif;	

	
	/*
	echo '<pre>';
	print_r($editor_settings['__experimentalFeatures']);
	echo '</pre>';	
	exit;
	*/
	    
	return $editor_settings;
}

add_filter( 'block_editor_settings_all', 'wp_block_editor_settings', 10, 2 );

//all of this could be defined in ACF to control display of fields
