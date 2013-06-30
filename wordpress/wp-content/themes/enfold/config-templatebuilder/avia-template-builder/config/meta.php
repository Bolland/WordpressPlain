<?php
global $builder;

$boxes = array(
	array( 'title' =>__('Avia Layout Builder','avia_framework' ), 'id'=>'avia_builder', 'page'=>array('portfolio','page'), 'context'=>'normal', 'priority'=>'high', 'expandable'=>true ),
	array( 'title' =>__('Layout','avia_framework' ), 'id'=>'layout', 'page'=>array('portfolio', 'page' , 'post'), 'context'=>'side', 'priority'=>'low'),
	array( 'title' =>__('Additional Portfolio Settings','avia_framework' ), 'id'=>'preview', 'page'=>array('portfolio'), 'context'=>'normal', 'priority'=>'high' ),
);

$boxes = apply_filters('avf_builder_boxes', $boxes);


$elements = array(
array(
		"slug"			=> "avia_builder",
		"name" 			=> "Visual layout editor",
		"id" 			=> "layout_editor",
		"type" 			=> array($builder,'visual_editor'),
		"tab_order"		=> array(__('Layout Elements','avia_framework' ), __('Content Elements','avia_framework' ) , __('Media Elements','avia_framework' )),
		"desc"			=>  '<h4>'.__('Quick Info & Hotkeys', 'avia_framework' )."</h4>".
							'<strong>'.__('General Info', 'avia_framework' ).'</strong>'.
							"<ul>".
							'   <li>'.__('To insert an Element either click the insert button for that element or drag the button onto the canvas', 'avia_framework' ).'</li>'.
							'   <li>'.__('If you place your mouse above the insert button a short info tooltip will appear', 'avia_framework' ).'</li>'.
							'   <li>'.__('To sort and arrange your elements just drag them to a position of your choice and release them', 'avia_framework' ).'</li>'.
							'   <li>'.__('Valid drop targets will be highlighted. Some elements like fullwidth sliders and color section can not be dropped onto other elements', 'avia_framework' ).'</li>'.
							"</ul>".
							'<strong>'.__('Edit Elements in Popup Window:', 'avia_framework' ).'</strong>'.
							"<ul>".
							'   <li>'.__('Most elements open a popup window if you click them', 'avia_framework' ).'</li>'.
							'   <li>'.__('Press TAB to navigate trough the various form fields of a popup window.', 'avia_framework' ).'</li>'.
							'   <li>'.__('Press ESC on your keyboard or the Close Button to close popup window.', 'avia_framework' ).'</li>'.
							'   <li>'.__('Press ENTER on your keyboard or the Save Button to save current state of a popup window', 'avia_framework' ).'</li>'.
							"</ul>"
	),
	
	array(
        "container_class" => "av_2columns av_col_1 avia-style",
        "slug"	=> "preview",
        "name" 	=> "Overwrite Portfolio Link setting",
        "desc" 	=> "If this entry is displayed in a portfolio grid, it will use the grids link settings (open either in lightbox, or open link url). You may overwrite this setting here",
        "id" 	=> "_portfolio_custom_link",
        "type" 	=> "select",
        "std" 	=> "",
        "subtype" => array( "Use default setting"   => '',
        					"Define custom link" => 'custom',

        )),
	
	array(
        "slug"	=> "preview",
		"name" 	=> __("Link portfolio item to external URL",'avia_framework' ),
		"desc" 	=> __("You can add a link to any (external) page here. <br/> If you add a link to a video that video will open in a lightbox",'avia_framework' ),
		"id" 	=> "_portfolio_custom_link_url",
		"type" 	=> "input",
        "required" 	=> array('_portfolio_custom_link','equals','custom'),
        "container_class" => "avia-style av_2columns av_col_2",
		"std" 	=> "http://"),
	
	array(
        "slug"	=> "preview",
		"id" 	=> "_portfolio_hr",
		"type" 	=> "hr",
		"std" 	=> ""),
	
	
	array(
        "slug"	=> "preview",
		"name" 	=> __("Ajax Portfolio Preview Settings",'avia_framework' ),
		"desc" 	=> __("If you have selected to display your portfolio grid as an 'Ajax Portfolio' please choose preview images here and write some preview text. Once the user clicks on the portfolio item a preview element with those images and info will open.",'avia_framework' ),
		"id" 	=> "_preview_heading",
		"type" 	=> "heading",
		"std" 	=> ""),
		
		
	array(
        "slug"	=> "preview",
        "container_class" => "av_2columns av_col_1",
		"name" 	=> __("Add Preview Images",'avia_framework' ),
		"desc" 	=> __("Create a new Preview Gallery or Slideshow by selecting existing or uploading new images",'avia_framework' ),
		"id" 	=> "_preview_ids",
		"type" 	=> "gallery",
		"title" => __("Add Preview Images",'avia_framework' ),
		"delete" => __("Remove Images",'avia_framework' ),
		"button" => __("Insert Images",'avia_framework' ),
		"std" 	=> ""),
	
		array(
        "container_class" => "av_2columns av_col_2",
        "slug"	=> "preview",
        "name" 	=> "Display Preview Images",
        "desc" 	=> "Display Images as either gallery, slideshow or as a list bellow each other",
        "id" 	=> "_preview_display",
        "type" 	=> "select",
        "std" 	=> "gallery",
        "class" => "avia-style",
        "subtype" => array( "Gallery"       => 'gallery',
        					"Slideshow"     => 'slideshow',
        					"Image List"    => 'list',

        ),
		),

		array(
        "container_class" => "av_2columns av_col_2",
        "slug"	=> "preview",
        "name" 	=> "Autorotation",
        "desc" 	=> "Slideshow autorotation Settings in Seconds",
        "id" 	=> "_preview_autorotation",
        "type" 	=> "select",
        "std" 	=> "disabled",
        "class" => "avia-style",
        "required" 	=> array('_preview_display','equals','slideshow'),
        "subtype" => array( 
        					"Disabled" => 'disabled',
        					"3"   => '3',
        					"4"   => '4',
        					"5"   => '5',
        					"6"   => '6',
        					"7"   => '7',
        					"8"   => '8',
        					"9"   => '9',
        					"10"   => '10',
        					"15"   => '15',
        					"20"   => '20',

        ),
		),
		
				array(
        "container_class" => "av_2columns av_col_2",
        "slug"	=> "preview",
        "name" 	=> "Gallery Thumbnail Columns",
        "desc" 	=> "How many Thumbnails should be displayed beside each other",
        "id" 	=> "_preview_columns",
        "type" 	=> "select",
        "std" 	=> "6",
        "class" => "avia-style",
        "required" 	=> array('_preview_display','equals','gallery'),
        "subtype" => array( 
        					"2"   => '2',
        					"3"   => '3',
        					"4"   => '4',
        					"5"   => '5',
        					"6"   => '6',
        					"7"   => '7',
        					"8"   => '8',
        					"9"   => '9',
        					"10"   => '10',
        					"11"   => '11',
        					"12"   => '12',

        ),
		),

	
	
	array(
        "slug"	=> "preview",
        "container_class" => "avia_clear",
		"name" 	=> __("Add Preview Text",'avia_framework' ),
		"desc" 	=> __("The text will appear beside your gallery/slideshow",'avia_framework' ),
		"id" 	=> "_preview_text",
		"type" 	=> "tiny_mce",
		"std" 	=> ""),
	

	array(

        "slug"	=> "layout",
        "name" 	=> "Layout",
        "desc" 	=> "Select the desired Page layout",
        "id" 	=> "layout",
        "type" 	=> "select",
        "std" 	=> "",
        "class" => "avia-style",
        "subtype" => array( "Default Layout - set in ".THEMENAME." > Layout & Options" => '',
        					"No Sidebar"       => 'fullsize',
        					"Left Sidebar"     => 'sidebar_left',
        					"Right Sidebar"    => 'sidebar_right',

        ),
		),

	array(

        "slug"	=> "layout",
        "name" 	=> "Sidebar Setting",
        "desc" 	=> "Choose a custom sidebar for this entry",
        "id" 	=> "sidebar",
        "type" 	=> "select",
        "std" 	=> "",
        "class" => "avia-style",
        "required" => array('layout','not','fullsize'),
        "subtype" => AviaHelper::get_registered_sidebars(array('Default Sidebars' => ""), array('Displayed Everywhere'))

		),
		array(

        "slug"	=> "layout",
        "name" 	=> "Header Settings",
        "desc" 	=> "Display the Header with Page Title and Breadcrumb Navigation?",
        "id" 	=> "header",
        "type" 	=> "select",
        "std" 	=> "yes",
        "class" => "avia-style",
        "subtype" => array( "Display the Header" => 'yes',
        					"Don't display the Header"  => "no",

                    )
        ),
        
        
        array(

        "slug"  => "layout",
        "name"  => "Footer Settings",
        "desc"  => "Display the footer widgets?",
        "id"    => "footer",
        "type"  => "select",
        "std"   => avia_get_option('display_widgets_socket'),
        "class" => "avia-style",
        "subtype" => array(
                        'Display the footer widgets & socket'=>'all',
                        'Display only the footer widgets (no socket)'=>'nosocket',
                        'Display only the socket (no footer widgets)'=>'nofooterwidgets',
                        'Don\'t display the socket & footer widgets'=>'nofooterarea'
                    ),

    ),

    
    

);


$elements = apply_filters('avf_builder_elements', $elements);




/*
array(

        "slug"	=> "avia_builder",
        "name" 	=> "Layout",
        "desc" 	=> "Select the desired Page layout",
        "id" 	=> "layout",
        "type" 	=> "radio",
        "class" => "image_radio image_radio_layout",
        "std" 	=> "fullwidth",
        "options" => array( 'default' 		=> "Default layout",
        					'sidebar_left' 	=> "Left Sidebar",
        					'sidebar_right' => "Right Sidebar",
        					'fullwidth' 	=> "No Sidebar"
        ),

        "images" => array(  'default' 		=> AviaBuilder::$path['imagesURL']."layout-slideshow.png",
        					'sidebar_left' 	=> AviaBuilder::$path['imagesURL']."layout-left.png",
        					'sidebar_right' => AviaBuilder::$path['imagesURL']."layout-right.png",
        					'fullwidth' 	=> AviaBuilder::$path['imagesURL']."layout-fullwidth.png",
        ),
    ),
*/