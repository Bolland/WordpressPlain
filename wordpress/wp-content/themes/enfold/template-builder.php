<?php 
global $avia_config, $post;
	
	if ( post_password_required() )
    {
		get_template_part( 'page' ); exit();
    }
	
	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */	
	 get_header();
 	 
 	
 	 // set up post data
	 setup_postdata( $post );
	 
	 //check if we want to display breadcumb and title
	 if( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title();
	
	 //filter the content for content builder elements
	 $content = apply_filters('avia_builder_precompile', get_post_meta(get_the_ID(), '_aviaLayoutBuilderCleanData', true));
	 $content = apply_filters('the_content', $content);
	 
	 //check first builder element. if its a section or a fullwidth slider we dont need to create the default openeing divs here
	 
	 $first_el = isset(ShortcodeHelper::$tree[0]) ? ShortcodeHelper::$tree[0] : false;
	 $last_el  = !empty(ShortcodeHelper::$tree)   ? end(ShortcodeHelper::$tree) : false;
	 if(!$first_el || !in_array($first_el['tag'], array('av_section','av_layerslider','av_slideshow_full') ) )
	 {
        echo avia_new_section(array('close'=>false));
	 }

	echo $content;

	
	//only close divs if the user didnt add fullwidth slider elements at the end. also skip sidebar if the last element is a slider
	if(!$last_el || !in_array($last_el['tag'], array('av_layerslider','av_slideshow_full') ) )
	{	
		echo "			</div>";
		echo "		</div>";
		echo "	</div>";
		
		//get the sidebar
		$avia_config['currently_viewing'] = 'page';
		get_sidebar();
		
	}
	else
	{
		echo "<div><div>";
	}
			
		
		   
echo "	</div><!--end builder template-->";   
	


get_footer();