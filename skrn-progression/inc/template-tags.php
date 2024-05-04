<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package pro
 */

/* Filters for Video Embeds */
add_filter( 'progression_studios_video_content_filter', array( $wp_embed, 'autoembed' ), 8 );
add_filter( 'progression_studios_video_content_filter', 'wptexturize'       );
add_filter( 'progression_studios_video_content_filter', 'convert_smilies'   );
add_filter( 'progression_studios_video_content_filter', 'convert_chars'     );
add_filter( 'progression_studios_video_content_filter', 'wpautop'           );
add_filter( 'progression_studios_video_content_filter', 'shortcode_unautop' );
add_filter( 'progression_studios_video_content_filter', 'do_shortcode'      );


/* Edit Profile Link */
function progression_studios_profile_link() {
	global $current_user; wp_get_current_user(); echo get_author_posts_url($current_user->ID); 
}

function skrn_search_video_counter() {
	$count = $GLOBALS['wp_query']->found_posts; echo esc_attr($count);
}

function progresion_studios_author_pre_get( $query ) {
    if ( $query->is_author() && ! is_admin() ) :
        $query->set( 'posts_per_page', 12 );
    endif;
	 //https://wordpress.stackexchange.com/questions/63043/pagination-only-wont-work-in-author-template
}
add_action( 'pre_get_posts', 'progresion_studios_author_pre_get' );

/* custom archive/taxonomy video posts per page */
function progression_studios_video_post_count( $query ) {
	$skrn_video_count = get_theme_mod('progression_studios_media_posts_page', '12');
	
	if ($query->is_main_query()){
	
	if( is_tax( 'video-type') || is_tax( 'video-genres') || is_tax( 'video-category') || is_tax( 'video-director') || is_tax( 'video-cast') ){
      // show 50 posts on custom taxonomy pages
      $query->set('posts_per_page', $skrn_video_count);
    }
	}

	if( is_post_type_archive( 'video_skrn' ) && !is_admin() ){
      $query->set('posts_per_page', $skrn_video_count);
    }
	 
	
  }
add_action( 'pre_get_posts', 'progression_studios_video_post_count' );



// retrieves the attachment ID from the file URL
function progression_studios_get_image_id($image_url) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return $attachment[0]; 
}


/* Header/Page Title Options */
function progression_studios_page_title() {
	global $post;
?>
	class="
		<?php if (get_theme_mod( 'progression_studios_404_elementor_library') && !is_singular( 'elementor_library') && is_404() ) : ?>progression-studios-custom-404-error<?php endif; ?>
		<?php echo esc_attr( get_theme_mod( 'progression_studios_logo_position', 'progression-studios-logo-position-left') ); ?> 
		<?php echo esc_attr( get_theme_mod( 'progression_studios_header_width', 'progression-studios-header-normal-width') ); ?> 
		<?php echo esc_attr( get_theme_mod('progression_studios_page_title_width') ); ?> 
		<?php if(is_page() && get_post_meta($post->ID, 'progression_studios_header_disabled', true)): ?> progression-disable-header-per-page<?php endif; ?>
		<?php if(is_page() && get_post_meta($post->ID, 'progression_studios_disable_footer_per_page', true)): ?> progression-disable-footer-per-page<?php endif; ?>		
		<?php if(is_page() && get_post_meta($post->ID, 'progression_studios_disable_logo_page_title', true)): ?> progression-disable-logo-below-per-page<?php endif; ?>
		<?php if(is_page() && get_post_meta($post->ID, 'progression_studios_custom_page_nav_color', true)): ?> <?php echo esc_html( get_post_meta($post->ID, 'progression_studios_custom_page_nav_color', true) );?><?php endif; ?>
		<?php if(is_page() && get_post_meta($post->ID, 'progression_studios_header_transparent', true)): ?> progression-studios-transparent-header<?php endif; ?>
		<?php if (get_theme_mod( 'progression_studios_page_transition', 'transition-off-pro') == "transition-on-pro") : ?> progression-studios-preloader<?php endif; ?>
	"
<?php
}


