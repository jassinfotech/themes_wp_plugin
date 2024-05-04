<?php

if( ! function_exists('wpvs_generate_secure_random_bytes') ) {
function wpvs_generate_secure_random_bytes($length) {
    if( function_exists('random_bytes') ) {
        return bin2hex(random_bytes(intval($length)));
    } else {
        $cry_strong = true;
        $random_bytes = openssl_random_pseudo_bytes(intval($length), $cry_strong);
        return bin2hex($random_bytes);
    }
}
}
