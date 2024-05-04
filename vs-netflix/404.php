<?php /* The template for displaying 404 pages (Not Found) */
get_header(); ?>
<section id="page404">
    <div class="container row">
        <div class="col-12">
            <h1><?php _e('Oops, there is nothing here! 404', 'wpvs-theme'); ?></h1>
            <p><?php _e('If you think this is an error, please', 'wpvs-theme'); ?> <a href="mailto:<?php echo get_option('admin_email'); ?>"><?php _e('contact us', 'wpvs-theme'); ?></a>.</p>
            <a href="/"><?php _e('Go to Home Page', 'wpvs-theme'); ?></a>
        </div>
    </div>
</section>
<?php get_footer(); ?>
