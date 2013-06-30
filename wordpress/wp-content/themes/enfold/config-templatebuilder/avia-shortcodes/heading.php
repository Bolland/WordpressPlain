<?php
/**
 * HORIZONTAL RULERS
 * Creates a horizontal ruler that provides whitespace for the layout and helps with content separation
 */
 
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }



if ( !class_exists( 'avia_sc_heading' ) ) 
{
	class avia_sc_heading extends aviaShortcodeTemplate{
			
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']		= __('Special Heading', 'avia_framework' );
				$this->config['tab']		= __('Content Elements', 'avia_framework' );
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-heading.png";
				$this->config['order']		= 93;
				$this->config['target']		= 'avia-target-insert';
				$this->config['shortcode'] 	= 'av_heading';
				$this->config['modal_data'] = array('modal_class' => 'mediumscreen');
				$this->config['tooltip'] 	= __('Creates a special Heading', 'avia_framework' );
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
						"name" 	=> __("Heading Text", 'avia_framework' ),
						"id" 	=> "heading",
						'container_class' =>"avia-element-fullwidth",
						"std" 	=> "Hello",
						"type" 	=> "input"),
						
					 array(	
							"name" 	=> __("Heading Type", 'avia_framework' ),
							"desc" 	=> __("Select which kind of heading you want to display.", 'avia_framework' ),
							"id" 	=> "tag",
							"type" 	=> "select",
							"std" 	=> "h3",
							"subtype" => array("H1"=>'h1',"H2"=>'h2',"H3"=>'h3',"H4"=>'h4',"H5"=>'h5',"H6"=>'h6')
							), 
							
					 array(	
							"name" 	=> __("Heading Color", 'avia_framework' ),
							"desc" 	=> __("Select a heading color", 'avia_framework' ),
							"id" 	=> "color",
							"type" 	=> "select",
							"std" 	=> "",
							"subtype" => array("Default Color"=>'',"Meta Color"=>'meta-heading')
							), 	
					
					array(	
							"name" 	=> __("Heading Style", 'avia_framework' ),
							"desc" 	=> __("Select a heading style", 'avia_framework' ),
							"id" 	=> "style",
							"type" 	=> "select",
							"std" 	=> "",
							"subtype" => array("Default Style"=>'', "Quote Style Modern"=>'blockquote modern-quote', "Quote Style Classic"=>'blockquote classic-quote')
							), 	
								   							
                    array(	"name" 	=> __("Padding Bottom", 'avia_framework' ),
							"desc" 	=> __("Bottom Padding in pixel", 'avia_framework' ),
				            "id" 	=> "padding",
				            "type" 	=> "select",
				            "subtype" => AviaHtmlHelper::number_array(0,60,1),
				            "std" => "10"),
				            
				  
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
				$params['class'] = "";
				$params['innerHtml'] = "<div class='avia_textblock avia_textblock_style avia-special-heading' data-update_with='heading'>".stripslashes(trim(html_entity_decode($params['args']['heading'])))."</div>";
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
			    extract(shortcode_atts(array('tag' => 'h3', 'padding' => '5', 'heading'=>'', 'color'=>'', 'style'=>''), $atts));
			
        		$output  = "";
        		$class   = $meta['el_class'];
        		
        		if($heading)
        		{
        			$heading = apply_filters('avia_ampersand', $heading);
	        		$styling = "style='padding-bottom:{$padding}px'";
	        		$output .= "<div {$styling} class='av-special-heading {$color} {$style} {$class}'><{$tag}>{$heading}</{$tag}><div class='special-heading-border'><div class='special-heading-inner-border'></div></div></div>";
        		}
        		
        		return $output;
        	}
			
			
	}
}
