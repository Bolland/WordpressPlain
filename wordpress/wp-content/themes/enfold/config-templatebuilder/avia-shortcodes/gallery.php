<?php
/**
 * Gallery
 * Shortcode that allows to create a gallery based on images selected from the media library
 */

if ( !class_exists( 'avia_sc_gallery' ) )
{
	class avia_sc_gallery extends aviaShortcodeTemplate
	{
			static $gallery = 0;

			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']			= __('Gallery', 'avia_framework' );
				$this->config['tab']			= __('Media Elements', 'avia_framework' );
				$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-gallery.png";
				$this->config['order']			= 90;
				$this->config['target']			= 'avia-target-insert';
				$this->config['shortcode'] 		= 'av_gallery';
				$this->config['modal_data']     = array('modal_class' => 'mediumscreen');
				$this->config['tooltip']        = __('Creates a custom gallery', 'avia_framework' );
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
							"name" 	=> __("Edit Gallery",'avia_framework' ),
							"desc" 	=> __("Create a new Gallery by selecting existing or uploading new images",'avia_framework' ),
							"id" 	=> "ids",
							"type" 	=> "gallery",
							"title" => __("Add/Edit Gallery",'avia_framework' ),
							"button" => __("Insert Images",'avia_framework' ),
							"std" 	=> ""),

					array(
							"name" 	=> __("Gallery Style", 'avia_framework' ),
							"desc" 	=> __("Choose the layout of your Gallery", 'avia_framework' ),
							"id" 	=> "style",
							"type" 	=> "select",
							"std" 	=> "thumbnails",
							"subtype" => array(
												__('Small Thumbnails',  'avia_framework' ) =>'thumbnails',
												__('Big image with thumbnails bellow', 'avia_framework' ) =>'big_thumb',
												)
							),

					array(
							"name" 	=> __("Gallery Big Preview Image Size", 'avia_framework' ),
							"desc" 	=> __("Choose image size for the Big Preview Image", 'avia_framework' ),
							"id" 	=> "preview_size",
							"type" 	=> "select",
							"std" 	=> "portfolio",
							"required" 	=> array('style','equals','big_thumb'),
							"subtype" =>  AviaHelper::get_registered_image_sizes(array('logo'))
							),

					array(
                        "name" 	=> __("Gallery Preview Image Size", 'avia_framework' ),
                        "desc" 	=> __("Choose image size for the small preview thumbnails", 'avia_framework' ),
                        "id" 	=> "thumb_size",
                        "type" 	=> "select",
                        "std" 	=> "portfolio",
                        "subtype" =>  AviaHelper::get_registered_image_sizes(array('logo'))
                    ),

					array(
							"name" 	=> __("Gallery Columns", 'avia_framework' ),
							"desc" 	=> __("Choose the column count of your Gallery", 'avia_framework' ),
							"id" 	=> "columns",
							"type" 	=> "select",
							"std" 	=> "5",
							"subtype" => AviaHtmlHelper::number_array(1,12,1)
							),

					array(
	                        "name" 	=> __("Use Lighbox", 'avia_framework' ),
	                        "desc" 	=> __("Do you want to activate the lightbox", 'avia_framework' ),
	                        "id" 	=> "imagelink",
	                        "type" 	=> "select",
	                        "std" 	=> "5",
	                        "subtype" => array(
	                            __('Yes',  'avia_framework' ) =>'lightbox',
	                            __('No, open the images in the browser window', 'avia_framework' ) =>'aviaopeninbrowser noLightbox',
	                            __('No, open the images in a new browser window/tab', 'avia_framework' ) =>'aviaopeninbrowser aviablank noLightbox',
	                            __('No, don\'t add a link to the images at all', 'avia_framework' ) =>'avianolink noLightbox')
	                    	)

						);

			}

			/**
			 * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
			 * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
			 * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
			 *
			 *
			 * @param array $params this array holds the default values for $content and $args.
			 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
			 */
			function editor_element($params)
			{
				$params['innerHtml'] = "<img src='".$this->config['icon']."' title='".$this->config['name']."' />";
				$params['innerHtml'].= "<div class='avia-element-label'>".$this->config['name']."</div>";
				$params['content'] 	 = NULL; //remove to allow content elements
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
				$output  = "";
				$first   = true;

				extract(shortcode_atts(array(
				'order'      	=> 'ASC',
				'thumb_size' 	=> 'thumbnail',
				'lightbox_size' => 'full',
				'preview_size'	=> 'portfolio',
				'ids'    	 	=> '',
				'imagelink'     => 'lightbox',
				'style'			=> 'thumbnails',
				'columns'		=> 5
				), $atts));


				$attachments = get_posts(array(
				'include' => $ids,
				'post_status' => 'inherit',
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'order' => $order,
				'orderby' => 'post__in')
				);


				if(!empty($attachments) && is_array($attachments))
				{
					self::$gallery++;
					$thumb_width = round(100 / $columns, 4);

					$output .= "<div class='avia-gallery avia-gallery-".self::$gallery." avia_animate_when_visible ".$meta['el_class']."'>";
					$thumbs = "";
					$counter = 0;

					foreach($attachments as $attachment)
					{
						$class	 = $counter++ % $columns ? "class='$imagelink'" : "class='first_thumb $imagelink'";

						$img  	 = wp_get_attachment_image_src($attachment->ID, $thumb_size);
						$link	 = wp_get_attachment_image_src($attachment->ID, $lightbox_size);
						$prev	 = wp_get_attachment_image_src($attachment->ID, $preview_size);

						$caption = trim($attachment->post_excerpt) ? wptexturize($attachment->post_excerpt) : "";
						$tooltip = $caption ? "data-avia-tooltip='".$caption."'" : "";

                        $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                        $alt = !empty($alt) ? esc_attr($alt) : '';
                        $title = trim($attachment->post_title) ? esc_attr($attachment->post_title) : "";
                        $description = trim($attachment->post_content) ? esc_attr($attachment->post_content) : "";

						if($style == "big_thumb" && $first)
						{
							$output .= "<a class='avia-gallery-big fakeLightbox $imagelink' href='".$link[0]."' data-onclick='1' title='".$description."' ><span class='avia-gallery-big-inner'>";
							$output .= "	<img src='".$prev[0]."' title='".$title."' alt='".$alt."' />";
			   if($caption) $output .= "	<span class='avia-gallery-caption>{$caption}</span>'";
							$output .= "</span></a>";
						}

						$thumbs .= " <a href='".$link[0]."' data-rel='gallery-".self::$gallery."' data-prev-img='".$prev[0]."' {$class} data-onclick='{$counter}' title='".$description."' ><img {$tooltip} src='".$img[0]."' title='".$title."' alt='".$alt."' /></a>";
						$first = false;
					}

					$output .= "<div class='avia-gallery-thumb'>{$thumbs}</div>";
					$output .= "</div>";

					//generate thumb width based on columns
					$output .= "<style type='text/css'>";
					$output .= "#top #wrap_all .avia-gallery-".self::$gallery." .avia-gallery-thumb a{width:{$thumb_width}%;}";
					$output .= "</style>";

				}

				return $output;
			}

	}
}

