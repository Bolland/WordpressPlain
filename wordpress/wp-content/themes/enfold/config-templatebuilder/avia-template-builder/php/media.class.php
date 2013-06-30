<?php

class AviaMedia{

	var $config;

	function __construct()
	{
		$this->hook_in();
		$this->add_assets();
	}
	
	function hook_in()
	{
		add_filter( 'image_size_names_choose', array($this, 'avia_media_choose_image_size' ));
		//add_filter( 'media_view_strings', array($this, 'avia_media_menu_filter' ));image_size_names_choose
		//add_action( 'print_media_templates', array($this, 'add_media_views' ));
	}
	
	function add_assets()
	{
		$ver = AviaBuilder::VERSION;
	
		wp_enqueue_script('avia_media_js' , AviaBuilder::$path['assetsURL'].'js/avia-media.js' , array('avia_element_js'), $ver, TRUE );
		wp_enqueue_style( 'avia-media-style' , AviaBuilder::$path['assetsURL'].'css/avia-media.css');
	}
	
	
	function avia_media_choose_image_size($sizes)
	{
		global $avia_config;

		if(isset($avia_config['slectableImgSize']))
		{
			$sizes = array_merge($sizes, $avia_config['slectableImgSize']);
		}
		
		return $sizes;
	}
	
	function avia_media_menu_filter( $strings ) 
	{
		$image_only = 1;
		$gallery_only = 0;
		
		if($image_only)
		{
			unset( $strings['setFeaturedImageTitle'], $strings['createGalleryTitle']);
			$strings['insertIntoPost'] = $strings['insertMediaTitle'] = __('Insert Image','avia_framework' );
		}
		
		if($gallery_only)
		{
			unset( $strings['setFeaturedImageTitle'], $strings['createGalleryTitle'] );
		}
		
	
	    //unset( $strings['insertFromUrlTitle'] );
	    return $strings;
	}
		
	function add_media_views()
	{
	
	}
}