<?php


add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);
function add_defer_attribute($tag, $handle) {
	// add script handles to the array below
	$scripts_to_defer = array('main-scripts-js', '');
	
	foreach($scripts_to_defer as $defer_script) {
	   if ($defer_script === $handle) {
		  return str_replace(' src', ' defer src', $tag);
	   }
	}
	return $tag;
}

add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
function add_async_attribute($tag, $handle) {
	// add script handles to the array below
	$scripts_to_async = array('formidable-js', '');
	
	foreach($scripts_to_async as $async_script) {
	   if ($async_script === $handle) {
		  return str_replace(' src', ' async src', $tag);
	   }
	}
	return $tag;
}

/**
 * Stop WordPress loading jQuery-migrate
 */
add_action( 'wp_default_scripts', 'dequeue_jquery_migrate' );
function dequeue_jquery_migrate($scripts){
    if(!is_admin() && !empty($scripts->registered['jquery'])){
        $jquery_dependencies = $scripts->registered['jquery']->deps;
        $scripts->registered['jquery']->deps=array_diff($jquery_dependencies,array('jquery-migrate'));
    }
}