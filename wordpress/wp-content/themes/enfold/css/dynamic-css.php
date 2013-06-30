<?php
/*
ATTENTION: Changes to this file will only be visible in your frontend after you have re-saved your Themes Styling Page
*/



/*
This file holds ALL color information of the theme that is applied with the styling backend admin panel.
It is recommended to not edit this file, instead create new styles in custom.css and overwrite the styles within this file

Example of available values
$bg 				=> #222222
$bg2 				=> #f8f8f8
$primary 			=> #c8ccc2
$secondary			=> #182402
$color	 			=> #ffffff
$border 			=> #e1e1e1
$img 				=> /wp-content/themes/skylink/images/background-images/dashed-cross-dark.png
$pos 				=> top left
$repeat 			=> no-repeat
$attach 			=> scroll
$heading 			=> #eeeeee
$meta 				=> #888888
$background_image	=> #222222 url(/wp-content/themes/skylink/images/background-images/dashed-cross-dark.png) top left no-repeat scroll
*/



global 	$avia_config;
$output = "";
$body_color = "";

extract($color_set);
extract($main_color);
extract($styles);

unset($background_image);
######################################################################
# CREATE THE CSS DYNAMIC CSS RULES
######################################################################
/*default*/


$output .= "

::-moz-selection{
background-color: $primary;
color: $bg;
}

::-webkit-selection{
background-color: $primary;
color: $bg;
}

::selection{
background-color: $primary;
color: $bg;
}

";


/* not needed since we got no "boxed" option*/
$output .= "

html.html_boxed {background: $body_background;}

";




/*color sets*/
foreach ($color_set as $key => $colors) // iterates over the color sets: usually $key is either: header_color, main_color, footer_color, socket_color
{
	$key = ".".$key;
	extract($colors);
	$constant_font 	= avia_backend_calc_preceived_brightness($primary, 230) ?  '#ffffff' : $bg;

	/*general styles*/
	$output.= "
$key, $key div, $key  span, $key  applet, $key object, $key iframe, $key h1, $key h2, $key h3, $key h4, $key h5, $key h6, $key p, $key blockquote, $key pre, $key a, $key abbr, $key acronym, $key address, $key big, $key cite, $key code, $key del, $key dfn, $key em, $key img, $key ins, $key kbd, $key q, $key s, $key samp, $key small, $key strike, $key strong, $key sub, $key sup, $key tt, $key var, $key b, $key u, $key i, $key center, $key dl, $key dt, $key dd, $key ol, $key ul, $key li, $key fieldset, $key form, $key label, $key legend, $key table, $key caption, $key tbody, $key tfoot, $key thead, $key tr, $key th, $key td, $key article, $key aside, $key canvas, $key details, $key embed, $key figure, $key fieldset, $key figcaption, $key footer, $key header, $key hgroup, $key menu, $key nav, $key output, $key ruby, $key section, $key summary, $key time, $key mark, $key audio, $key video, #top $key .pullquote_boxed, .responsive #top $key .avia-testimonial, .responsive #top.avia-blank #main $key.container_wrap:first-child, #top $key.fullsize .template-blog .post_delimiter{
border-color:$border;
}

$key .rounded-container, #top $key .pagination a:hover, $key .small-preview, $key .fallback-post-type-icon{
background:$meta;
color:$bg;
}



$key , $key .site-background, $key .first-quote,  $key .related_image_wrap, $key .gravatar img  $key .hr_content, $key .news-thumb, $key .post-format-icon, $key .ajax_controlls a, $key .tweet-text.avatar_no, $key .big-preview, $key .toggler, $key .toggler.activeTitle:hover, $key #js_sort_items, $key.inner-entry, $key .grid-entry-title, $key .related-format-icon,  .grid-entry $key .avia-arrow, $key .avia-gallery-big, $key .avia-gallery-big, $key .avia-gallery img, $key .grid-content{
background-color:$bg;
color: $color;
}

