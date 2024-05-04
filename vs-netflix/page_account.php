<?php /* Template Name: Membership Pages */
get_header(); ?>
<div class="page-container">
<?php if ( have_posts() ) : ?>
<div class="container row wpvs-account-page">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="col-12">
            <?php the_content(); ?>
        </div>
    <?php endwhile;  ?>
</div>
<?php else : get_template_part('nothing-found'); endif; ?>
</div>
<?php get_footer(); ?>