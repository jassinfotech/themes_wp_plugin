<?php get_header(); ?>
<div class="page-container">
<?php if ( have_posts() ) : ?>
    <div class="container row">
        <?php get_template_part('side-bar-content'); ?>
    </div>
<?php else : get_template_part('nothing-found'); endif; ?>
</div>   
<?php get_footer(); ?>