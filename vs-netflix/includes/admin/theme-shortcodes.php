<div class="wrap">
    <?php include('admin-menu.php'); ?>
    <div class="vimeosync">
        <div class="rvsPadding">
            <div class="net-theme-settings">
                <h1><?php _e('WPVS Theme Shortcodes', 'wpvs-theme'); ?></h1>
                <p>You can use these shortcodes on pages and posts as you wish.</p>

                <h2>My List Shortcode</h2>
                <p>Displays users My List. Include this shortcode on the page you wish to display users My List. <a href="<?php echo admin_url('customize.php'); ?>">My List Settings</a></p>
                <div class="vs-shortcode">
                    <input type="text" readonly class="vs-shortcode-example" value='[rvs_user_my_list]'/>
                    <h4><?php _e('Optional Settings', 'wpvs-theme'); ?></h4>
                    <div class="vs-shortcode-option">
                        <input type="text" readonly class="vs-shortcode-example" value='[rvs_user_my_list show_customer_menu="1"]'/>
                        <p>Displays the WP Video Memberships customer menu above video list.</p>
                    </div>
                </div>

                <h2>Video Genre (Category) Shortcodes</h2>

                <div class="vs-shortcode">
                    <input type="text" readonly class="vs-shortcode-example" value='[netflix-categories perslide="6"]'/>
                    <p>Using the <strong>[netflix-categories perslide="<span class="vs-editable">6</span>"]</strong> shortcode, you can display <strong>all</strong> the video genre sliders anywhere on your site. <strong>A useful shortcode for those using a Page Builder</strong>.</p>
                    <ul>
                    <li>The <span class="vs-editable">perslide</span> parameter indicates how many videos you want to show per genre. You can set this to what you'd like.</li>
                    <li>Set the <span class="vs-editable">perslide</span> parameter to <strong>all</strong> or <strong>-1</strong> to display all videos in each category</li>
 	                <li>A useful shortcode for those using a Page Builder.</li>
                    </ul>
                    <input type="text" readonly class="vs-shortcode-example" value='[netflix-categories perslide="6" style="clean"]'/>
                    <ul>
                    <li>The optional <span class="vs-editable">style="clean"</span> parameter formats the slider for clean display on smaller page layouts.</li>
                    </ul>
                </div>

                <div class="vs-shortcode">
                    <label>Example Only:</label>
                    <input type="text" readonly class="vs-shortcode-example" value='[netflix-category cat="211" count="6"]'/>
                    <p>On the right side of each genre, there is a <strong>Shortcode</strong> column. <strong>Copy and Paste</strong> the code into any <strong>Page</strong>, <strong>Post</strong> or content area of your website.</p>
                    <ul>
                        <li>Each category has its own shortcode with a unique <span class="vs-not-editable">cat</span> for displaying a horizontal slider of videos</li>
                        <li>These shortcodes can be found on the right side of each video category under the <em>Shortcode</em> column within your WordPress Dashboard.</li>
                        <li>The <span class="vs-not-editable">cat</span> parameter indicates the unique video category id - <strong>(do not change this parameter)</strong>.</li>
                        <li>The <span class="vs-editable">count</span> parameter allows you to set how many video slides you would like to show within the category slider.</li>
                        <li>Set the <span class="vs-editable">count</span> parameter to <strong>all</strong> or <strong>-1</strong> to display all videos in each category</li>
                    </ul>
                    <input type="text" readonly class="vs-shortcode-example" value='[netflix-category cat="211" count="6" style="clean"]'/>
                    <ul>
                        <li>The optional <span class="vs-editable">style="clean"</span> parameter formats the slider for clean display on smaller page layouts.</li>
                    </ul>

                    <p><a href="<?php echo admin_url('edit-tags.php?taxonomy=rvs_video_category&post_type=rvs_video'); ?>"><?php _e('My Genres Shortcodes', 'wpvs-theme'); ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
