<?php
if (!function_exists('remove_span')) {
    function remove_span($str){
        return preg_replace('/<span[^>]+\>/i', '', $str);
    }
}

if (!function_exists('remove_no_text')) {
    function remove_no_text($str){
        return str_ireplace('No text', '', $str);
    }
}

if (!function_exists('clean_text')) {
    function clean_text($str){
        $pattern = '/\s*/m';
        $replace = '';
        $str = strip_tags($str);
        return preg_replace( $pattern, $replace,$str);
    }
}

if (!function_exists('remove_icon_text')) {
    function remove_icon_text($str){
        return str_ireplace('Diseases of the', '', $str);
    }
}

?>