/* Logo */
function progression_studios_logo() {
	global $post;
?>

	<?php if (get_theme_mod( 'progression_studios_landing_page_logo_link')) : ?>
		<a href="<?php echo esc_url( get_theme_mod( 'progression_studios_landing_page_logo_link') ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
	<?php else: ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
	<?php endif; ?>
		
	<?php if(is_page() && get_post_meta($post->ID, 'progression_studios_custom_page_logo', true)): ?>
		<img src="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_custom_page_logo', true) );?>" alt="<?php bloginfo('name'); ?>" class="progression-studios-default-logo progression-studios-hide-mobile-custom-logo<?php if ( get_theme_mod( 'progression_studios_sticky_logo' ) ) : ?> progression-studios-default-logo-hide<?php endif; ?>">
	<?php endif; ?>	
	
		
	<?php if ( get_theme_mod( 'progression_studios_theme_logo', get_template_directory_uri() . '/images/logo-landing.png' ) ) : ?>
		<img src="<?php echo esc_attr( get_theme_mod( 'progression_studios_theme_logo', get_template_directory_uri() . '/images/logo-landing.png' ) ); ?>" alt="<?php bloginfo('name'); ?>" class="progression-studios-default-logo<?php if(is_page() && get_post_meta($post->ID, 'progression_studios_custom_page_logo', true)): ?> progression-studios-custom-logo-per-page-hide-default<?php endif; ?>	<?php if ( get_theme_mod( 'progression_studios_sticky_logo' ) ) : ?> progression-studios-default-logo-hide<?php endif; ?>">
	<?php endif; ?>
	
	<?php if ( get_theme_mod( 'progression_studios_sticky_logo' ) ) : ?>
		<img src="<?php echo esc_attr( get_theme_mod( 'progression_studios_sticky_logo') ); ?>" alt="<?php bloginfo('name'); ?>" class="progression-studios-sticky-logo">
	<?php endif; ?>
	</a>
<?php
}


function progression_studios_navigation() {
?>
	
	
	<div class="width-container-pro optional-centered-area-on-mobile">
		

		<div id="progression-nav-container">
			<nav id="site-navigation" class="main-navigation">
				<?php wp_nav_menu( array('theme_location' => 'progression-studios-landing-page', 'menu_class' => 'sf-menu', 'fallback_cb' => false, 'walker'  => new ProgressionFrontendWalker ) ); ?><div class="clearfix-pro"></div>
			</nav>
			<div class="clearfix-pro"></div>
		</div><!-- close #progression-nav-container -->
		
		
		<?php if (  is_user_logged_in() ) :  
			$current_user = wp_get_current_user(); 
			$user_id = get_current_user_id();  
		?>
			<div id="skrn-landing-login-logout-header">
				<a href="<?php echo esc_url(wp_logout_url( home_url()) )?>"><?php esc_html_e( 'Log Out', 'skrn-progression' ); ?></a>
			</div><!-- close #skrn-landing-login-logout-header -->
		<?php else: ?>
			<?php if(function_exists('arm_check_for_wp_rename')  ): ?>
			<div id="skrn-landing-login-logout-header">
				<?php 
				$login_text = esc_html__('Log In' , 'skrn-progression');
				echo do_shortcode('[arm_form id="102" assign_default_plan="0" popup="true" link_type="link" link_title="' . $login_text . '" overlay="0.85" modal_bgcolor="#ffffff" popup_height="auto" popup_width="700" link_css="" link_hover_css="" form_position="center" assign_default_plan="0" logged_in_message="You are already logged in."]'); ?>
			</div><!-- close #skrn-landing-login-logout-header -->
			<?php endif; ?>
		<?php endif; ?>
		
		
		<div id="mobile-menu-icon-pro" class="noselect"><i class="fas fa-bars"></i><?php if (get_theme_mod( 'progression_studios_mobile_menu_text') == 'on' ) : ?><span class="progression-mobile-menu-text"><?php echo esc_html__( 'Menu', 'skrn-progression' )?></span><?php endif; ?></div>

		<div class="clearfix-pro"></div>
	</div><!-- close .width-container-pro -->

		
<?php
}



