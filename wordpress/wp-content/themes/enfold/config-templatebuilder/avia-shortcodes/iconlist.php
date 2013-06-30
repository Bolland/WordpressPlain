<?php
/**
 * Sidebar
 * Displays one of the registered Widget Areas of the theme
 */

if ( !class_exists( 'avia_sc_iconlist' ) )
{
	class avia_sc_iconlist extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']		= __('Icon List', 'avia_framework' );
				$this->config['tab']		= __('Content Elements', 'avia_framework' );
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-iconlist.png";
				$this->config['order']		= 90;
				$this->config['target']		= 'avia-target-insert';
				$this->config['shortcode'] 	= 'av_iconlist';
				$this->config['shortcode_nested'] = array('av_iconlist_item');
				$this->config['tooltip'] 	= __('Creates a list with nice icons beside', 'avia_framework' );
			}

			/**
			 * Popup Elements
			 *
			 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
			 * opens a modal window that allows to edit the element properties
			 *
			 * @return void
			 */
			function popup_elements()
			{
				$this->elements = array(


						array(
							"name" => __("Add/Edit List items", 'avia_framework' ),
							"desc" => __("Here you can add, remove and edit the items of your item list.", 'avia_framework' ),
							"type" 			=> "modal_group",
							"id" 			=> "content",
							"modal_title" 	=> __("Edit List Item", 'avia_framework' ),
							"std"			=> array(

													array('title'=>__('List Title 1', 'avia_framework' ), 'icon'=>'43', 'content'=>'Enter content here'),
													array('title'=>__('List Title 2', 'avia_framework' ), 'icon'=>'25', 'content'=>'Enter content here'),
													array('title'=>__('List Title 3', 'avia_framework' ), 'icon'=>'64', 'content'=>'Enter content here'),

													),


							'subelements' 	=> array(

									array(
									"name" 	=> __("List Item Title", 'avia_framework' ),
									"desc" 	=> __("Enter the list item title here (Better keep it short)", 'avia_framework' ) ,
									"id" 	=> "title",
									"std" 	=> "List Title",
									"type" 	=> "input"),


                                array(
                                    "name" 	=> __("Title Link?", 'avia_framework' ),
                                    "desc" 	=> __("Do you want to apply  a link to the title?", 'avia_framework' ),
                                    "id" 	=> "link",
                                    "type" 	=> "linkpicker",
                                    "fetchTMPL"	=> true,
                                    "std"	=> "",
                                    "subtype" => array(
                            			__('No Link', 'avia_framework' ) =>'',
                                        __('Set Manually', 'avia_framework' ) =>'manually',
                                        __('Single Entry', 'avia_framework' ) =>'single',
                                        __('Taxonomy Overview Page',  'avia_framework' )=>'taxonomy',
                                    ),
                                    "std" 	=> ""),

                                array(
                                    "name" 	=> __("Open in new window", 'avia_framework' ),
                                    "desc" 	=> __("Do you want to open the link in a new window", 'avia_framework' ),
                                    "id" 	=> "linktarget",
                                    "required" 	=> array('use_link', 'equals', 'yes'),
                                    "type" 	=> "select",
                                    "std" 	=> "no",
                                    "subtype" => array(
                                        __('Yes',  'avia_framework' ) =>'yes',
                                        __('No', 'avia_framework' ) =>'no')),


								array(
										"name" 	=> __("List Item Icon",'avia_framework' ),
										"desc" 	=> __("Select an icon for your list item bellow",'avia_framework' ),
										"id" 	=> "icon",
										"type" 	=> "iconfont",
										"font"	=> "entypo-fontello",
										"folder"=> AviaBuilder::$path['assetsURL']."fonts/",
										"chars"	=> AviaBuilder::$path['pluginPath'].'assets/fonts/entypo-fontello-charmap.php',
										"std" 	=> "1",
										),


									 array(
									"name" 	=> __("List Item Content", 'avia_framework' ),
									"desc" 	=> __("Enter some content here", 'avia_framework' ) ,
									"id" 	=> "content",
									"type" 	=> "tiny_mce",
									"std" 	=> "List Content goes here",
									),

						)
					),

					array(
						"name" 	=> __("Icon Position", 'avia_framework' ),
						"desc" 	=> __("Set the position of the icons", 'avia_framework' ),
						"id" 	=> "position",
						"type" 	=> "select",
						"std" 	=> "left",
						"subtype" => array(	__('Left', 'avia_framework' )  =>'left',
											__('Right', 'avia_framework' ) =>'right',
					)),


				);


			}

			/**
			 * Editor Sub Element - this function defines the visual appearance of an element that is displayed within a modal window and on click opens its own modal window
			 * Works in the same way as Editor Element
			 * @param array $params this array holds the default values for $content and $args.
			 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
			 */
			function editor_sub_element($params)
			{
				$template = $this->update_template("title", __("Element", 'avia_framework' ). ": {{title}}");

				$icon_el = $this->elements[0]['subelements'][3];

				$chars = $icon_el['chars'];
				if(!is_array($chars))
				{
					include($icon_el['chars']);
				}

				$display_char = isset($chars[($params['args']['icon'] - 1)]) ? $chars[($params['args']['icon'] - 1)] : $chars[0];


				$params['innerHtml']  = "";
				$params['innerHtml'] .= "<div class='avia_title_container'>";
				$params['innerHtml'] .= "<span data-update_with='icon_fakeArg' class='avia_tab_icon avia-font-".$icon_el['font']."'>".$display_char."</span>";
				$params['innerHtml'] .= "<span {$template} >".__("Element", 'avia_framework' ).": ".$params['args']['title']."</span></div>";

				return $params;
			}



			/**
			 * Frontend Shortcode Handler
			 *
			 * @param array $atts array of attributes
			 * @param string $content text within enclosing form of shortcode element
			 * @param string $shortcodename the shortcode found, when == callback name
			 * @return string $output returns the modified html string
			 */
			function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
			{
				extract(shortcode_atts(array('position'=>'left'), $atts));

				$icon_el = $this->elements[0]['subelements'][3];

				$chars = $icon_el['chars'];
				if(!is_array($chars))
				{
					include($icon_el['chars']);
				}

				$output		= "";
				$output .= "<div class='avia-icon-list-container ".$meta['el_class']."'>";
				$output .= "<ul class='avia-icon-list avia-icon-list-{$position} avia_animate_when_almost_visible'>";
				$output .= ShortcodeHelper::avia_remove_autop( $content );
				$output .= "</ul>";
				$output .= "</div>";


				return $output;
			}

			function av_iconlist_item($atts, $content = "", $shortcodename = "")
			{
                $icon_el = $this->elements[0]['subelements'][3];

				$chars = $icon_el['chars'];
				if(!is_array($chars))
				{
					include($icon_el['chars']);
				}

				$display_char = isset($chars[($atts['icon'] - 1)]) ? $chars[($atts['icon'] - 1)] : $chars[0];

                $atts['linktarget'] = (!empty($atts['linktarget']) && $atts['linktarget'] == 'no') ? '' : 'target="_blank"';
                if(!empty($atts['link']))
                {
					$atts['link'] = aviaHelper::get_url($atts['link']);
                    $atts['title'] = "<a href='{$atts['link']}' title='".esc_attr($atts['title'])."'>{$atts['title']}</a>";
                }

				$output  = "";
				$output .= "<li>";
				$output .= 		"<div class='iconlist_icon avia-font-".$icon_el['font']."'><span class='iconlist-char'>{$display_char}</span></div>";
				$output .= 		"<div class='iconlist_content_wrap'>";
				$output .= 			"<h4 class='iconlist_title'>".$atts['title']."</h4>";
				$output .= 			"<div class='iconlist_content'>".wpautop( ShortcodeHelper::avia_remove_autop( $content ) )."</div>";
				$output .= 			"</div>";
				$output .= 		"<div class='iconlist-timeline'></div>";
				$output .= "</li>";

				return $output;
			}


	}
}