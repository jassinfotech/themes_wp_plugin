<?php get_header(); ?>
<div class="page-container">
<?php if ( have_posts() ) : ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('container row'); ?>>
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="main" role="main" class="side-bar-content">
            <?php if(has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php echo the_post_thumbnail('full'); ?>
            </div>
            <?php endif; ?>
            <div class="col-12">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
            <?php if(has_tag()) {
                the_tags('Tags: ',' ','');
            } ?>
            <?php if( comments_open() ) { comments_template('/comments.php'); } ?>
            </div>
        </article>
        <?php get_template_part('sidebar'); ?>
    <?php endwhile;  ?>
</div>
<?php else : get_template_part('nothing-found'); endif; ?>
</div>
<?php get_footer(); ?>