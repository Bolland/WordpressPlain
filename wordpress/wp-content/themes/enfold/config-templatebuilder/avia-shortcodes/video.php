<?php
/**
 * Textblock
 * Shortcode which creates a text element wrapped in a div
 */
 
if ( !class_exists( 'avia_sc_video' ) ) 
{
	class avia_sc_video extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']			= __('Video', 'avia_framework' );
				$this->config['tab']			= __('Media Elements', 'avia_framework' );
				$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-video.png";
				$this->config['order']			= 100;
				$this->config['target']			= 'avia-target-insert';
				$this->config['shortcode'] 		= 'av_video';
				$this->config['modal_data']     = array('modal_class' => 'mediumscreen');
				$this->config['tooltip']        = __('Display a video', 'avia_framework' );
				$this->config['inline'] 		= true;
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
							"name" 	=> __("Choose Video",'avia_framework' ),
							"desc" 	=> __("Either upload a new video, choose an existing video from your media library or link to a video by URL",'avia_framework' )."<br/><br/>".
										__("A list of all supported Video Services can be found on",'avia_framework' ).
										" <a target='_blank' href='http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F'>WordPress.org</a><br/><br/>".
										__("Working examples, in case you want to use an external service:",'avia_framework' ). "<br/>".
										"<strong>http://vimeo.com/18439821</strong><br/>".
										"<strong>http://www.youtube.com/watch?v=G0k3kHtyoqc</strong><br/>",
							
							"id" 	=> "src",
							"type" 	=> "video",
							"title" => __("Insert Video",'avia_framework' ),
							"button" => __("Insert",'avia_framework' ),
							"std" 	=> ""),
					array(	
							"name" 	=> __("Video Format", 'avia_framework' ),
							"desc" 	=> __("Choose if you want to display a modern 16:9 or classic 4:3 Video, or use a custom ratio", 'avia_framework' ),
							"id" 	=> "format",
							"type" 	=> "select",
							"std" 	=> "16:9",
							"subtype" => array( 
												__('16:9',  'avia_framework' ) =>'16-9',
												__('4:3', 'avia_framework' ) =>'4-3',
												__('Custom Ratio', 'avia_framework' ) =>'custom',
												)		
							),
							
					array(	
							"name" 	=> __("Video width", 'avia_framework' ),
							"desc" 	=> __("Enter a value for the width", 'avia_framework' ),
							"id" 	=> "width",
							"type" 	=> "input",
							"std" 	=> "16",
							"required" => array('format','equals','custom')
						),	
						
					array(	
							"name" 	=> __("Video height", 'avia_framework' ),
							"desc" 	=> __("Enter a value for the height", 'avia_framework' ),
							"id" 	=> "height",
							"type" 	=> "input",
							"std" 	=> "9",
							"required" => array('format','equals','custom')
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
				$template = $this->update_template("src", "URL: {{src}}");
				
				$params['content'] = NULL;
				$params['innerHtml'] = "<img src='".$this->config['icon']."' title='".$this->config['name']."' />";
				$params['innerHtml'].= "<div class='avia-element-label'>".$this->config['name']."</div>";
				$params['innerHtml'].= "<div class='avia-element-url' {$template}> URL: ".$params['args']['src']."</div>";
				$params['class'] = "avia-video-element";

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
				global $wp_embed;
				
				extract(shortcode_atts(array('src' => '', 'autoplay' => '', 'format' => '', 'height'=>'9', 'width'=>'16'), $atts));
				
				$style = "";
				$html  = "";
				$file_extension = substr($src, strrpos($src, '.') + 1);
				
				if(in_array($file_extension, array('ogv','webm','mp4'))) //check for html 5 video
				{
					$output = avia_html5_video_embed($src);
					$html = "avia-video-html5";
				}
				else
				{
					$output = $wp_embed->run_shortcode("[embed]".trim($src)."[/embed]");
				}
				
				if($format == 'custom')
				{
					$height = intval($height);
					$width  = intval($width);
					$ratio  = (100 / $width) * $height;
					$style = "style='padding-bottom:{$ratio}%;'";
				}
				
				if($output)
				{
					$output = "<div {$style} class='avia-video avia-video-{$format} {$html}'>{$output}</div>";
				}
				
				
				return $output;
			}
			
			
	}
}