/* Modify Default Category Widget */
add_filter('wp_list_categories', 'progression_studios_add_span_cat_count');
function progression_studios_add_span_cat_count($links) {
	$links = str_replace('</a> (', ' <span class="count">', $links);
	
	$links = str_replace('(', '', $links);
	
	$links = str_replace(')', '</span></a>', $links);
	return $links;
}

add_filter('get_archives_link', 'progression_studios_archive_count_span');
function progression_studios_archive_count_span($links) {
	$links = str_replace('</a>&nbsp;(', ' <span class="count">', $links);
	$links = str_replace(')', '</span></a>', $links);
return $links;
}



/**
 * Display comment in home & archive page
 * https://deluxeblogtips.com/display-comments-in-homepage/
 *
 * @return void
 */
function progression_studios_review_callback( $comment, $args, $depth )
{
    ?>
	 
 	<div class="rate-this-video-skrn-pro">
		
	
 		<?php 
		
		if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
			$stars = '<div class="skrn-pro-star-comments">';
			$stars .= '<div class="skrn-pro-star-filled">';
		
			for ( $i = 1; $i <= $rating; $i++ ) {
				$stars .= '<span class="dashicons dashicons-star-filled"></span>';
			}
			$stars .= '</div>';
		
			$stars .= '<div class="skrn-pro-star-empty">';
			for ( $i = 1; $i <= 10; $i++ ) {
				$stars .= '<span class="dashicons dashicons-star-empty"></span>';
			}
			$stars .= '</div>';
		
			$stars .= '</div>';
			echo wp_kses($stars, true);
		}
		?>
		<?php if (0 == $comment->comment_approved) { ?>
			<span class="under-moderation-rating-index"><?php echo esc_html_e( 'Your review is currently awaiting moderation.', 'skrn-progression' ); ?><span>
		<?php } ?>
		
 	</div>
	
	
    <?php
}

/**
 * Display comment in home & archive page
 * https://deluxeblogtips.com/display-comments-in-homepage/
 *
 * @return void
 */
function progression_studios_comment_callback( $comment, $args, $depth )
{
    ?>
	 
 	<li>
		
		<?php $rating_formatted_edit = get_comment_meta( get_comment_ID(), 'rating', true );?>
      <div
        class="circle-rating-pro"
        data-value="<?php if ( $rating_formatted_edit == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_formatted_edit); ?><?php endif; ?>"
        data-animation-start-value="<?php if ( $rating_formatted_edit == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_formatted_edit); ?><?php endif; ?>"
        data-size="32"
        data-thickness="2"
		  
		<?php if ( $rating_formatted_edit > '6.9'  ) : ?>
	        data-fill="{
	          &quot;color&quot;: &quot;<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_color', '#42b740') ); ?>&quot;
	        }"
	        data-empty-fill="<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_secondary_color', '#def6de') ); ?>"
	        data-reverse="true"
	      ><span style="color:<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_color', '#42b740') ); ?>;">
			<?php else: ?>
		        data-fill="{
		          &quot;color&quot;: &quot;<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_negative_color', '#ff4141') ); ?>&quot;
		        }"
		        data-empty-fill="<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_negative_secondary_color', '#ffe1e1') ); ?>"
		        data-reverse="true"
		      ><span style="color:<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_negative_color', '#ff4141') ); ?>;">
		<?php endif; ?>

		  <?php if ( $rating_formatted_edit == '10'  ) : ?>10<?php else: ?><?php echo number_format((float)$rating_formatted_edit, 1, '.', '');	?><?php endif; ?></span></div>
 		<!-- ?php echo get_avatar( $comment, 30 ); ? -->
 		<h6><?php printf( get_comment_author_link() ); ?></h6>
 		<!--div class="sidebar-review-time"><?php printf( get_comment_date() ); ?></div-->
 		<?php 
		$spoiler = get_comment_meta( $comment->comment_ID, 'spoiler', true );
		if ( $spoiler == 'on' || $spoiler == '1'  ) : ?><div class="spoiler-review"><?php esc_html_e( 'Contains Spoiler', 'skrn-progression' ); ?></div><?php endif; ?>
		
		<?php
			$comment_text_count = strip_tags( get_comment_text() );
			$comment_text_number = explode(' ', $comment_text_count);
		?>
		
	

 		<div class="sidebar-comment-exerpt<?php if (count($comment_text_number)  > 20 ) : ?> sidebar-excerpt-more-click<?php endif; ?>">
			<div class="sidebar-comment-exerpt-text"><?php echo get_comment_excerpt(); ?></div>
	 		<?php if (count($comment_text_number)  > 20 ) : ?>
				<div class="read-more-comment-sidebar"><?php echo esc_html__( 'Read more', 'skrn-progression' )?></div>
				<div class="sidebar-comment-full"><?php echo get_comment_text(); ?></div>
			<?php endif; ?>
		</div>
 	</li>
	
	
    <?php
}