$key .heading-color, $key h1, $key h2, $key h3, $key h4, $key h5, $key h6, $key .sidebar .current_page_item>a, $key .sidebar .current-menu-item>a, $key .pagination .current, $key .pagination a:hover, $key strong.avia-testimonial-name, $key .heading, $key .toggle_content strong, $key .toggle_content strong a, $key .tab_content strong, $key .tab_content strong a , $key .asc_count, $key .avia-testimonial-content strong, $key div .news-headline{
    color:$heading;
}

$key .meta-color, $key .sidebar, $key .sidebar a, $key .minor-meta, $key .minor-meta a, $key .text-sep, $key blockquote, $key .post_nav a, $key .comment-text, $key .side-container-inner, $key .news-time, $key .pagination a, $key .pagination span,  $key .tweet-text.avatar_no .tweet-time, #top $key .extra-mini-title, $key .team-member-job-title, $key .team-social a, $key #js_sort_items a, .grid-entry-excerpt, $key .avia-testimonial-subtitle, $key .commentmetadata a,$key .social_bookmarks a, $key .meta-heading>*, $key .slide-meta, $key .slide-meta a, $key .taglist, $key .taglist a, $key .phone-info, $key .phone-info a{
color: $meta;
}

$key a, $key .widget_first, $key strong, $key b, $key b a, $key strong a, $key #js_sort_items a:hover, $key #js_sort_items a.active_sort, $key .special_amp, $key .taglist a.activeFilter{
color:$primary;
}

$key a:hover, $key h1 a:hover, $key h2 a:hover, $key h3 a:hover, $key h4 a:hover, $key h5 a:hover, $key h6 a:hover,  $key .template-search  a.news-content:hover{
color: $secondary;
}

$key .primary-background, $key .primary-background a, div $key .button, $key #submit, $key input[type='submit'], $key .small-preview:hover, $key .avia-menu-fx, $key .avia-menu-fx .avia-arrow, $key.iconbox_top .iconbox_icon, $key .avia-data-table th.avia-highlight-col, $key .avia-color-theme-color, $key .avia-color-theme-color:hover, $key .image-overlay .image-overlay-inside::before, $key .comment-count, $key .av_dropcap2{
background-color: $primary;
color:$constant_font;
border-color:$primary;
}


$key .button:hover, $key .ajax_controlls a:hover, $key #submit:hover, $key .big_button:hover, $key .contentSlideControlls a:hover, $key #submit:hover , $key input[type='submit']:hover{
background-color: $secondary;
color:$bg;
border-color:$secondary;
}

$key .timeline-bullet{
background-color:$border;
border-color: $bg;
}

$key table, $key .widget_nav_menu ul:first-child>.current-menu-item, $key .widget_nav_menu ul:first-child>.current_page_item, $key .widget_nav_menu ul:first-child>.current-menu-ancestor, $key .pagination .current, $key .pagination a, $key.iconbox_top .iconbox_content, $key .av_promobox, $key .toggle_content, $key .toggler:hover, $key .related_posts_default_image, $key .search-result-counter, $key .container_wrap_meta, $key .avia-content-slider .slide-image, $key .avia-slider-testimonials .avia-testimonial-content, $key .avia-testimonial-arrow-wrap .avia-arrow, $key .news-thumb, $key .portfolio-preview-content, $key .portfolio-preview-content .avia-arrow{
background: $bg2;
}


#top $key .post_timeline li:hover .timeline-bullet{
background-color:$secondary;
}

$key blockquote, $key .avia-bullet{
border-color:$primary;
}

$key .main_menu ul:first-child >li > ul, #top $key .avia_mega_div > .sub-menu{
border-top-color:$primary;
}

$key .breadcrumb, $key .breadcrumb a, #top $key.title_container .main-title, #top $key.title_container .main-title a{
color:$color;
}

";



// menu colors
$output.= "


$key .header_bg, $key .main_menu ul, $key .main_menu .menu ul li a, $key .pointer_arrow_wrap .pointer_arrow, $key .avia_mega_div{
background-color:$bg;
color: $meta;
}

$key .main_menu .menu ul li a:hover{
background-color:$bg2;
}

