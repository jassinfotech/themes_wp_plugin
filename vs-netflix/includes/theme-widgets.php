<?php

class WPVS_Theme_Videos_List_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'wp_videos_list_widget', // Base ID
			__( 'Related Videos', 'wpvs-theme' ), // Name
			array( 'description' => __( 'Lists related and recently added videos.', 'wpvs-theme' ) ) // Args
		);
	}
	public function widget( $args, $instance ) {
        global $post;
        global $wpvs_video_slug_settings;
		global $wpvs_theme_is_active;
		global $wpvs_theme_thumbnail_sizing;
		global $wpvs_theme_video_manager;
        $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
        $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
        $wpvs_widget_style = "default";
        $number_of_videos = $instance['number_of_posts'];
		$display_video_category = false;
		$display_video_cast = false;
        $wpvs_related_videos = array();
        $wpvs_thumbnail_layout = get_option('thumbnail-layout', 'landscape');
        $wpvs_recent_videos_widget_ouput = $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
			$wpvs_recent_videos_widget_ouput .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
        if ( ! empty( $instance['wpvs_widget_style'] ) ) {
			$wpvs_widget_style = $instance['wpvs_widget_style'];
		}
		if ( isset($instance['wpvs_show_video_category']) && ! empty( $instance['wpvs_show_video_category'] ) ) {
			$display_video_category = true;
		}
		if ( isset($instance['wpvs_show_video_cast']) && ! empty( $instance['wpvs_show_video_cast'] ) ) {
			$display_video_cast = true;
		}

        $wpvs_get_video_args = array(
            'post_type' => 'rvs_video',
            'posts_per_page' => $number_of_videos
        );

        if( $post && isset($post->ID) ) {
            $wpvs_get_video_args['post__not_in'] = array($post->ID);
        }

		$wpvs_theme_video_manager->set_default_video_args($wpvs_get_video_args);
		$wpvs_theme_video_manager->apply_video_ordering_filters();

        if( is_singular('rvs_video') ) {
			$wpvs_related_videos = $wpvs_theme_video_manager->get_related_widget_videos( $post->ID, $display_video_category, $display_video_cast );
        }

        if(  count($wpvs_related_videos) < $number_of_videos ) {
            if( isset($wpvs_theme_video_manager->video_args['tax_query']) ) {
                unset($wpvs_theme_video_manager->video_args['tax_query']);
            }
            $wpvs_theme_video_manager->video_args['posts_per_page'] = $number_of_videos - count($wpvs_related_videos);
            $wpvs_more_videos = get_posts($wpvs_theme_video_manager->video_args);
            if( ! empty($wpvs_more_videos) ) {
				$wpvs_more_related_videos = $wpvs_theme_video_manager->append_widget_videos( $wpvs_more_videos, $display_video_category, $display_video_cast );
				if( ! empty($wpvs_more_related_videos) ) {
                	$wpvs_related_videos = array_merge($wpvs_related_videos, $wpvs_more_related_videos);
				}
            }
        }

        if( ! empty($wpvs_related_videos) ) {
            $wpvs_recent_videos_widget_ouput .= '<ul class="recent-videos-side '.$wpvs_widget_style.'">';
            foreach($wpvs_related_videos as $video) {
				if( empty($video->video_thumbnail->src) ) {
					$video->video_thumbnail->src = $wpvs_theme_thumbnail_sizing->placeholder;
				}
                $wpvs_recent_videos_widget_ouput .= '<li><div class="wpvs-recent-video-widget-item"><a href="'.$video->video_link.'"><div class="wpvs-recent-video-widget-item-image"><img src="'.$video->video_thumbnail->src.'" alt="'.$video->video_title.'" /></a></div><div class="wpvs-recent-video-widget-item-info"><a href="'.$video->video_link.'"><h3 class="wpvs-recent-video-widget-item-title">'. $video->video_title.'</h3></a>';
				if( isset($video->video_term_title) ) {
					$wpvs_recent_videos_widget_ouput .= '<label class="wpvs-recent-video-widget-item-term">'. $video->video_term_title.'</label>';
				}
				if( isset($video->video_actor_title) ) {
					$wpvs_recent_videos_widget_ouput .= '<label class="wpvs-recent-video-widget-item-term">'. $video->video_actor_title.'</label>';
				}
				$wpvs_recent_videos_widget_ouput .= '</div></div></li>';
            }
           $wpvs_recent_videos_widget_ouput .= '</ul>';
        }
        if(isset($args['after_widget'])) {
            $wpvs_recent_videos_widget_ouput .= $args['after_widget'];
        }
        echo $wpvs_recent_videos_widget_ouput;
	}
	public function form( $instance ) {
		global $wpvs_genre_slug_settings;
		global $wpvs_actor_slug_settings;
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Related Videos', 'wpvs-theme' );
        $number_of_posts = ! empty( $instance['number_of_posts'] ) ? $instance['number_of_posts'] : __( '5', 'wpvs-theme' );
        $widget_style = ! empty( $instance['wpvs_widget_style'] ) ? $instance['wpvs_widget_style'] : __( 'default', 'wpvs-theme' );
		$show_video_category = ! empty( $instance['wpvs_show_video_category'] ) ? $instance['wpvs_show_video_category'] : 0;
		$show_video_cast = ! empty( $instance['wpvs_show_video_cast'] ) ? $instance['wpvs_show_video_cast'] : 0;
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpvs-theme' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
		<label for="<?php echo $this->get_field_id( 'number_of_posts' ); ?>"><?php _e( 'Number of posts', 'wpvs-theme' ); ?>:</label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_of_posts' ); ?>" type="number" min="1" value="<?php echo esc_attr( $number_of_posts ); ?>">
		</p>
        <p>
		<label for="<?php echo $this->get_field_id( 'wpvs_widget_style' ); ?>"><?php _e( 'Widget Style', 'wpvs-theme' ); ?>:</label>
		<select id="<?php echo $this->get_field_id( 'wpvs_widget_style' ); ?>" name="<?php echo $this->get_field_name( 'wpvs_widget_style' ); ?>">
            <option value="default" <?php selected('default', $widget_style); ?>><?php _e('Default', 'wpvs-theme'); ?></option>
            <option value="youtube" <?php selected('youtube', $widget_style); ?>><?php _e('YouTube', 'wpvs-theme'); ?></option>
        </select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'wpvs_show_video_category' ); ?>"><?php echo sprintf(__( 'Show %s', 'wpvs-theme' ), $wpvs_genre_slug_settings['name']); ?>:</label>
		<input id="<?php echo $this->get_field_id( 'wpvs_show_video_category' ); ?>" name="<?php echo $this->get_field_name( 'wpvs_show_video_category' ); ?>" type="checkbox" value="1" <?php checked(1, $show_video_category); ?>>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'wpvs_show_video_cast' ); ?>"><?php echo sprintf(__( 'Show %s', 'wpvs-theme' ), $wpvs_actor_slug_settings['name']); ?>:</label>
		<input id="<?php echo $this->get_field_id( 'wpvs_show_video_cast' ); ?>" name="<?php echo $this->get_field_name( 'wpvs_show_video_cast' ); ?>" type="checkbox" value="1" <?php checked(1, $show_video_cast); ?>>
		</p>
        <p><?php _e('Lists related and recently added videos', 'wpvs-theme'); ?>.</p>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number_of_posts'] = ( ! empty( $new_instance['number_of_posts'] ) ) ? strip_tags( $new_instance['number_of_posts'] ) : '';
        $instance['wpvs_widget_style'] = ( ! empty( $new_instance['wpvs_widget_style'] ) ) ? strip_tags( $new_instance['wpvs_widget_style'] ) : '';
		$instance['wpvs_show_video_category'] = ( ! empty( $new_instance['wpvs_show_video_category'] ) ) ? strip_tags( $new_instance['wpvs_show_video_category'] ) : 0;
		$instance['wpvs_show_video_cast'] = ( ! empty( $new_instance['wpvs_show_video_cast'] ) ) ? strip_tags( $new_instance['wpvs_show_video_cast'] ) : 0;
		return $instance;
	}
}

