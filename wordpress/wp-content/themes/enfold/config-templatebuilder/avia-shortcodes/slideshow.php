<?php
/**
 * Slider
 * Shortcode that allows to display a simple slideshow
 */

if ( !class_exists( 'avia_sc_slider' ) ) 
{
	class avia_sc_slider extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']			= __('Easy Slider', 'avia_framework' );
				$this->config['tab']			= __('Media Elements', 'avia_framework' );
				$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-slideshow.png";
				$this->config['order']			= 85;
				$this->config['target']			= 'avia-target-insert';
				$this->config['shortcode'] 		= 'av_slideshow';
				$this->config['shortcode_nested'] = array('av_slide');
				$this->config['tooltip'] 	    = __('Display a simple slideshow element', 'avia_framework' );
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
							"type" 			=> "modal_group", 
							"id" 			=> "content",
							'container_class' =>"avia-element-fullwidth avia-multi-img",
							"modal_title" 	=> __("Edit Form Element", 'avia_framework' ),
							"std"			=> array(),
							
							'creator'		=>array(
								
								"name" => __("Add Images", 'avia_framework' ),
								"desc" => __("Here you can add new Images to the slideshow.", 'avia_framework' ),
								"id" 	=> "id",
								"type" 	=> "multi_image",
								"title" => __("Add multiple Images",'avia_framework' ),
								"button" => __("Insert Images",'avia_framework' ),
								"std" 	=> ""),
													
							'subelements' 	=> array(	
									array(	
									"name" 	=> __("Choose another Image",'avia_framework' ),
									"desc" 	=> __("Either upload a new, or choose an existing image from your media library",'avia_framework' ),
									"id" 	=> "id",
									"fetch" => "id",
									"type" 	=> "image",
									"title" => __("Change Image",'avia_framework' ),
									"button" => __("Change Image",'avia_framework' ),
									"std" 	=> ""),
							
									array(	
									"name" 	=> __("Caption Title", 'avia_framework' ),
									"desc" 	=> __("Enter a caption title for the slide here", 'avia_framework' ) ,
									"id" 	=> "title",
									"std" 	=> "",
									"type" 	=> "input"),
									
									 array(	
									"name" 	=> __("Caption Text", 'avia_framework' ),
									"desc" 	=> __("Enter some additional caption text", 'avia_framework' ) ,
									"id" 	=> "content",
									"type" 	=> "textarea",
									"std" 	=> "",
									),
									
									array(	
									"name" 	=> __("Slide Link?", 'avia_framework' ),
									"desc" 	=> __("Where should the Slide link to?", 'avia_framework' ),
									"id" 	=> "link",
									"type" 	=> "linkpicker",
									"fetchTMPL"	=> true,
									"std" 	=> "-",
									"subtype" => array(	
														__('No Link', 'avia_framework' ) =>'',
														__('Lightbox', 'avia_framework' ) =>'lightbox',
														__('Set Manually', 'avia_framework' ) =>'manually',
														__('Single Entry', 'avia_framework' ) => 'single',
														__('Taxonomy Overview Page',  'avia_framework' ) => 'taxonomy',
														),
									"std" 	=> ""),
							
									array(	
									"name" 	=> __("Open Link in new Window?", 'avia_framework' ),
									"desc" 	=> __("Select here if you want to open the linked page in a new window", 'avia_framework' ),
									"id" 	=> "link_target",
									"type" 	=> "select",
									"std" 	=> "",
									"required"=> array('link','not_empty_and','lightbox'),
									"subtype" => array(
										__('No, open in same window',  'avia_framework' ) =>'',
										__('Yes, open in new window',  'avia_framework' ) =>'_blank')),	
						)	           
					),

					
					
					
					array(	
							"name" 	=> __("Slideshow Image Size", 'avia_framework' ),
							"desc" 	=> __("Choose image size for your slideshow.", 'avia_framework' ),
							"id" 	=> "size",
							"type" 	=> "select",
							"std" 	=> "featured",
							"subtype" =>  AviaHelper::get_registered_image_sizes(array('thumbnail','logo','widget','slider_thumb'))		
							),
					
					array(	
							"name" 	=> __("Slideshow Transition", 'avia_framework' ),
							"desc" 	=> __("Choose the transition for your Slideshow.", 'avia_framework' ),
							"id" 	=> "animation",
							"type" 	=> "select",
							"std" 	=> "slide",
							"subtype" => array(__('Slide','avia_framework' ) =>'slide',__('Fade','avia_framework' ) =>'fade'),	
							),
							
					array(	
						"name" 	=> __("Autorotation active?",'avia_framework' ),
						"desc" 	=> __("Check if the slideshow should rotate by default",'avia_framework' ),
						"id" 	=> "autoplay",
						"type" 	=> "select",
						"std" 	=> "false",
						"subtype" => array(__('Yes','avia_framework' ) =>'true',__('No','avia_framework' ) =>'false')),	
			
					array(	
						"name" 	=> __("Slideshow autorotation duration",'avia_framework' ),
						"desc" 	=> __("Images will be shown the selected amount of seconds.",'avia_framework' ),
						"id" 	=> "interval",
						"type" 	=> "select",
						"std" 	=> "5",
						"subtype" => 
						array('3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','15'=>'15','20'=>'20','30'=>'30','40'=>'40','60'=>'60','100'=>'100')),
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
				return $params;
			}
			
			/**
			 * Editor Sub Element - this function defines the visual appearance of an element that is displayed within a modal window and on click opens its own modal window
			 * Works in the same way as Editor Element
			 * @param array $params this array holds the default values for $content and $args. 
			 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
			 */
			function editor_sub_element($params)
			{	
				$img_template 		= $this->update_template("img_fakeArg", "{{img_fakeArg}}");
				$template 			= $this->update_template("title", "{{title}}");
				$content 			= $this->update_template("content", "{{content}}");
				
				$thumbnail = isset($params['args']['id']) ? wp_get_attachment_image($params['args']['id']) : "";
				
		
				$params['innerHtml']  = "";
				$params['innerHtml'] .= "<div class='avia_title_container'>";
				$params['innerHtml'] .= "	<span class='avia_slideshow_image' {$img_template} >{$thumbnail}</span>";
				$params['innerHtml'] .= "	<div class='avia_slideshow_content'>";
				$params['innerHtml'] .= "		<h4 class='avia_title_container_inner' {$template} >".$params['args']['title']."</h4>";
				$params['innerHtml'] .= "		<p class='avia_content_container' {$content}>".stripslashes($params['content'])."</p>";
				$params['innerHtml'] .= "	</div>";
				$params['innerHtml'] .= "</div>";
				
				
				
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
				$atts = shortcode_atts(array(
				'size'			=> 'featured',
				'animation'		=> 'slide',
				'ids'    	 	=> '',
				'autoplay'		=> 'false',
				'interval'		=> 5,
				'handle'		=> $shortcodename,
				'content'		=> ShortcodeHelper::shortcode2array($content),
				'class'			=> $meta['el_class']
				), $atts);
			
				$slider = new avia_slideshow($atts);
				return $slider->html();
			}
			
	}
}