$key .sub_menu>ul>li>a, $key .sub_menu>div>ul>li>a, $key .main_menu ul:first-child > li > a, #top $key .main_menu .menu ul .current_page_item > a, #top $key .main_menu .menu ul .current-menu-item > a , #top $key .sub_menu li ul a{
color:$meta;
}

#top $key .main_menu .menu ul li>a:hover{
color:$color;
}

$key .main_menu ul:first-child > li a:hover,
$key .main_menu ul:first-child > li.current-menu-item > a,
$key .main_menu ul:first-child > li.current_page_item > a,
$key .main_menu ul:first-child > li.active-parent-item > a{
color:$color;
}

#top $key .main_menu .menu .avia_mega_div ul .current-menu-item > a{
color:$primary;
}

$key .sub_menu>ul>li>a:hover, $key .sub_menu>div>ul>li>a:hover{
color:$color;
}

#top $key .sub_menu ul li a:hover,
$key .sub_menu ul:first-child > li.current-menu-item > a,
$key .sub_menu ul:first-child > li.current_page_item > a,
$key .sub_menu ul:first-child > li.active-parent-item > a{
color:$color;
}

$key .sub_menu li ul a, $key #payment, $key .sub_menu ul li, $key .sub_menu ul, #top $key .sub_menu li li a:hover{
background-color: $bg;
}

$key#header .avia_mega_div > .sub-menu.avia_mega_hr{
border-color:$border;
}


";

//apply background image if available
if(isset($background_image))
{
	$output .= "$key .header_bg { background: $background_image; }
	";
}







//tooltips +  ajax search
$output.= "


$key .avia-tt, $key .avia-tt .avia-arrow, $key .avia-tt .avia-arrow{
background-color: $bg;
color: $meta;
}

$key .ajax_search_image{
background-color: $primary;
color:$bg;
}

$key .ajax_search_excerpt{
color: $meta;
}

#top $key .ajax_search_entry:hover{
background-color:$bg2;
}

$key .ajax_search_title{
color: $heading;
}

$key .ajax_load{
background-color:$primary;
}

";

//button
$button_font = avia_backend_calc_preceived_brightness($primary, 100) ?  'rgba(255, 255, 255, 0.9)' : 'rgba(0, 0, 0, 0.5)';


$output.= "
#top $key .avia-color-theme-color{
color: $button_font;
}

$key .avia-color-theme-color-subtle{
background-color:$bg2;
color: $color;
}

$key .avia-color-theme-color-subtle:hover{
background-color:$bg;
color: $heading;
}


";

//icon list

$iconlist = avia_backend_calculate_similar_color($border, 'darker', 1);
$output.= "
$key .avia-icon-list .iconlist_icon{
background-color:$iconlist;
}

$key .avia-icon-list .iconlist-timeline{
border-color:$border;
}

$key .iconlist_content{
color:$meta;
}

";




// form fields
$output.= "

#top $key .input-text, #top $key input[type='text'], #top $key input[type='input'], #top $key input[type='password'], #top $key input[type='email'], #top $key input[type='number'], #top $key input[type='url'], #top $key input[type='tel'], #top $key input[type='search'], #top $key textarea, #top $key select{
border-color:$border;
background-color: $bg2;
color:$meta;
}

#top $key .invers-color .input-text, #top $key .invers-color input[type='text'], #top $key .invers-color input[type='input'], #top $key .invers-color input[type='password'], #top $key .invers-color input[type='email'], #top $key .invers-color input[type='number'], #top $key .invers-color input[type='url'], #top $key .invers-color input[type='tel'], #top $key .invers-color input[type='search'], #top $key .invers-color textarea, #top $key .invers-color select{
background-color: $bg;
}

$key .required{
color:$primary;
}


";





// hr shortcode
$output.= "

 $key .hr-short .hr-inner-style,  $key .hr-short .hr-inner{

background-color: $bg;
}

";



//sidebar tab & Tabs shortcode
$output.= "
div  $key .tabcontainer .active_tab_content, div $key .tabcontainer  .active_tab{
background-color: $bg2;
color:$color;
}

$key .template-archives  .tabcontainer a, #top $key .tabcontainer .tab:hover{
color:$color;
}

 $key .template-archives .tabcontainer a:hover{
color:$secondary;
}


