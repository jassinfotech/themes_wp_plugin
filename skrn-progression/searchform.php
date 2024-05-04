<?php
/**
 * The template for displaying search forms in progression
 *
 * @package pro
 */
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'skrn-progression' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Enter a keyword to search...', 'placeholder', 'skrn-progression' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_html__( 'Submit', 'skrn-progression' ); ?>">
	<div class="clearfix-pro"></div>
</form>