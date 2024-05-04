<section id="main" role="main" class="side-bar-content">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="container row">
            <div class="col-12">
                <?php if(has_post_thumbnail()) { ?>
                    <a href="<?php the_permalink(); ?>"><div class="post-thumbnail-box">
                        <?php echo the_post_thumbnail('large'); ?>
                    </div></a>
                <?php } ?>
                <a href="<?php the_permalink(); ?>"><h3 class="post-title"><?php the_title(); ?></h3></a>
                <div class="post-meta-data">
                    <span class="meta-data"><span class="dashicons dashicons-admin-comments"></span><?php comments_number( '0 comments', '1 comment', '% comments'); ?></span>
                    <span class="meta-data"><span class="dashicons dashicons-calendar-alt"></span><?php the_time('F, j, Y'); ?></span>
                </div>
                <div class="post-content">
                    <?php the_excerpt(); ?>
                </div>
                <a class="button" href="<?php the_permalink(); ?>"><?php _e('Read More', 'wpvs-theme'); ?></a>
            </div>
        </div>
    <?php endwhile; ?>
    <nav class="navigation col-12 text-align-center">
        <?php echo paginate_links( array(
                'format' => '?paged=%#%',
                'show_all' => true
            ) );
        ?>
    </nav>
</section>
<?php get_template_part('sidebar'); ?>