if ( !class_exists( 'avia_slideshow' ) ) 
{
	class avia_slideshow
	{
		static  $slider = 0; 				//slider count for the current page
		private $config;	 				//base config set on initialization
		private $slides;	 				//attachment posts for the current slider
		private $slide_count = 0;			//number of slides
		
		function __construct($config)
		{
			$this->config = array_merge(array(
				'size'			=> 'featured',
				'animation'		=> 'slide',
				'ids'    	 	=> '',
				'autoplay'		=> 'false',
				'handle'		=> '',
				'interval'		=> 5,
				'class'			=> "",
				'content'		=> array()
				), $config);
			
			
			//check how large the slider is and change the classname accordingly
			global $_wp_additional_image_sizes;
			$width = 1500;
			
			if(isset($_wp_additional_image_sizes[$this->config['size']]['width']))
			{
				$width = $_wp_additional_image_sizes[$this->config['size']]['width'];
			}
			else if($size = get_option( $this->config['size'].'_size_w' ))
			{
				$width = $size;
			}
			
			if($width < 600)
			{
				$this->config['class'] .= " avia-small-width-slider";
			}
			
			if($width < 305)
			{
				$this->config['class'] .= " avia-super-small-width-slider";
			}
			
			
			//if we got subslides overwrite the id array
			if(!empty($config['content']))
			{
				$this->extract_subslides($config['content']);
			}
			
			$this->set_slides($this->config['ids']);
		}
		
		public function set_slides($ids)
		{
			if(empty($ids)) return;
			
			$this->slides = get_posts(array(	
				'include' => $ids, 
				'post_status' => 'inherit', 
				'post_type' => 'attachment', 
				'post_mime_type' => 'image', 
				'order' => 'ASC', 
				'orderby' => 'post__in') 
				);
				
			
			
			//resort slides so the id of each slide matches the post id
			$new_slides = array();
			foreach($this->slides as $slide)
			{
				$new_slides[$slide->ID] = $slide;
			}
			
			$this->slides 		= $new_slides;
			$this->id_array 	= explode(',',$this->config['ids']);
			$this->slide_count 	= count($this->id_array);
		}
		
		public function set_size($size)
		{
			$this->config['size'] = $size;
		}
		
		public function set_extra_class($class)
		{
			$this->config['class'] .= " ".$class;
		}
		
		
		
		public function html()
		{
			$html = "";
			$counter = 0;
			avia_slideshow::$slider++;
			if($this->slide_count == 0) return $html;
			
			
			$data = AviaHelper::create_data_string($this->config);
			
			$html .= "<div {$data} class='avia-slideshow avia-slideshow-".avia_slideshow::$slider." avia-slideshow-".$this->config['size']." ".$this->config['handle']." ".$this->config['class']." avia-".$this->config['animation']."-slider ' >";
			$html .= "<ul class='avia-slideshow-inner'>";
			
			$html .= empty($this->subslides) ? $this->default_slide() : $this->advanced_slide();
			
			$html .= "</ul>";
			
			if($this->slide_count > 1)
			{
				$html .= $this->slide_navigation_arrows();
				$html .= $this->slide_navigation_dots();
			}
			
			$html .= "</div>";
			
			return $html;
		}
		
		//function that renders the usual slides. use when we didnt use sub-shorcodes to define the images but ids
		private function default_slide()
		{
			$html = "";
			$counter = 0;
			
			foreach($this->id_array as $id)
			{
				if(isset($this->slides[$id]))
				{
					$slide = $this->slides[$id];
					
					$counter ++;
					$img 	 = wp_get_attachment_image_src($slide->ID, $this->config['size']);
					$link	 = wp_get_attachment_image_src($slide->ID, 'large');
					$caption = trim($slide->post_excerpt) ? '<div class="avia-caption capt-bottom capt-left"><div class="avia-inner-caption">'.wptexturize($slide->post_excerpt)."</div></div>": "";

                    $imgalt = get_post_meta($slide->ID, '_wp_attachment_image_alt', true);
                    $imgalt = !empty($imgalt) ? esc_attr($imgalt) : '';
                    $imgtitle = trim($slide->post_title) ? esc_attr($slide->post_title) : "";
                    $imgdescription = trim($slide->post_content) ? esc_attr($slide->post_content) : "";
					
					$html .= "<li class='slide-{$counter} slide-id-".$slide->ID."'>";
					$html .= "<a href='".$link[0]."' title='".$imgdescription."' >{$caption}<img src='".$img[0]."' title='".$imgtitle."' alt='".$imgalt."' /></a>";
					$html .= "</li>";
				}
				else
				{
					$this->slide_count --;
				}
			}
			
			return $html;
		}
		
		//function that renders the usual slides. use when we didnt use sub-shorcodes to define the images but ids
		private function advanced_slide()
		{
			$html = "";
			$counter = 0;
			
			foreach($this->id_array as $id)
			{
				if(isset($this->slides[$id]))
				{
					$slide = $this->slides[$id];
					
					$meta = array_merge( array( 'content'		=> $this->subslides[$slide->ID]['content'], 
												'title'			=>'', 
												'link'			=>'', 
												'link_target'	=>'',
												'caption_pos'	=>'capt-bottom capt-left',
												
												
											), $this->subslides[$slide->ID]['attr']);
					
					
					extract($meta);
					
					//fetch image and link
					$counter ++;
					$img  			= wp_get_attachment_image_src($slide->ID, $this->config['size']);
					$link 			= aviaHelper::get_url($link, $slide->ID); 
					$link_target 	= !empty($link_target) ? " target='_blank' " : "";
					$tags 			= !empty($link) ? array("a href='{$link}'{$link_target}",'a') : array('div','div'); 
					$caption  		= "";
					
					
					//check if we got a caption
					if(trim($title) != "")   $title 	= "<h2 class='avia-caption-title'>".trim($title)."</h2>";
					if(trim($content) != "") $content 	= "<div class='avia-caption-content'>".wpautop(ShortcodeHelper::avia_remove_autop(trim($content)))."</div>";
					
					if(trim($title.$content) != "")
					{
						if($this->config['handle'] == 'av_slideshow_full')
						{
							$caption .= '<div class = "caption_fullwidth '.$caption_pos.'">';
							$caption .= 	'<div class = "container caption_container">';
							$caption .= 			'<div class = "slideshow_caption">';
							$caption .= 				'<div class = "slideshow_inner_caption">';
							$caption .= 					'<div class = "slideshow_align_caption">';
							$caption .=						$title;
							$caption .=						$content;
							$caption .= 					'</div>';
							$caption .= 				'</div>';
							$caption .= 			'</div>';
							$caption .= 	'</div>';
							$caption .= '</div>';
						}
						else
						{
							$caption = '<div class="avia-caption"><div class="avia-inner-caption">'.$title.$content."</div></div>";
						}
					}


                    $linkalt = get_post_meta($slide->ID, '_wp_attachment_image_alt', true);
                    $linkalt = !empty($linkalt) ? esc_attr($linkalt) : '';
                    $linktitle = trim($slide->post_title) ? esc_attr($slide->post_title) : "";
                    $linkdescription = (trim($slide->post_content) && empty($link)) ? "title='".esc_attr($slide->post_content)."'" : "";

					$html .= "<li class='slide-{$counter} slide-id-".$slide->ID."'>";
					$html .= "<".$tags[0]." data-rel='slideshow-".avia_slideshow::$slider."' class='avia-slide-wrap' {$linkdescription} >{$caption}<img src='".$img[0]."' title='".$linktitle."' alt='".$linkalt."' /></".$tags[1].">";
					$html .= "</li>";
			}
			else
			{
				$this->slide_count --;
			}
		}
		
			
			return $html;
		}
		
				
		private function slide_navigation_arrows()
		{
			$html  = "";
			$html .= "<div class='avia-slideshow-arrows avia-slideshow-controls'>";
			$html .= 	"<a href='#next' class='prev-slide' >".__('Previous','avia_framework' )."</a>";
			$html .= 	"<a href='#next' class='next-slide' >".__('Next','avia_framework' )."</a>";
			$html .= "</div>";
			
			return $html;
		}
		
		private function slide_navigation_dots()
		{
			$html   = "";
			$html  .= "<div class='avia-slideshow-dots avia-slideshow-controls'>";
			$active = "active";
			
			for($i = 1; $i <= $this->slide_count; $i++)
			{
				$html .= "<a href='#{$i}' class='goto-slide {$active}' >{$i}</a>";
				$active = "";
			}
			
			$html .= "</div>";
			
			return $html;
		}
		
		private function extract_subslides($slide_array)
		{
			$this->config['ids']= array();
			$this->subslides 	= array();
			
			foreach($slide_array as $key => $slide)
			{
				$this->subslides[$slide['attr']['id']] = $slide;
				$this->config['ids'][] = $slide['attr']['id'];
			}
			
			$this->config['ids'] = implode(',',$this->config['ids'] );
			unset($this->config['content']);
		}
	}
}





