$key .sidebar_tab_icon {
background-color: $border;
}

#top $key .sidebar_active_tab .sidebar_tab_icon {
background-color: $primary;
}

$key .sidebar_tab:hover .sidebar_tab_icon {
background-color: $secondary;
}

$key .sidebar_tab, $key .tabcontainer .tab{
color: $meta;
}

$key div .sidebar_active_tab , div  $key .tabcontainer.noborder_tabs .active_tab_content, div $key .tabcontainer.noborder_tabs  .active_tab{
color: $color;
background-color: $bg;
}

@media only screen and (max-width: 767px) {
	.responsive #top $key .tabcontainer .active_tab{ background-color: $secondary; color:$constant_font; } /*hard coded white to match the icons beside which are also white*/
	.responsive #top $key .tabcontainer{border-color:$border;}
	.responsive #top $key .active_tab_content{background-color: $bg2;}
}

";


//pricing table
$stripe = avia_backend_calculate_similar_color($primary, 'lighter', 2);
$stripe2 = avia_backend_calculate_similar_color($primary, 'lighter', 1);

$output.= "
$key tr:nth-child(even), $key .avia-data-table .avia-heading-row .avia-desc-col, $key .avia-data-table .avia-highlight-col, $key .pricing-table>li:nth-child(even), body $key .pricing-table.avia-desc-col li{
background-color:$bg;
color: $color;
}

$key table caption, $key tr:nth-child(even), $key .pricing-table>li:nth-child(even){
color: $meta;
}

$key tr:nth-child(odd), $key .pricing-table>li:nth-child(odd), $key .pricing-extra{
background: $bg2;
}

$key .pricing-table li.avia-pricing-row, $key .pricing-table li.avia-heading-row, $key .pricing-table li.avia-pricing-row .pricing-extra{
background-color: $primary;
color:$constant_font;
border-color:$stripe;
}

$key .pricing-table li.avia-heading-row, $key .pricing-table li.avia-heading-row .pricing-extra{
background-color: $stripe2;
color:$constant_font;
border-color:$stripe;
}

$key  .pricing-table.avia-desc-col .avia-heading-row, $key  .pricing-table.avia-desc-col .avia-pricing-row{
border-color:$border;
}

";




//media player + progress bar shortcode

$stripe = avia_backend_calculate_similar_color($primary, 'lighter', 2);
$output.= "
$key .mejs-controls .mejs-time-rail .mejs-time-current, $key .mejs-controls .mejs-volume-button .mejs-volume-slider .mejs-volume-current, $key .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, $key .theme-color-bar .bar {

background: $primary;
background-image:	-webkit-linear-gradient(-45deg, $primary 25%, $stripe 25%, $stripe 50%, $primary 50%, $primary 75%, $stripe 75%, $stripe);
background-image:      -moz-linear-gradient(-45deg, $primary 25%, $stripe 25%, $stripe 50%, $primary 50%, $primary 75%, $stripe 75%, $stripe);
background-image:        -o-linear-gradient(-45deg, $primary 25%, $stripe 25%, $stripe 50%, $primary 50%, $primary 75%, $stripe 75%, $stripe);
background-image:       -ms-linear-gradient(-45deg, $primary 25%, $stripe 25%, $stripe 50%, $primary 50%, $primary 75%, $stripe 75%, $stripe);
background-image:           linear-gradient(-45deg, $primary 25%, $stripe 25%, $stripe 50%, $primary 50%, $primary 75%, $stripe 75%, $stripe);
-moz-background-size: 6px 6px;
background-size: 6px 6px;
-webkit-background-size: 6px 5px;
}

$key .mejs-controls .mejs-time-rail .mejs-time-float {
background: $primary;
background: -webkit-linear-gradient($stripe, $primary);
background:    -moz-linear-gradient($stripe, $primary);
background:      -o-linear-gradient($stripe, $primary);
background:     -ms-linear-gradient($stripe, $primary);
background:         linear-gradient($stripe, $primary);
color: #fff;
}