class WPVS_Theme_Taxonomy_List_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'wp_videos_category_list_widget', // Base ID
			__( 'Video Categories', 'wpvs-theme' ), // Name
			array( 'description' => __( 'Lists created Video Categories.', 'wpvs-theme' ), ) // Args
		);
	}
	public function widget( $args, $instance ) {
		global $wpvs_video_slug_settings;
		echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
        $args = array(
            'hide_empty' => 0,
            'parent'      => 0,
            'meta_key' => 'video_cat_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        );
        $video_categories = get_terms('rvs_video_category', $args);
        if($video_categories) {
            echo '<ul>';
            foreach($video_categories as $vid_cat) {
				$wpvs_term_link =  get_term_link($vid_cat->term_id);
                echo '<li><a href="'.$wpvs_term_link.'">'.$vid_cat->name.'</a></li>';
            }
            echo '</ul>';
        }
		if(isset($args['after_widget'])) {
		  echo $args['after_widget'];
        }
	}
	public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Video Categories', 'wpvs-theme' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpvs-theme' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p><?php _e('Lists created Video Categories.', 'wpvs-theme'); ?></p>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

class WPVS_Theme_Social_Media_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'wpvs_social_widget', // Base ID
			__( 'Social Accounts', 'wpvs-theme' ), // Name
			array( 'description' => __( 'Displays social media accounts.', 'wpvs-theme' ) )
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
        get_template_part('social-media');
        if(isset($args['after_widget'])) {
		  echo $args['after_widget'];
        }
	}
	public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Connect with us', 'wpvs-theme' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpvs-theme' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p><?php _e('Displays social media accounts. Add social accounts', 'wpvs-theme');
        echo ' <a href="'.admin_url('admin.php?page=wpvs-social-options') .'">';
        _e('here', 'wpvs-theme');
        echo '</a>.'; ?></p>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number_of_posts'] = ( ! empty( $new_instance['number_of_posts'] ) ) ? strip_tags( $new_instance['number_of_posts'] ) : '';
		return $instance;
	}
}

function register_wpvs_theme_widgets() {
	register_widget( 'WPVS_Theme_Videos_List_Widget' );
    register_widget( 'WPVS_Theme_Taxonomy_List_Widget' );
    register_widget( 'WPVS_Theme_Social_Media_Widget' );
}
add_action( 'widgets_init', 'register_wpvs_theme_widgets' );
