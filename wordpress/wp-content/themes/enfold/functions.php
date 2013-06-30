<?php

global $avia_config;

/*
 * if you run a child theme and dont want to load the default functions.php file
 * set the global var bellow in you childthemes function.php to true:
 *
 * example: global $avia_config; $avia_config['use_child_theme_functions_only'] = true;
 * The default functions.php file will then no longer be loaded. You need to make sure than
 * of course to include framework and functions that you want to use by yourself.
 *
 * This is only recommended for advanced users
 */

 if(isset($avia_config['use_child_theme_functions_only'])) return;



/*
 * wpml multi site config file
 * needs to be loaded before the framework
 */

require_once( 'config-wpml/config.php' );


/*
 * These are the available color sets in your backend.
 * If more sets are added users will be able to create additional color schemes for certain areas
 *
 * The array key has to be the class name, the value is only used as tab heading on the styling page
 */



 $avia_config['color_sets'] = array(
                            'header_color'      => 'Header',
                            'main_color'        => 'Main Content',
                            'alternate_color'   => 'Alternate Content',
                            'footer_color'      => 'Footer',
                            'socket_color'      => 'Socket'
                            );

/*add support for responsive mega menus*/
add_theme_support('avia_mega_menu');
add_filter('avia_mega_menu_walker', 'disable_default_mega_menu');
function disable_default_mega_menu(){ return false; } // deactivates the default mega menu and allows us to pass individual menu walkers when calling a menu

/*adds support for the new avia sidebar manager*/
add_theme_support('avia_sidebar_manager');


##################################################################
# AVIA FRAMEWORK by Kriesi

# this include calls a file that automatically includes all
# the files within the folder framework and therefore makes
# all functions and classes available for later use

require_once( 'framework/avia_framework.php' );

##################################################################


/*
 * Register additional image thumbnail sizes
 * Those thumbnails are generated on image upload!
 *
 * If the size of an array was changed after an image was uploaded you either need to re-upload the image
 * or use the thumbnail regeneration plugin: http://wordpress.org/extend/plugins/regenerate-thumbnails/
 */

$avia_config['imgSize']['widget'] 			 	= array('width'=>36,  'height'=>36);						// small preview pics eg sidebar news
$avia_config['imgSize']['entry_with_sidebar'] 	= array('width'=>710, 'height'=>270);		                 // big images for blog and page entries
$avia_config['imgSize']['entry_without_sidebar']= array('width'=>1030, 'height'=>360 );						// images for fullsize pages and fullsize slider
$avia_config['imgSize']['square'] 		 	    = array('width'=>180, 'height'=>180);		                 // small image for blogs
$avia_config['imgSize']['featured'] 		 	= array('width'=>1500, 'height'=>430 );						// images for fullsize pages and fullsize slider
$avia_config['imgSize']['portfolio'] 		 	= array('width'=>495, 'height'=>400 );						// images for portfolio entries (2,3 column)
$avia_config['imgSize']['portfolio_small'] 		= array('width'=>260, 'height'=>185 );						// images for portfolio 4 columns
$avia_config['imgSize']['gallery'] 		 		= array('width'=>710, 'height'=>575 );						// images for portfolio entries (2,3 column)


$avia_config['slectableImgSize'] = array(
	'square' 	=> __('Square','avia_framework'),
	'featured'  => __('Featured','avia_framework'),
	'portfolio' => __('Portfolio','avia_framework'),
	'gallery' 	=> __('Gallery','avia_framework'),
	'entry_with_sidebar' 	=> __('Entry with Sidebar','avia_framework'),
	'entry_without_sidebar' 	=> __('Entry without Sidebar','avia_framework'),
);

avia_backend_add_thumbnail_size($avia_config);

if ( ! isset( $content_width ) ) $content_width = $avia_config['imgSize']['featured']['width'];




/*
 * register the layout sizes: the written number represents the grid size, if the elemnt should not have a left margin add "alpha"
 *
 * Calculation of the with: the layout is based on a twelve column grid system, so content + sidebar must equal twelve.
 * example:  'content' => 'nine alpha',  'sidebar' => 'three'
 *
 * if the theme uses fancy blog layouts ( meta data beside the content for example) use the meta and entry values.
 * calculation of those: meta + entry = content
 *
 */

$avia_config['layout']['fullsize'] 		= array('content' => 'twelve alpha', 'sidebar' => 'hidden', 	 'meta' => 'two alpha', 'entry' => 'eleven');
$avia_config['layout']['sidebar_left'] 	= array('content' => 'nine', 		 'sidebar' => 'three alpha' ,'meta' => 'two alpha', 'entry' => 'nine');
$avia_config['layout']['sidebar_right'] = array('content' => 'nine alpha',   'sidebar' => 'three alpha', 'meta' => 'two alpha', 'entry' => 'nine alpha');



