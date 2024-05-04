<?php
function wpvs_social_sharing_buttons($content) {
	global $post;
	if(is_singular() || is_home()){
	
		// Get current page URL 
		$wpvsURL = urlencode(get_permalink());
 
		// Get current page title
		$wpvsTitle = str_replace( ' ', '%20', get_the_title());
		
		// Get Post Thumbnail for pinterest
		$wpvsThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
 
		// Construct sharing URL without using any script
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$wpvsTitle.'&amp;url='.$wpvsURL.'&amp;via=Crunchify';
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$wpvsURL;
		$googleURL = 'https://plus.google.com/share?url='.$wpvsURL;
		$bufferURL = 'https://bufferapp.com/add?url='.$wpvsURL.'&amp;text='.$wpvsTitle;
		$whatsappURL = 'whatsapp://send?text='.$wpvsTitle . ' ' . $wpvsURL;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$wpvsURL.'&amp;title='.$wpvsTitle;
 
		// Based on popular demand added Pinterest too
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$wpvsURL.'&amp;media='.$wpvsThumbnail[0].'&amp;description='.$wpvsTitle;
 
		// Add sharing button at the end of page/page content
		$content .= '<!-- Crunchify.com social sharing. Get your copy here: http://wpvs.me/1VIxAsz -->';
		$content .= '<div class="wpvs-social">';
		$content .= '<h5>SHARE ON</h5> <a class="wpvs-link wpvs-twitter" href="'. $twitterURL .'" target="_blank">Twitter</a>';
		$content .= '<a class="wpvs-link wpvs-facebook" href="'.$facebookURL.'" target="_blank">Facebook</a>';
		$content .= '<a class="wpvs-link wpvs-whatsapp" href="'.$whatsappURL.'" target="_blank">WhatsApp</a>';
		$content .= '<a class="wpvs-link wpvs-googleplus" href="'.$googleURL.'" target="_blank">Google+</a>';
		$content .= '<a class="wpvs-link wpvs-buffer" href="'.$bufferURL.'" target="_blank">Buffer</a>';
		$content .= '<a class="wpvs-link wpvs-linkedin" href="'.$linkedInURL.'" target="_blank">LinkedIn</a>';
		$content .= '<a class="wpvs-link wpvs-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank">Pin It</a>';
		$content .= '</div>';
		
		return $content;
	}else{
		// if not a post/page then don't include sharing button
		return $content;
	}
};
//add_filter( 'the_content', 'wpvs_social_sharing_buttons');