add_filter( 'comment_author', 'custom_comment_author', 10, 2 );

function custom_comment_author( $author, $commentID ) {

    $comment = get_comment( $commentID );
    $user = get_user_by( 'email', $comment->comment_author_email );

    if( !$user ):

        return $author;

    else:

        $firstname = get_user_meta( $user->ID, 'first_name', true );
        $lastname = get_user_meta( $user->ID, 'last_name', true );

        if( empty( $firstname ) OR empty( $lastname ) ):

            return $author;

        else:

            return $firstname . ' ' . $lastname;

        endif;

    endif;

}


function progression_studios_comment_fullscreen( $comment, $args, $depth )
{
    ?>
	 
 	<li>
		
		<?php $rating_formatted_edit = get_comment_meta( get_comment_ID(), 'rating', true );?>
      <div
        class="circle-rating-pro"
       data-value="<?php if ( $rating_formatted_edit == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_formatted_edit); ?><?php endif; ?>"
       data-animation-start-value="<?php if ( $rating_formatted_edit == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_formatted_edit); ?><?php endif; ?>"
        data-size="32"
        data-thickness="2"
		<?php if ( $rating_formatted_edit > '6.9'  ) : ?>
	        data-fill="{
	          &quot;color&quot;: &quot;<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_color', '#42b740') ); ?>&quot;
	        }"
	        data-empty-fill="<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_secondary_color', '#def6de') ); ?>"
	        data-reverse="true"
	      ><span style="color:<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_color', '#42b740') ); ?>;">
			<?php else: ?>
		        data-fill="{
		          &quot;color&quot;: &quot;<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_negative_color', '#ff4141') ); ?>&quot;
		        }"
		        data-empty-fill="<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_negative_secondary_color', '#ffe1e1') ); ?>"
		        data-reverse="true"
		      ><span style="color:<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_negative_color', '#ff4141') ); ?>;">
		<?php endif; ?>
		  
		  <?php if ( $rating_formatted_edit == '10'  ) : ?>10<?php else: ?><?php echo number_format((float)$rating_formatted_edit, 1, '.', '');	?><?php endif; ?></span></div>
			  
			  
  			<div class="skrn-review-full-avatar"><?php echo get_avatar( $comment, 30 ); ?></div>
 		<h6><?php printf( get_comment_author_link() ); ?></h6>
 		<!--div class="sidebar-review-time"><?php printf( get_comment_date() ); ?></div-->
 		<?php 
		$spoiler = get_comment_meta( $comment->comment_ID, 'spoiler', true );
		if ( $spoiler == 'on' || $spoiler == '1'  ) : ?><div class="spoiler-review"><?php esc_html_e( 'Contains Spoiler', 'skrn-progression' ); ?></div><?php endif; ?>
		
		
		
		
		<?php
			$comment_text_count = strip_tags( get_comment_text() );
			$comment_text_number = explode(' ', $comment_text_count);
		?>
 		<div class="sidebar-comment-exerpt<?php if (count($comment_text_number)  > 20 ) : ?> sidebar-excerpt-more-click<?php endif; ?>">
			<div class="sidebar-comment-exerpt-text"><?php echo get_comment_excerpt(); ?></div>
	 		<?php if (count($comment_text_number)  > 20 ) : ?>
				<div class="read-more-comment-sidebar"><?php echo esc_html__( 'Read more', 'skrn-progression' )?></div>
				<div class="sidebar-comment-full"><?php echo get_comment_text(); ?></div>
			<?php endif; ?>
		</div>
 	</li>
	
	
    <?php
}