/*
 * These are some of the font icons used in the theme, defined by the entypo icon font. the font files are included by the new aviaBuilder
 * common icons are stored here for easy retrieval
 */
 $avia_config['font_icons'] = array(
                            'search'  	=> '&#128269;',       	//36
                            'standard' 	=> '&#9998;',        	//6
                            'link'    	=> '&#128279;',       	//40
                            'image'    	=> '&#128247;',      	//46
                            'audio'    	=> '&#9834;',        	//51
                            'quote'   	=> '&#10078;',        	//33
                            'gallery'   => '&#127748;',     	//145
                            'video'   	=> '&#127916;',       	//146
                            'info'    	=> '&#8505;',         	//120
                            'next'    	=> '&#59230;',        	//190
                            'prev'    	=> '&#59229;',        	//187
              				'behance' 	=> '&#62286;',			//246
							'dribbble' 	=> '&#62235;',			//223
							'facebook' 	=> '&#62220;',			//212
							'flickr' 	=> '&#62211;',			//206
							'gplus' 	=> '&#62223;',			//215
							'linkedin' 	=> '&#62232;',			//221
							'pinterest' => '&#62226;',			//217
							'skype' 	=> '&#62265;',			//238
							'tumblr' 	=> '&#62229;',			//219
							'twitter' 	=> '&#62217;',			//210
							'vimeo' 	=> '&#62214;',			//208
							'rss' 		=> '&#59194;',			//98
							'mail' 		=> '&#9993;',			//5
							'cart' 		=> '&#59197;',
							'reload'	=> '&#128260;',
							'details'	=> '&#128196;',
							'close'		=> '&#10006;',			//115
							'clipboard' => '&#128203;'
                            );







if ( ! isset( $content_width ) ) $content_width = 850;
add_theme_support( 'automatic-feed-links' );

##################################################################
# Frontend Stuff necessary for the theme:
##################################################################
/*
 * Register theme text domain
 */
if(!function_exists('avia_lang_setup'))
{
	add_action('after_setup_theme', 'avia_lang_setup');
	function avia_lang_setup()
	{
		$lang = get_template_directory()  . '/lang';
		load_theme_textdomain('avia_framework', $lang);
	}
}


/*
 * Register frontend javascripts:
 */
if(!function_exists('avia_register_frontend_scripts'))
{
	if(!is_admin()){
		add_action('wp_enqueue_scripts', 'avia_register_frontend_scripts');
	}

	function avia_register_frontend_scripts()
	{
		$template_url = get_template_directory_uri();
		$child_theme_url = get_stylesheet_directory_uri();

		//register js
		wp_register_script( 'avia-compat', $template_url.'/js/avia-compat.js', array('jquery'), 1, false ); //needs to be loaded at the top to prevent bugs
		wp_register_script( 'avia-default', $template_url.'/js/avia.js', array('jquery'), 1, true );
		wp_register_script( 'avia-shortcodes', $template_url.'/js/shortcodes.js', array('jquery'), 1, true );
		wp_register_script( 'avia-prettyPhoto',  $template_url.'/js/prettyPhoto/js/jquery.prettyPhoto.js', 'jquery', "3.1.5", true);
		wp_register_script( 'avia-html5-video',  $template_url.'/js/mediaelement/mediaelement-and-player.min.js', 'jquery', "1", true);


		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'avia-compat' );
		wp_enqueue_script( 'avia-default' );
		wp_enqueue_script( 'avia-shortcodes' );
		wp_enqueue_script( 'avia-prettyPhoto' );
		wp_enqueue_script( 'avia-html5-video' );

		if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }


		//register styles
		wp_register_style( 'avia-style' ,  $child_theme_url."/style.css", array(), '1', 'screen' ); //register default style.css file. only include in childthemes. has no purpose in main theme
		wp_register_style( 'avia-grid' ,   $template_url."/css/grid.css", array(), '1', 'screen' );
		wp_register_style( 'avia-base' ,   $template_url."/css/base.css", array(), '1', 'screen' );
		wp_register_style( 'avia-layout',  $template_url."/css/layout.css", array(), '1', 'screen' );
		wp_register_style( 'avia-scs',     $template_url."/css/shortcodes.css", array(), '1', 'screen' );
		wp_register_style( 'avia-custom',  $template_url."/css/custom.css", array(), '1', 'screen' );
		wp_register_style( 'avia-prettyP', $template_url."/js/prettyPhoto/css/prettyPhoto.css", array(), '1', 'screen' );
		wp_register_style( 'avia-media'  , $template_url."/js/mediaelement/skin-1/mediaelementplayer.css", array(), '1', 'screen' );


		//register styles

		wp_enqueue_style( 'avia-grid');
		wp_enqueue_style( 'avia-base');
		wp_enqueue_style( 'avia-layout');
		wp_enqueue_style( 'avia-scs');
		wp_enqueue_style( 'avia-prettyP');
		wp_enqueue_style( 'avia-media');
		if($child_theme_url !=  $template_url)
		{
			wp_enqueue_style( 'avia-style');
		}


        global $avia;
		$safe_name = avia_backend_safe_string($avia->base_data['prefix']);

        if( get_option('avia_stylesheet_exists'.$safe_name) == 'true' )
        {
            $avia_upload_dir = wp_upload_dir();

            $avia_dyn_stylesheet_url = $avia_upload_dir['baseurl'] . '/dynamic_avia/'.$safe_name.'.css';
            wp_register_style( 'avia-dynamic', $avia_dyn_stylesheet_url, array(), '1', 'screen' );
            wp_enqueue_style( 'avia-dynamic');
        }

		wp_enqueue_style( 'avia-custom');

	}
}




