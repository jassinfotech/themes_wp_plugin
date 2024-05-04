<?php
require_once('video-type.php');
//require_once('episode-type.php');
require_once('shared-terms.php');
require_once('filters.php');
require_once('meta-boxes.php');
if( is_admin() ) {
    require_once('bulk-edit.php');
}