function progression_studios_blog_link() {
	global $post;
?>
	
	<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_link_url'): ?>
		
		<a href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>">
		<?php else: ?>
			
		<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_link_url_new_window'): ?>
			
			<a href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>" target="_blank">
			<?php else: ?>
				
				<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_link_lightbox'): ?>
					
					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large'); ?>
					<a href="<?php echo esc_attr($image[0]);?>" data-rel="prettyPhoto" <?php $get_description = get_post(get_post_thumbnail_id())->post_excerpt; if(!empty($get_description)){ echo 'title="' . $get_description . '"'; } ?>>
					<?php else: ?>
							
						<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_lightbox_video'): ?>
							
							<a href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>" data-rel="prettyPhoto" <?php $get_description = get_post(get_post_thumbnail_id())->post_excerpt; if(!empty($get_description)){ echo 'title="' . $get_description . '"'; } ?>>
							<?php else: ?>
								
								<a href="<?php the_permalink(); ?>">
																
						<?php endif; ?>
						
				<?php endif; ?>
				
		<?php endif; ?>
		
	<?php endif; ?>
	
<?php
}





function progression_studios_blog_post_title() {
	global $post;
?>

	<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_link_url'): ?>
		
		<a href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>">
			
		<?php else: ?>
			
		<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_link_url_new_window'): ?>
			
			<a href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>" target="_blank">
			
			<?php else: ?>

				<a href="<?php the_permalink(); ?>">
						
		<?php endif; ?>
		
	<?php endif; ?>
	
<?php
}




function progression_studios_blog_index_gallery() {
?>	
<?php global $post; if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_link_url'): ?>
		href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>"
		<?php else: ?>
			
		<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_link_url_new_window'): ?>
			href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>" target="_blank"	
			
			<?php else: ?>

						<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_lightbox_video'): ?>
							
							href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>" data-rel="prettyPhoto" <?php $get_description = get_post(get_post_thumbnail_id())->post_excerpt; if(!empty($get_description)){ echo 'title="' . $get_description . '"'; } ?>
							
							<?php else: ?>
								
								href="<?php the_permalink(); ?>"
						
				<?php endif; ?>
				
		<?php endif; ?>
		
	<?php endif; ?>
	
<?php
}



//Rating Calculation
add_action( 'comment_post', 'skrn_progression_studios_update_average_ratings', 999 );
function skrn_progression_studios_update_average_ratings( $comment_id ) {
	$comment = get_comment( $comment_id ); 
	$comment_post_id = $comment->comment_post_ID ;
	$rating = skrn_pro_comment_rating_get_average_ratings( $comment_post_id );
	update_post_meta( $comment_post_id, '_average_ratings', $rating );
}

