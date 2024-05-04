<?php

class WPVS_THEME_YOAST_SEO_META_FILTERS {
    public function __construct() {
        add_filter( 'wpseo_opengraph_image', [$this, 'wpvs_theme_yoast_seo_fb_share_images'], 10, 1 );
        add_filter( 'wpseo_twitter_image', [$this, 'wpvs_theme_yoast_seo_tw_share_images'], 10, 1 );
    }

    protected function get_term_image() {
        global $wp_query;
        $wpvs_term_id = $wp_query->get_queried_object_id();
        $wpvs_video_image_src = null;
        $wpvs_video_image_width = null;
        $wpvs_video_image_height = null;
        $cat_thumbnail_image_id = get_term_meta($wpvs_term_id, 'wpvs_video_cat_attachment', true);
        if( ! empty($cat_thumbnail_image_id) ) {
            $wpvs_video_image_data = wp_get_attachment_image_src($cat_thumbnail_image_id, 'full', false);
            if( ! empty($wpvs_video_image_data) ) {
                $wpvs_video_image_src = $wpvs_video_image_data[0];
                $wpvs_video_image_width = $wpvs_video_image_data[1];
                $wpvs_video_image_height = $wpvs_video_image_data[2];
            }
        } else {
            $wpvs_video_image_src =  get_term_meta($wpvs_term_id, 'wpvs_video_cat_thumbnail', true);
        }
        return (object) array('src' => $wpvs_video_image_src, 'width' => $wpvs_video_image_width, 'height' => $wpvs_video_image_height);
    }

    public function wpvs_theme_yoast_seo_fb_share_images( $img ) {
        if( is_tax('rvs_video_category') ) {
            $wpvs_term_image = $this->get_term_image();
            if( ! empty($wpvs_term_image->src) ) {
                $img = $wpvs_term_image->src;
            }
        }
    	return $img;
    }

    public function wpvs_theme_yoast_seo_tw_share_images( $img ) {
        if( is_tax('rvs_video_category') ) {
            $wpvs_term_image = $this->get_term_image();
            if( ! empty($wpvs_term_image->src) ) {
                $img = $wpvs_term_image->src;
            }
        }
    	return $img;
    }
}
$wpvs_theme_yoast_seo_meta_filters = new WPVS_THEME_YOAST_SEO_META_FILTERS();
