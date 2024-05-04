<?php if(get_option('social-media-links')) :
    $sociallinks = get_option('social-media-links');
?>
    <div class="socialmedia">
        <?php if( ! empty($sociallinks['facebook']) ) { ?>
            <a class="border-box" href="<?php echo $sociallinks['facebook']; ?>" target="_blank"><i class="fab fa-facebook"></i></a>
        <?php } if( ! empty($sociallinks['twitter']) ) { ?>
            <a class="border-box"  href="<?php echo $sociallinks['twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
        <?php } if( ! empty($sociallinks['google']) ) { ?>
            <a class="border-box"  href="<?php echo $sociallinks['google']; ?>" target="_blank"><i class="fab fa-google-plus-g"></i></a>
        <?php } if( ! empty($sociallinks['instagram']) ) { ?>
            <a class="border-box"  href="<?php echo $sociallinks['instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
        <?php } if( ! empty($sociallinks['youtube']) ) { ?>
            <a class="border-box"  href="<?php echo $sociallinks['youtube']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
        <?php } if( ! empty($sociallinks['linkedin']) ) { ?>
            <a class="border-box"  href="<?php echo $sociallinks['linkedin']; ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
        <?php } if( ! empty($sociallinks['pinterest']) ) { ?>
            <a class="border-box"  href="<?php echo $sociallinks['pinterest']; ?>" target="_blank"><i class="fab fa-pinterest"></i></a>
        <?php } ?>
    </div>
<?php endif; ?>