$key .mejs-controls .mejs-time-rail .mejs-time-float-corner {
border: solid 4px $primary;
border-color: $primary transparent transparent transparent;
}


$key .progress{
background-color:$bg2;
}

";



/*forum*/

$output.= "

$key .bbp-topics .bbp-header, $key .bbp-topics .bbp-header, $key .bbp-forums .bbp-header{
background-color:$bg2;
}

$key .bbp-meta, $key .bbp-author-role, $key .bbp-author-ip, $key .bbp-pagination-count{
color: $meta;
}

$key .bbp-admin-links{
color:$border;
}

.avia_transform $key .bbp-replies .bbp-reply-author::before{
background-color:$bg;
border-color:$border;
}

$key .bbp-author-name{
color:$heading;
}

";



	//apply background image if available
	if(isset($background_image))
	{
		$output .= "$key { background: $background_image; }
		";
	}

	//button and dropcap color white unless primary color is very very light
	if(avia_backend_calc_preceived_brightness($primary, 220))
	{
		$output .= "

		$key dropcap2, $key dropcap3, $key avia_button, $key avia_button:hover, $key .on-primary-color, $key .on-primary-color:hover{
		color: $constant_font;
		}

		";
	}



	//only for certain areas
	switch($key)
	{
		case '.header_color':
		
		$constant_font = avia_backend_calc_preceived_brightness($primary, 230) ?  '#ffffff' : $bg;
		$output .= "

			#main, .html_stretched #wrap_all{
			background-color:$bg;
			}
			
			#advanced_menu_toggle, #advanced_menu_hide{
			background-color:$bg;
			color: $color;
			border-color: $border;
			}
			
			.avia_desktop #advanced_menu_toggle:hover, .avia_desktop #advanced_menu_hide:hover{
			background-color: $primary; color: $constant_font; border-color:$primary; 
			}
			
			#mobile-advanced li > a:before {color:$primary;}
			#mobile-advanced li > a:hover:before {color:$constant_font;}

			";

		break;

		case '.main_color':
			
			$constant_font = avia_backend_calc_preceived_brightness($primary, 230) ?  '#ffffff' : $bg;
			$output .= "

			#scroll-top-link:hover{ background-color: $bg2; color: $primary; border:1px solid $border; }
			
			
			/*mobile menu*/
			#mobile-advanced  { background-color: $bg; color: $primary; }
			#mobile-advanced, #mobile-advanced li > a, #mobile-advanced .mega_menu_title{color: $color; border-color:$border; }
			#mobile-advanced li > a:hover{ background-color: $primary; color: $constant_font; }
			";

		break;



		case '.footer_color':

			$output .= "

			#footer  .widgettitle{ color: $meta;  }

			";

		break;


		case '.socket_color':

			$output .= "

			html, #scroll-top-link{ background-color: $bg; }
			#scroll-top-link{ color: $color; border:1px solid $border; }
			";


		break;
	}



	//unset all vars with the help of variable vars :)
	foreach($colors as $key=>$val){ unset($$key); }

}

//filter to plug in, in case a plugin/extension/config file wants to make use of it
$output = apply_filters('avia_dynamic_css_output', $output, $color_set);


######################################################################
# OUTPUT THE DYNAMIC CSS RULES
######################################################################

//compress output
$output = preg_replace('/\r|\n|\t/', '', $output);

//todo: if the style are generated for the wordpress header call the generating script, otherwise create a simple css file and link to that file

$avia_config['style'] = array(

		array(
		'key'	=>	'direct_input',
		'value'		=> $output
		),

		array(
		'key'	=>	'direct_input',
		'value'		=> avia_get_option('quick_css')
		),

		//google webfonts
		array(
		'elements'	=> 'h1, h2, h3, h4, h5, h6, tr.pricing-row td, #top .portfolio-title, .callout .content-area, .avia-big-box .avia-innerbox',
		'key'	=>	'google_webfont',
		'value'		=> avia_get_option('google_webfont')
		),

		//google webfonts
		array(
		'elements'	=> 'body',
		'key'	=>	'google_webfont',
		'value'		=> avia_get_option('default_font')
		)
);




