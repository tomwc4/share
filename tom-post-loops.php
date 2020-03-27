<?php 

//Tom's way of controlling post orders

$sponsoredPosts = array();
$normalPosts = array();

//run the loop, but only use it to collect data
while(have_posts()) : the_post();

    if($post->post_type == "intelligence") {
        $sponsoredPosts[] = $post;
    } else {
        $normalPosts[] = $post;
    }
    //you could put more switches in for other types

endwhile; 

//then run your own loops

    //do sponsored first

    foreach($sponsoredPosts as $key => $post) {

        echo '<h1>'.$post->post_title.'</h1>';

        echo apply_filters('the_content',$post->post_content);

        //etc, custom output

    }

    // do other posts next
    foreach($normalPosts as $key => $post) {

        echo '<h1>'.$post->post_title.'</h1>';

        echo apply_filters('the_content',$post->post_content);

        //etc, default output

    }

    //you could keep doing this with other types

?>
