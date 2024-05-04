<?php

// [wpvs-featured-area slider="id"]
function wpvs_featured_sliders_shortcode( $atts ) {
    
    if( ! wp_style_is('flexslider-style', 'enqueued') ) {
        wp_enqueue_style( 'flexslider-styles' );
    }
    
    if( ! wp_style_is('wpvs-featured-area', 'enqueued') ) {
        wp_enqueue_style( 'wpvs-featured-area' );
    }
    
    if( ! wp_script_is('flexslider-js', 'enqueued') ) {
        wp_enqueue_script( 'flexslider-js' );
    }
    
    if( ! wp_script_is('vs-featured-slider', 'enqueued') ) {
        wp_enqueue_script( 'vs-featured-slider' );
        $slider_speed = get_theme_mod('vs_slide_speed', '4000');
        wp_localize_script( 'vs-featured-slider', 'wpvsslider',
            array( 'speed' => $slider_speed));
    }
    
    $wpvs_slider_atts = shortcode_atts( array(
        'slider' => '0',
        'inline' => 0
    ), $atts );
    
    $inline_featured_area = false;
    if( isset($wpvs_slider_atts['inline']) && $wpvs_slider_atts['inline']) {
        $inline_featured_area = true;
    }
    
    $wpsv_created_sliders = get_option('wpvs_slider_array');
    if( ! empty($wpsv_created_sliders) ) {
        $slide_max_height = null;
        foreach($wpsv_created_sliders as $slider) {
            if($slider['id'] == $wpvs_slider_atts['slider']) {
                $slides = $slider['blocks'];
                if( isset($slider['max_height']) && ! empty($slider['max_height'])) {
                    $slide_max_height = $slider['max_height'];
                }
                break;
            }
        }

        if(!empty($slides)) {
            $slideContent = '<div id="featured" class="flexslider wpvs-flexslider';
            if($inline_featured_area) {
                $slideContent .= ' wpvs-inline-featured-area';
            }
            $slideContent .= '"';
            if( ! empty($slide_max_height) ) {
                $slideContent .= 'style="max-height: '.$slide_max_height.';"';
            }

            $slideContent .= '><ul class="slides">';

            foreach($slides as &$slide) {

                if( isset($slide['backgroundtype']) && ! empty($slide['backgroundtype'])) {
                    $wpvs_slide_type = $slide['backgroundtype'];
                } else {
                    $wpvs_slide_type = 'image';
                }
                
                if( isset($slide['video_aspect_ratio']) && ! empty($slide['video_aspect_ratio'])) {
                    $slide_aspect_ratio = $slide['video_aspect_ratio'];
                } else {
                    $slide_aspect_ratio = '';
                }
                
                if($wpvs_slide_type == 'video' || $wpvs_slide_type == 'youtube' || $wpvs_slide_type == 'vimeo' || $wpvs_slide_type == 'custom') {
                    $slide_video_background_image = null;
                    if( isset($slide['video']) && ! empty($slide['video'])) {
                        $slide_video_id = intval($slide['video']);
                        $slide_video_background_image = get_the_post_thumbnail_url($slide_video_id, 'wpvs-theme-header');
                    }
                    
                    if( $wpvs_slide_type == 'video' && isset($slide['videourl']) && ! empty($slide['videourl']) ) {
                        $slide_video_url = $slide['videourl'];
                        $slide_video_html = '<video preload="metadata" loop><source type="video/mp4" src="'.$slide_video_url.'"';
                        if( ! empty($slide_video_background_image) ) {
                            $slide_video_html .= ' poster="'.$slide_video_background_image.'"';
                        }
                        $slide_video_html .= '></video>';
                        $slide_video_id = '0';
                    }

                    if( $wpvs_slide_type == 'youtube' && isset($slide['youtubeid']) && ! empty($slide['youtubeid']) ) {
                        $slide_youtube_id = $slide['youtubeid'];
                        $youtube_video_link = '//www.youtube.com/embed/' . $slide_youtube_id . '?controls=0&showinfo=0&rel=0&origin='.home_url().'&loop=1&enablejsapi=1';
                        $slide_video_html = '<iframe src="' . $youtube_video_link . '" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" allow="autoplay"></iframe>';
                        $slide_video_id = $slide_youtube_id;
                    } 

                    if( $wpvs_slide_type == 'vimeo' && isset($slide['vimeoid']) && ! empty($slide['vimeoid']) ) {
                        $slide_vimeo_id = $slide['vimeoid'];
                        $vimeo_video_link = 'https://player.vimeo.com/video/' . $slide_vimeo_id . '?background=1';
                        $slide_video_html = '<iframe src="' . $vimeo_video_link . '" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" allow="autoplay"></iframe>';
                        $slide_video_id = $slide_vimeo_id;
                    }

                    if( $wpvs_slide_type == 'custom' && isset($slide['custom_iframe']) && ! empty($slide['custom_iframe']) ) {
                        $slide_video_html = stripslashes($slide['custom_iframe']);
                        $slide_video_id = '0';
                    }

                    if( isset($slide['muted']) ) {
                        $slide_video_muted = $slide['muted'];
                    } else {
                        $slide_video_muted = 1;
                    }

                    $slideContent .= '<li class="wpvs-video-flex-slide wpvs-featured-slide '.$slide_aspect_ratio.'"><div class="wpvs-video-flex-container '.$wpvs_slide_type.'" data-videoid="'.$slide_video_id.'" data-muted="'.$slide_video_muted.'">'.$slide_video_html;
                    if( ! empty($slide_video_background_image) ) {
                        $slideContent .= '<img class="wpvs-video-slide-fallback-image" src="'.$slide_video_background_image.'">';
                    }
                    $slideContent .= '</div>';
                    $slideContent .= '<label class="wpvs-slide-mute-button '.($slide_video_muted == 1 ? 'muted':'').' '.$wpvs_slide_type.'">'.($slide_video_muted == 1 ? '<span class="dashicons dashicons-controls-volumeoff"></span></i>':'<span class="dashicons dashicons-controls-volumeon"></span>').'</label>';
                    
                } else {
                    $slideContent .= '<li class="wpvs-image-flex-slide wpvs-featured-slide" style="background: url(' .$slide['image'].') no-repeat top / cover;">';
                }
                
                if( isset($slide['align']) ) {
                    $slide_alignment = 'slider-content-'.$slide['align'];
                } else {
                    $slide_alignment = 'slider-content-left';
                }
                
                if( isset($slide['button_size']) ) {
                    $slide_button_size = $slide['button_size'];
                } else {
                    $slide_button_size = 'default';
                }


                if( ( isset($slide['link']) && ! empty($slide['link']) ) && ( isset($slide['whole']) && ! empty($slide['whole']) ) ) {
                    $slideContent .= '<a class="vs-slide-link-full" href="'.$slide['link'].'"></a>';
                }

                $slideContent .= '<div class="slider-container '.$slide_alignment.'"><div class="wpvs-featured-slide-content sliderContent border-box">';

                if(isset($slide['title']) && $slide['title'] != "") {
                    $slideContent .= '<h2 class="sliderTitle">' . $slide['title'] .'</h2>';
                }

                if(isset($slide['description']) && ! empty($slide['description']) ) {
                    $slide_description = stripslashes($slide['description']);
                    $slide_description = nl2br($slide_description);
                    $slideContent .= '<div class="sliderDescription"><p>' . $slide_description .'</p></div>';
                }

                if( ( isset($slide['link']) && ! empty($slide['link']) ) && ( isset($slide['link_text']) && ! empty($slide['link_text']) ) ) {
                    if($slide['tab'] === "true") {
                        $slideContent .= '<a class="button '.$slide_button_size.'" href="' . $slide['link'] . '" target="_blank">'.$slide['link_text'].'</a>';
                    } else {
                        $slideContent .= '<a class="button '.$slide_button_size.'" href="' . $slide['link'] . '">'.$slide['link_text'].'</a>';  
                    }
                }

                $slideContent .= '</div></div></li>';
            }
            $slideContent .= '</ul></div>';
        } else {
            $slideContent = false;
        }
    } else {
        $slideContent = false;
    }

    return $slideContent;
}
add_shortcode( 'wpvs-featured-area', 'wpvs_featured_sliders_shortcode' );

function wpvs_do_featured_slider($post_id) {
    $wpvs_page_featured_area_type = get_post_meta( $post_id, 'wpvs_featured_area_slider_type', true );
    if($wpvs_page_featured_area_type == "default") {
        $slider_home_id = get_post_meta($post_id, 'wpvs_featured_area_slider', true);
        if(!empty($slider_home_id)) {
            $featured_slider_shortcode = '[wpvs-featured-area slider="' . $slider_home_id . '"]';
            if(shortcode_exists('wpvs-featured-area') && do_shortcode($featured_slider_shortcode) != false) {
                echo do_shortcode($featured_slider_shortcode);
            }
        }
    }

    if($wpvs_page_featured_area_type == "shortcode") {
        $wpvs_featured_shortcode = get_post_meta( $post_id, 'wpvs_featured_shortcode', true );
        if( ! empty($wpvs_featured_shortcode) ) {
            echo do_shortcode($wpvs_featured_shortcode);
        }
    }
}