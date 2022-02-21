<div id="footer" style="background-image: url(<?php if(get_field('sitewide_background_image','options')) { echo get_field('sitewide_background_image','options');}?>)">

<?php if(get_field('footer_logo','option')): ?>
    <div class="footer-logo"><img src="<?php the_field('footer_logo','option'); ?>" alt="<?php bloginfo('name');?>"></div>
<?php endif; ?>

<?php if(get_field('footer_text','option')): ?>
    <div class="footer-text"><?php the_field('footer_text','option'); ?></div>
<?php endif; ?>
</div>

<div id="copyright">
    &copy; <?php echo date("Y");?> <?php bloginfo('name');?>. All Rights Reserved.
    <div class="credit">Site by <a href="https://vectordefector.com" target="_blank" style="color: #222;">VectorDefector.com</a></div>
</div>

<script type="text/javascript">  
<!--
jQuery(document).ready(function($){
    enableButtons();

    /*
    jQuery('.wp-block-column img').each(function(){
        tagAnimation(jQuery(this));
    });

    jQuery('.wp-block-cover img').each(function(){
        tagAnimation(jQuery(this));
    });
    */
   
});
-->
</script>

<?php wp_footer(); ?>

</body>
</html>