add_action( 'init', 'skrn_progression_studios_update_average_ratings_update', 10 );
function skrn_progression_studios_update_average_ratings_update() {
	if( isset( $_GET['giang'] ) ) {
		$posts = get_posts(array(
			'post_type'	=> 'video_skrn',
			'posts_per_page'	=> -1
		));
		foreach( $posts as $post ) {
			$rating = skrn_pro_comment_rating_get_average_ratings( $post->ID );
			update_post_meta( $post->ID, '_average_ratings', $rating );
		}
	}
}

add_action('wp_head', 'skrn_progression_studios_update_average_ratings_post');
function skrn_progression_studios_update_average_ratings_post(){
	global $post;
	if( is_singular("video_skrn") ){
		$rating = skrn_pro_comment_rating_get_average_ratings( $post->ID );
		update_post_meta( $post->ID, '_average_ratings', $rating );
	}
}



/* remove more link jump */
function progression_studios_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'progression_studios_remove_more_link_scroll' );




if ( ! function_exists( 'progression_studios_show_pagination_links_pro' ) ) :
function progression_studios_show_pagination_links_pro()
{
    global $wp_query;

    $page_tot   = $wp_query->max_num_pages;
    $page_cur   = get_query_var( 'paged' );
    $big        = 999999999;

    if ( $page_tot == 1 ) return;

    echo paginate_links( array(
            'base'      => str_replace( $big, '%#%',get_pagenum_link( 999999999, false ) ), // need an unlikely integer cause the url can contains a number
            'format'    => '?paged=%#%',
            'current'   => max( 1, $page_cur ),
            'total'     => $page_tot,
            'prev_next' => true,
				'prev_text'    => '<span>' . esc_html__('&lsaquo; Previous', 'skrn-progression') . '</span>',
				'next_text'    => '<span>' . esc_html__('Next &rsaquo;', 'skrn-progression'). '</span>',
            'end_size'  => 1,
            'mid_size'  => 2,
            'type'      => 'list'
        )
    );
}
endif;




function is_progression_studios_blog () {
    return ( is_archive() && !is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
	 //https://wordpress.stackexchange.com/questions/107141/check-if-current-page-is-the-blog-page
}


if ( ! function_exists( 'progression_studios_show_pagination_links_blog' ) ) :
function progression_studios_show_pagination_links_blog()
{	
    global $blogloop;

    $page_tot   = $blogloop->max_num_pages;
	 if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {   $paged = get_query_var('page'); } else {  $paged = 1; }
    $big        = 999999999;

    if ( $page_tot == 1 ) return;

    echo paginate_links( array(
            'base'      => str_replace( $big, '%#%',get_pagenum_link( 999999999, false ) ), // need an unlikely integer cause the url can contains a number
            'format'    => '?paged=%#%',
            'current'   => max( 1, $paged ),
            'total'     => $page_tot,
            'prev_next' => true,
				'prev_text'    => '<span>' . esc_html__('&lsaquo; Previous', 'skrn-progression') . '</span>',
				'next_text'    => '<span>' . esc_html__('Next &rsaquo;', 'skrn-progression'). '</span>',
            'end_size'  => 1,
            'mid_size'  => 2,
            'type'      => 'list'
        )
    );
}
endif;







if ( ! function_exists( 'progression_studios_infinite_content_nav_pro' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function progression_studios_infinite_content_nav_pro( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div id="infinite-nav-pro-default" class="infinite-nav-pro">
			<div class="nav-previous"><?php next_posts_link( wp_kses( __('Load More <span><i class="fa fa-arrow-circle-down"></i></span>', 'skrn-progression' ) , TRUE) ); ?></div>
		</div>
	<?php endif;
}
endif;




function progression_studios_category_title( $title ) {
   if ( is_category() ) {

           $title = single_cat_title( '', false );

       } elseif ( is_tag() ) {

           $title = single_tag_title( '', false );

       }

   return $title;
}
add_filter( 'get_the_archive_title', 'progression_studios_category_title' );



/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function progression_studios_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'progression_studios_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'progression_studios_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so progression_studios_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so progression_studios_categorized_blog should return false.
		return false;
	}
}

