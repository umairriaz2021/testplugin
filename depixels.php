<?php
/*
Plugin Name: Custom Test Work
Plugin URI: https://www.abc.com
Description: This plugin is for test purpose
Author Name: Umair Riaz
Author URI: https://www.facebook.com/umair-riaz
Version: 1.0.0
text-domain: abc

*/

if(!defined('PLUGIN_DIR_PATH')){
    define('PLUGIN_DIR_PATH',plugin_dir_path(__FILE__));
}


if(!defined('PLUGIN_URL')){
    define('PLUGIN_URL',plugin_dir_url(__FILE__,'/dipexels'));
}





add_filter('rewrite_rules_array', function ($rules) {
    $newRules = [
        'shows/([^/]+)/?$' => 'index.php?pagename=shows&show_name=$matches[1]',
        'hosts/([^/]+)/?$' => 'index.php?pagename=hosts&host_id=$matches[1]',
        'broadcasts/([^/]+)/?$' => 'index.php?pagename=broadcasts&broadcast_id=$matches[1]'
    ];

    // Merge your custom rules with the existing rules
    $rules = $newRules + $rules;

    return $rules;
});

add_filter('query_vars', function ($query_vars) {
  $query_vars[] = 'pagename';
  $query_vars[] = 'show_name'; // Add show_name and host_id to query_vars
  $query_vars[] = 'host_id';
  $query_vars[] = 'broadcast_id';
  return $query_vars;
});

add_action('template_include', function ($template) {
    if (get_query_var('pagename') === 'shows') {
         $name = get_query_var('show_name') ?: " Page"; 
        echo "<h3>Shows {$name}</h3>";
    } elseif (get_query_var('pagename') === 'hosts') {
        $host_id = get_query_var('host_id') ?: " Page"; 
        echo "<h3>Hosts {$host_id}</h3>";
    } elseif (get_query_var('pagename') === 'broadcasts') {
        $broadcast_id = get_query_var('broadcast_id') ?: " Page"; 
        echo "<h3>Broadcast {$broadcast_id}</h3>";
    } else {
        echo "<h3>404 page without queryParams</h3>";
    }
    return $template;
});
