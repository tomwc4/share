<!-- Custom Wordpress functions for Google Ad Manager -->
<?php global $post;
$pageType = get_post_type($post->id);?>
<script async="async" src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
<script type="text/javascript">
// New Google Ad Manager Code
  window.googletag = window.googletag || {cmd: []};

//Responsive mapping
    var gptAdSlots = [];
    var mapping = [];
    var rotations = 0;

    googletag.cmd.push(function () {

// Define a size mapping object. The first parameter to addSize is
// a viewport size, while the second is a list of allowed ad sizes.

//Leaderboard units
        mapping[0] = googletag.sizeMapping().
        addSize([768, 200], [728, 90]).
        addSize([0, 0], [[300, 250], [320, 50]]).build();

//Sidebar units
        mapping[1] = googletag.sizeMapping().
        addSize([768, 200], [[300, 250], [300, 600]]).
        addSize([0, 0], [[300, 250], [320, 50]]).build();

//In-article unit
        mapping[2] = googletag.sizeMapping().
        addSize([0, 0], [300, 250]).build();

//Custom unit
        mapping[3] = googletag.sizeMapping().
        addSize([0, 0], [1, 1]).build();

//video
        mapping[6] = googletag.sizeMapping().
        addSize([0,0], [640, 480], [400, 300]).build();

// Define the GPT ad slots
    //leaderboards
    gptAdSlots[0] = googletag.defineSlot('/xxxxxxxxxxx/leaderboard', [728, 90], 'div-gpt-ad-0').defineSizeMapping(mapping[0]).addService(googletag.pubads());

    //sidebars
    gptAdSlots[1] = googletag.defineSlot('/xxxxxxxxxxx/sidebar_a', [300, 250], 'div-gpt-ad-1').defineSizeMapping(mapping[1]).addService(googletag.pubads());
    gptAdSlots[3] = googletag.defineSlot('/xxxxxxxxxxx/sidebar_b', [300, 250], 'div-gpt-ad-2').defineSizeMapping(mapping[1]).addService(googletag.pubads());

    <?php if(!is_home() && !is_front_page() && !is_archive() && $pageType == 'post'): ?> 
    //posts
    gptAdSlots[4] = googletag.defineSlot('/xxxxxxxxxxx/med_rec', [300, 250], 'div-gpt-ad-3').defineSizeMapping(mapping[2]).addService(googletag.pubads());
    <?php endif; ?>

    <?php if(is_home() || is_front_page()): ?>
    //custom 1x1
    gptAdSlots[5] = googletag.defineSlot('/xxxxxxxxxxx/custom', [1, 1], 'div-gpt-ad-4').defineSizeMapping(mapping[3]).addService(googletag.pubads());

    //video
    gptAdSlots[6] = googletag.defineSlot('/xxxxxxxxxxx/video', [600, 480], 'div-gpt-ad-5').defineSizeMapping(mapping[6]).addService(googletag.pubads());
    <?php endif; ?>

    //load all ad units at once, collapse any slots not in use
    googletag.pubads().enableSingleRequest();
    googletag.pubads().collapseEmptyDivs();
        
       <?php // get dynamic tagging

            //tag domain
            echo "googletag.pubads().setTargeting('domain', ['".basename(get_bloginfo('url'))."']); \n";

            if(is_home() || is_front_page()) {

                echo "googletag.pubads().setTargeting('page_type', ['home']); \n";

            } elseif(is_archive()) {
                 echo "googletag.pubads().setTargeting('page_type', ['category']); \n";
                
                $category = get_category(get_query_var('cat'));              
                $topic = $category->slug;
                
                if($topic):
                echo "googletag.pubads().setTargeting('topic', ['".$topic."']); \n";
                endif;

            } else {
               
                echo "googletag.pubads().setTargeting('article_id', ['".$post->ID."']); \n";
                
                echo "googletag.pubads().setTargeting('page_type', ['".$pageType."']); \n";
                
                //categories
                $categories = get_the_category($post->ID);
                if(!empty($categories)) {

                    $topics = array();

                    foreach($categories as $key => $cat) {
                        $topics[] = "'".$cat->slug."'";
                    }

                    echo "googletag.pubads().setTargeting('topic', [".implode($topics,",")."]); \n";
                }

                $tags = get_the_tags($post->ID);

                if(!empty($tags)) {

                    $tagsList = array();

                    foreach($tags as $key => $tagVal) {
                        $tagsList[] = "'".$tagVal->slug."'";
                    }

                    echo "googletag.pubads().setTargeting('tags', [".implode($tagsList,",")."]); \n";
                }
            
            } ?>

 // Start ad fetching
    googletag.enableServices();
  });

</script>