<?php
/**
 * Template Loader
 *
 * Conditionally Loads Portfolio template files from child theme or plugin
 *
 * @package Genesis Portfolio Pro
 * @author  StudioPress
 * @license GPL-2.0+
 */
 

 
define( 'GENESIS_PORTFOLIO_TEMPLATE_DIR', GENESIS_PORTFOLIO_LIB . 'templates/' );

/**
 * Load custom template from child theme if available otherwise load plugin template
 *
 * @since 0.1.0
 *
 * @uses GENESIS_PORTFOLIO_TEMPLATE_DIR
 *
 */
function genesis_portfolio_get_template_hierarchy( $template ) {
 
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
 
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( 'plugin_template/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = GENESIS_PORTFOLIO_TEMPLATE_DIR . $template;
    }
 
    return apply_filters( 'genesis_portfolio_repl_template_' . $template, $file );
}
 

 
add_filter( 'template_include', 'genesis_portfolio_template_chooser' );
/**
 * Returns template file
 *
 * @since 0.1.0
 * 
 */
function genesis_portfolio_template_chooser( $template ) {

	if( is_front_page() )
		return $template;
 
    // Post ID
    $post_id = get_the_ID();
 
    // Else use custom template
    if ( is_single() && get_post_type( $post_id ) == 'portfolio' ) {
        return genesis_portfolio_get_template_hierarchy( 'single-portfolio' );
    }
    elseif( is_post_type_archive( 'portfolio' ) ){
	    return genesis_portfolio_get_template_hierarchy( 'archive-portfolio' );
    }
    elseif( is_tax( 'portfolio-type' ) ) {
	    return genesis_portfolio_get_template_hierarchy( 'taxonomy-portfolio-type' );
    }
 
	return $template;
	
}