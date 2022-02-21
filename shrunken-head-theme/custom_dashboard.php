<?php
/**
 * Our custom dashboard page
 */

/** WordPress Administration Bootstrap */
require_once( ABSPATH . 'wp-load.php' );
require_once( ABSPATH . 'wp-admin/admin.php' );
require_once( ABSPATH . 'wp-admin/admin-header.php' );

	$user = wp_get_current_user();
?>
<div id="welcomeBar" class="wrap custom-dashboard-wrap" style="padding:25px; font-size: 18px; line-height: 1.5em;">
	
    <h1>Welcome to <?php bloginfo('name');?>!</h1>
    
    <?php if($user->has_cap('edit_pages')) { ?>
    
    <p><b><i>From here, you can:</i></b></p>
    
    <ul>
    <li><i class="dashicons dashicons-admin-post"></i> <a href="<?php bloginfo('wpurl');?>/wp-admin/edit.php?post_type=page">Add or Edit Pages</a></li>
    <li><i class="dashicons dashicons-clipboard"></i> <a href="<?php bloginfo('wpurl');?>/wp-admin/admin.php?page=formidable-entries">View or Edit Contact Form Entries</a></li>    
    <li><i class="dashicons dashicons-admin-media"></i> <a href="<?php bloginfo('wpurl');?>/wp-admin/upload.php">Manage Site Files</a></li>
    <li><i class="dashicons dashicons-admin-users"></i> <a href="<?php bloginfo('wpurl');?>/wp-admin/profile.php">Update Your Profile &amp; Password</a></li>
    <li><i class="dashicons dashicons-migrate"></i> <a href="<?php echo wp_logout_url(); ?>">Log Out</a></li>
    </ul>
    
    <?php } else { ?>

    <?php // show alternate content to lesser access users  ?>
    
    <?php } ?>
    
    
</div>

</div>