/*
 * Activate native wordpress navigation menu and register a menu location
 */
if(!function_exists('avia_nav_menus'))
{
	function avia_nav_menus()
	{
		global $avia_config;

		add_theme_support('nav_menus');
		foreach($avia_config['nav_menus'] as $key => $value){ register_nav_menu($key, THEMENAME.' '.$value); }
	}

	$avia_config['nav_menus'] = array(	'avia' => 'Main Menu' ,
										'avia2' => 'Secondary Menu <br/><small>(Will be displayed if you selected a header layout that supports a submenu <a target="_blank" href="'.admin_url('?page=avia#goto_header').'">here</a>)</small>',
										'avia3' => 'Footer Menu <br/><small>(no dropdowns)</small>'
									);
	avia_nav_menus(); //call the function immediatly to activate
}









/*
 *  load some frontend functions in folder include:
 */

require_once( 'includes/admin/register-portfolio.php' );		// register custom post types for portfolio entries
require_once( 'includes/admin/register-widget-area.php' );		// register sidebar widgets for the sidebar and footer
require_once( 'includes/loop-comments.php' );					// necessary to display the comments properly
require_once( 'includes/helper-template-logic.php' ); 			// holds the template logic so the theme knows which tempaltes to use
require_once( 'includes/helper-social-media.php' ); 			// holds some helper functions necessary for twitter and facebook buttons
require_once( 'includes/helper-post-format.php' ); 				// holds actions and filter necessary for post formats
require_once( 'includes/admin/register-plugins.php');			// register the plugins we need
require_once( 'includes/helper-responsive-megamenu.php' ); 		// holds the walker for the responsive mega menu

//adds the plugin initalization scripts that add styles and functions
require_once( 'config-bbpress/config.php' );					//compatibility with  bbpress forum plugin
require_once( 'config-layerslider/config.php' );				//layerslider plugin
require_once( 'config-templatebuilder/config.php' );			//templatebuilder plugin
require_once( 'config-gravityforms/config.php' );				//compatibility with gravityforms plugin 
require_once( 'config-woocommerce/config.php' );				//compatibility with woocommerce plugin



/*
 *  dynamic styles for front and backend
 */
if(!function_exists('avia_custom_styles'))
{
	function avia_custom_styles()
	{
		require_once( 'includes/admin/register-dynamic-styles.php' );	// register the styles for dynamic frontend styling
		avia_prepare_dynamic_styles();
	}

	add_action('init', 'avia_custom_styles', 20);
	add_action('admin_init', 'avia_custom_styles', 20);
}




/*
 *  activate framework widgets
 */
if(!function_exists('avia_register_avia_widgets'))
{
	function avia_register_avia_widgets()
	{
		// register_widget( 'avia_tweetbox'); //<-- removed since the twitter api is shutting down.
		register_widget( 'avia_newsbox' );
		register_widget( 'avia_portfoliobox' );
		register_widget( 'avia_socialcount' );
		register_widget( 'avia_combo_widget' );
		register_widget( 'avia_partner_widget' );
		register_widget( 'avia_google_maps' );
	}

	avia_register_avia_widgets(); //call the function immediatly to activate
}





/*
 *  add post format options
 */
add_theme_support( 'post-formats', array('link', 'quote', 'gallery','video','image' ) );



/*
 *  Remove the default shortcode function, we got new ones that are better ;)
 */
add_theme_support( 'avia-disable-default-shortcodes', true);


/*
 * compat mode for easier theme switching from one avia framework theme to another
 */
add_theme_support( 'avia_post_meta_compat');




/*
 *  register custom functions that are not related to the framework but necessary for the theme to run
 */

require_once( 'functions-enfold.php');
