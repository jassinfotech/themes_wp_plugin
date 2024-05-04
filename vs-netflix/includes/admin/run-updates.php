<?php update_option('wpvs-theme-updates-seen', 1); ?>
<div class="wrap">
    <?php include('admin-menu.php'); ?>
    <div class="vimeosync">
        <div class="rvsPadding">
            <h1 class="rvs-title">WPVS Theme Updates</h1>
            <p>This page will display any updates and version information for the WPVS Theme Theme</p>
            <div class="wpvs-database-updates">
                <h3>Version 2.8.1</h3>
                <h4>TV Shows &amp; Series</h4>
                <p><a href="<?php echo admin_url('edit-tags.php?taxonomy=rvs_video_category&post_type=rvs_video'); ?>">Video Genre / Categories</a> have new optional TV Shows / Series settings. Below is a link to our How To video on how to setup TV Show &amp; Series video categories.</p>
                <a href="https://www.wpvideosubscriptions.com/how-to/wordpress-netflix-theme/creating-tv-shows-series/" class="rvs-button" target="_blank">Watch The Video</a>
            </div>
        </div>
    </div>
</div>
