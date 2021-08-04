<?php

//defer scripts

function defer_parsing_of_js($url)
{
    if(is_admin()) return $url;
    if(false === strpos($url, .'.js')) return $url;
    if( strpos($url, 'jquery.js') ) return $url;
    return str_replace('src', 'defer src', $url);
}

add_filter('script_loader_tag', 'defer_parsing_of_js', 10)