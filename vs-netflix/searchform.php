<form role="search" method="get" id="searchform" class="search-form ease3" action="<?php echo home_url( '/' ); ?>">
<div id="searchContain">
    <input type="search" class="search-field" placeholder="<?php _e( 'Enter Search', 'wpvs-theme' ); ?>" value="<?php echo get_search_query() ?>" name="s" />

	<input type="submit" class="search-submit primary" value="<?php _e( 'Search', 'wpvs-theme' ); ?>" />
</div>
</form>