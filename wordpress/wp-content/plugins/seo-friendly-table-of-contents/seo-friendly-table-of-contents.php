<?php
/*
 Plugin Name: Seo Friendly Table of Contents
 Plugin URI: http://www.webfish.se/wp/plugins/seo-friendly-table-of-contents
 Description: Adds a seo firendly table of contents anywhere you write [toc levels=2 title="Table of contents"].
 Version: 2.0.1
 Author: Tobias Nyholm
 Author URI: http://www.tnyholm.se
 Copyright: Tobias Nyholm 2010
/*
    This file is part of Seo Friendly Table of Contents.

    Seo Friendly Table of Contents is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Seo Friendly Table of Contents is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Seo Friendly Table of Contents.  If not, see <http://www.gnu.org/licenses/>.

 */


add_filter('the_content', 'seotoc_contentFilter');

//add css
add_action('wp_enqueue_scripts','seotoc_addStyle');
function seotoc_addStyle(){
	wp_enqueue_style('toc_css',WP_PLUGIN_URL.'/seo-friendly-table-of-contents/style.css');
}

function seotoc_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'levels' => '2',
			'title'=> false,
	), $atts ) );
		
	$tags=array_slice(array(2,3,4,5,6,7),0,$levels);
	$toc=getSeo_toc($tags,$title);

	return $toc;
}
add_shortcode('toc','seotoc_shortcode');


/**
 * Writes an id tag to every heading
 * @param String $content
 */
function seotoc_contentFilter($content){
	$tags="234567";
	
	//some regex to recognize the h#-tags
	$tag_regex = '/<h(['.$tags.'])(.*?)>(.*?)(<\/h['.$tags.']>)/';
	
	$tag_match = preg_match_all($tag_regex, $content, $tag_matches);
	//die ("<pre>".print_r($tag_matches,true));
	
	$lastLevel=-1;//init leven
	
	//if a h#-tag found.
	if ($tag_match){
		foreach ($tag_matches[3] as $key => $title){
			//original string
			$orgStr=$tag_matches[0][$key];
	
			//strip any unwanted html
			$titleNoTags=strip_tags($title);	
			$titleSlug=seotoc_slugify($titleNoTags);
			
				
			//this is the h#-tag
			$tag="h".$tag_matches[1][$key];
				
			//save any attributes that the h#-tag allredy has. and then add the id.
			$attributes=$tag_matches[2][$key]." id='$titleSlug'";				
	

			//replace the original heading with the one with an ID
			$content = str_replace($orgStr, "<$tag$attributes>$title</$tag>", $content);
		}
	}

	return $content;
}

/**
 * kind of ugly slugify. But it works well with special chars
 */
function seotoc_slugify($str){
	$replace=array("/\&#[0-9]*?;/"=>"","/[^a-z A-Z0-9]/"=>"","/ /"=>"-");
	$str=preg_replace(array_keys($replace),array_values($replace), $str);
	return $str;
}

/**
 * This will return a table of contents. 
 * 
 * @param array $tags like array(2,3,4)
 * @param String $title
 */
