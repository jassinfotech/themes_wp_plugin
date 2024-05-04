<?php get_header(); 
global $wpvs_profile_browsing;
$current_term = get_term($wp_query->get_queried_object_id(), 'rvs_actors' );
?>
<div class="video-page-container">
<?php 
    if ( $wpvs_profile_browsing ) :
        include(locate_template('template/rvs-profile-taxonomy.php', false , false)); 
    else :
        include(locate_template('template/rvs-video-taxonomy.php', false , false));
    endif; 
?>
</div>
<?php get_footer(); ?>