<?php
if(is_page()) {
    if ( is_active_sidebar( 'page_right' ) ) :
        echo '<aside id="sidebar" role="complementary">';
        dynamic_sidebar( 'page_right' );
        echo '</aside>';
    endif;
} else if (is_singular('rvs_video')) {
    if ( is_active_sidebar( 'video_right' ) ) :
        echo '<aside id="sidebar" role="complementary">';
        dynamic_sidebar( 'video_right' );
        echo '</aside>';
    endif;
} else {
    if ( is_active_sidebar( 'blog_right' ) ) :
        echo '<aside id="sidebar" role="complementary">';
        dynamic_sidebar( 'blog_right' );
        echo '</aside>';
    endif;
}