function getSeo_toc(array $tagsArray,$toc_title=null){
	global $post;
	$content=$post->post_content;
	
	$tags="";
	//make a string form the array
	foreach($tagsArray as $tag)
		if($tag<8)
		$tags.="$tag";
	
	if(!$toc_title)
		$toc_title="";
	else
		$toc_title="<div id='toc_title' class='post-".$post->ID."'>$toc_title</div>";
	
	
	//some regex to recognize the h#-tags
	$tag_regex = '/<h(['.$tags.'])(.*?)>(.*?)(<\/h['.$tags.']>)/';
	
	$tag_match = preg_match_all($tag_regex, $content, $tag_matches);
	//die ("<pre>".print_r($tag_matches,true));
	
	$lastLevel=-1;//init leven
	$list="";//create $list
	
	//if a h#-tag found.
	if ($tag_match){
		foreach ($tag_matches[3] as $key => $title){
			//strip any unwanted html
			$titleNoTags=strip_tags($title);	
			$titleSlug=seotoc_slugify($titleNoTags);
			
			//Set a level.
			$thisLevel=$tag_matches[1][$key];
			
			/*
			 * prepare list
			*/
			if($thisLevel>$lastLevel){//start a sub list
				$list.="\n<ul>";
				$lastLevel=$thisLevel;
			}
			elseif($thisLevel<$lastLevel){//end a sublist
				$list.="</li>";//end the last li on prev listlevel.
				for($i=$lastLevel;$i>$thisLevel;$i--)
					$list.="</ul></li>"."\n";
					$lastLevel=$thisLevel;
			}
			else{//end a list item
				$list.='</li>'."\n";
			}
				
			//add a list item
			$list.='<li><a href="#'.$titleSlug.'">'.$titleNoTags.'</a>';//no closing li
				
		}//foreach
		
		$list.='</li>'."\n";//close the last opened li
		for($i=$lastLevel;$i>$tagsArray[0];$i--)//close all open tags
			$list.="</ul></li>";
		$list.= "</ul>\n";//close the last ul
		
		$list="<div id='toc'>$toc_title$list</div>";
		
	}//if ($tag_match)
	
	
	
	return $list;
}




//------------------------------------------------//
// Admin stuff

/**
 * add admin menus
 */
function seotoc_adminMenu() {
	$page=array();

	//Add some submenus
	//parent, title, link, rights, url, function
	$page[]=add_submenu_page('options-general.php', 'Table of contents', 'Table of contents','manage_options','table-of-contents', 'seotoc_adminOptions');

}
add_action('admin_menu', 'seotoc_adminMenu');


/**
 * the admin page
 */
function seotoc_adminOptions(){
	?><div id='seotoc_admin'><h1>Seo Friendly Table of Contents</h1>
	<p>If you updated from version 1 you may want to rewrite the shortcode in you existing posts. Press the button below if you want us to rewrite
	automatically. It is recommended that you back up your database before pressing the button.</p>
	<?php 
	/*
	 * handle post
	 */
	if(isset($_POST["do"]) && $_POST["do"]=="update"){
		seotoc_updateToVersion2();
		echo "<div id='message' class='updated'><p><strong>Your existings posts are updated!</strong></p></div>";
	}

	/*
	 * Print html
	 */
	?>
	<form action="" method="POST">
	<input type="hidden" name="do" value="update" />

	<input type="submit" value="Update existing posts!" onclick="return confirm('Have you made a backup of your database? Do you wish to proceed?')" />
	
	</form>
	</div><!-- end wpp_admin -->
	<?php 

}


/*********************************************'
 * Update to version 2
 */


/**
 * This function updates all your posts
 * Warning. Backup your DB first
 */
function seotoc_updateToVersion2(){
	global $wpdb;
	$query = "SELECT * FROM $wpdb->posts
	WHERE $wpdb->posts.post_status = 'publish'
	ORDER BY post_date DESC
	";
	
	$results = $wpdb->get_results($query);
	
	foreach ( $results as $post ){
		$newContent=$post->post_content;
		seotoc_rewriteContentToVersion2($newContent);
		
		//save
		$wpdb->update(
				$wpdb->posts,
				array('post_content' => $newContent),
				array('ID' => $post->ID),
				array('%s'),
				array('%d')
		);
	}
}

function seotoc_rewriteContentToVersion2(&$content){
	$tolc_regex = '|(?:<p>)?\[toc=(?:["'."'".'])?([1-7,]+)(?:["'."'".'])?(?: title=(?:["'."'".'])?(.*?)(?:["'."'".'])?)? ?\](?:<br \/>)?(?:<\/p>)?|s';
	$tag_match = preg_match_all($tolc_regex, $content, $tag_matches);
	//die ("<pre>".print_r($tag_matches,true));
	
	if ($tag_match){
		foreach ($tag_matches[2] as $key => $title){
			//original string
			$orgStr=$tag_matches[0][$key];

			$levels=substr($tag_matches[1][$key],-1)-1;
			
			$newString='[toc levels='.$levels.' title="'.$title.'"]';
	
			//replace the original heading with the one with an ID
			$content = str_replace($orgStr, $newString, $content);
		
		}
	}
	
}
