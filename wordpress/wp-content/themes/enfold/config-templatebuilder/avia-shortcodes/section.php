<?php
/**
 * COLUMNS
 * Shortcode which creates columns for better content separation 
 */
 
 // Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }



if ( !class_exists( 'avia_sc_section' ) ) 
{
	class avia_sc_section extends aviaShortcodeTemplate{
			
			static $section_count = 0; 
			
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']		= 'Color Section';
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-section.png";
				$this->config['tab']		= __('Layout Elements', 'avia_framework' );
				$this->config['order']		= 40;
				$this->config['shortcode'] 	= 'av_section';
				$this->config['html_renderer'] 	= false;
				$this->config['tinyMCE'] 	= array('disable' => "true");
				$this->config['tooltip'] 	= __('Creates a section with unique background image and colors', 'avia_framework' );
				$this->config['drag-level'] = 1;
				$this->config['drop-level'] = 1;
				
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
				extract($params);
				$name = $this->config['shortcode'];
				$data['shortcodehandler'] 	= $this->config['shortcode'];
    			$data['modal_title'] 		= $this->config['name'];
    			$data['modal_ajax_hook'] 	= $this->config['shortcode'];
				$data['dragdrop-level'] 	= $this->config['drag-level'];
				$data['allowed-shortcodes']	= $this->config['shortcode'];
		
				
    			if(!empty($this->config['modal_on_load']))
    			{
    				$data['modal_on_load'] 	= $this->config['modal_on_load'];
    			}
    			
    			$dataString  = AviaHelper::create_data_string($data);
				
				$output  = "<div class='avia_layout_section avia_pop_class avia-no-visual-updates ".$name." av_drag' ".$dataString.">";
				
				$output .= "    <div class='avia_sorthandle menu-item-handle'>";
				$output .= "        <span class='avia-element-title'>".$this->config['name']."</span>";
			    //$output .= "        <a class='avia-new-target'  href='#new-target' title='".__('Move Section','avia_framework' )."'>+</a>";
				$output .= "        <a class='avia-delete'  href='#delete' title='".__('Delete Section','avia_framework' )."'>x</a>";
				
				if(!empty($this->config['popup_editor']))
    			{
    				$output .= "    <a class='avia-edit-element'  href='#edit-element' title='".__('Edit Section','avia_framework' )."'>edit</a>";
    			}
    			
				$output .= "        <a class='avia-clone'  href='#clone' title='".__('Clone Section','avia_framework' )."' >".__('Clone Section','avia_framework' )."</a></div>";
				$output .= "    <div class='avia_inner_shortcode avia_connect_sort av_drop' data-dragdrop-level='".$this->config['drop-level']."'>";
				$output .= "<textarea data-name='text-shortcode' cols='20' rows='4'>".ShortcodeHelper::create_shortcode_by_array($name, $content, $args)."</textarea>";
				if($content)
				{
					$content = $this->builder->do_shortcode_backend($content);
				}
				$output .= $content;
				$output .= "</div></div>";
				
				return $output;
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
			    global  $avia_config;
			
				$this->elements = array(
					
					
			        array(	
						"name" 	=> __("Section Colors",'avia_framework' ),
						"id" 	=> "color",
						"desc"  => __("The section will use the color scheme you select. Color schemes are defined on your styling page",'avia_framework' ) . 
						           '<br/><a target="_blank" href="'.admin_url('admin.php?page=avia#goto_styling').'">'.__("(Show Styling Page)",'avia_framework' )."</a>",
						"type" 	=> "select",
						"std" 	=> "main_color",
						"subtype" =>  array_flip($avia_config['color_sets'])
				    ),
				    
				    array(	
							"name" 	=> __("Custom Background Color", 'avia_framework' ),
							"desc" 	=> __("Select a custom background color for your Section here. Leave empty if you want to use the background color of the color scheme defined above", 'avia_framework' ),
							"id" 	=> "custom_bg",
							"type" 	=> "colorpicker",
							"std" 	=> "",
						),	
				     
					array(	
							"name" 	=> __("Custom Background Image",'avia_framework' ),
							"desc" 	=> __("Either upload a new, or choose an existing image from your media library. Leave empty if you want to use the background image of the color scheme defined above",'avia_framework' ),
							"id" 	=> "src",
							"type" 	=> "image",
							"title" => __("Insert Image",'avia_framework' ),
							"button" => __("Insert",'avia_framework' ),
							"std" 	=> ""),
							
                    array(	
						"name" 	=> __("Background Image Position",'avia_framework' ),
						"id" 	=> "position",
						"type" 	=> "select",
						"std" 	=> "top left",
                        "required" => array('src','not',''),
						"subtype" => array(   __('Top Left','avia_framework' )       =>'top left',
						                      __('Top Center','avia_framework' )     =>'top center',
						                      __('Top Right','avia_framework' )      =>'top right', 
						                      __('Bottom Left','avia_framework' )    =>'bottom left',
						                      __('Bottom Center','avia_framework' )  =>'bottom center',
						                      __('Bottom Right','avia_framework' )   =>'bottom right', 
						                      __('Center Left','avia_framework' )    =>'center left',
						                      __('Center Center','avia_framework' )  =>'center center',
						                      __('Center Right','avia_framework' )   =>'center right'
						                      )
				    ),
						
	               array(	
						"name" 	=> __("Background Repeat",'avia_framework' ),
						"id" 	=> "repeat",
						"type" 	=> "select",
						"std" 	=> "no-repeat",
                        "required" => array('src','not',''),
						"subtype" => array(   __('No Repeat','avia_framework' )          =>'no-repeat',
						                      __('Repeat','avia_framework' )             =>'repeat',
						                      __('Tile Horizontally','avia_framework' )  =>'repeat-x',
						                      __('Tile Vertically','avia_framework' )    =>'repeat-y',
						                      __('Stretch to fit','avia_framework' )     =>'stretch'
						                      )
				  ),
						
	               array(	
						"name" 	=> __("Background Attachment",'avia_framework' ),
						"id" 	=> "attach",
						"type" 	=> "select",
						"std" 	=> "scroll",
                        "required" => array('src','not',''),
						"subtype" => array(__('Scroll','avia_framework' )=>'scroll',__('Fixed','avia_framework' ) =>'fixed')
						),
						
					
				    array(	
						"name" 	=> __("Section Padding",'avia_framework' ),
						"id" 	=> "padding",
						"desc"  => __("Define the sections top and bottom padding",'avia_framework' ),
						"type" 	=> "select",
						"std" 	=> "default",
						"subtype" => array(   __('No Padding','avia_framework' )	=>'no-padding',
											  __('Small Padding','avia_framework' )	=>'small',
						                      __('Default Padding','avia_framework' )	=>'default',
						                      __('Large Padding','avia_framework' )	=>'large', 
						                  )
				    ),
				    
				    
				   array(	
						"name" 	=> __("Section Top Shadow",'avia_framework' ),
						"id" 	=> "shadow",
						"desc"  => __("Display a small styling shadow at the top of the section",'avia_framework' ),
						"type" 	=> "select",
						"std" 	=> "no-shadow",
						"subtype" => array(   __('Display shadow','avia_framework' )	=>'shadow',
						                      __('Do not display shadow','avia_framework' )	=>'no-shadow',
						                  )
				    ),	
                );
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
				avia_sc_section::$section_count++;			
			    extract(shortcode_atts(array('src' => '', 'position' => 'top left', 'repeat' => 'no-repeat', 'attach' => 'scroll', 'color' => 'main_color', 'custom_bg' => '', 'padding'=>'default' , 'shadow'=>'shadow'), $atts));
			    
			    $output      = "";
			    $class       = "avia-section ".$color." avia-section-".$padding." avia-".$shadow;
			    $background  = "";
			    
			    if($src != "")
			    {
			         if($repeat == 'stretch')
			         {
			             $background .= "background-repeat: no-repeat; ";
			             $class .= " avia-full-stretch";
			         }
			         else
			         {
			             $background .= "background-repeat: {$repeat}; ";
			         }
			    
			         $background .= "background-image: url({$src}); ";
			         $background .= "background-attachment: {$attach}; ";
			         $background .= "background-position: {$position}; ";
			    }
			    
			    if($custom_bg != "")
			    {
			         $background .= "background-color: {$custom_bg}; ";
			    }
			    
			    
			    if($background) $background = "style = '{$background}'";
			    
			    $params['class'] = $class." ".$meta['el_class'];
			    $params['bg']    = $background;
			    $params['id']	 = "av_section_".avia_sc_section::$section_count;
			     
			    if($meta['index'] == 0 || (isset($meta['siblings']['prev']['tag']) && in_array($meta['siblings']['prev']['tag'], array('av_layerslider','av_slideshow_full')))) $params['close'] = false;
			     
				$output .= avia_new_section($params);
				$output .=  ShortcodeHelper::avia_remove_autop($content) ;
				
				//if the next tag is a section dont create a new section from this shortcode
				if(!empty($meta['siblings']['next']['tag']) && in_array($meta['siblings']['next']['tag'], array('av_layerslider', 'av_section' ,'av_slideshow_full')))
				{
				    $skipSecond = true;
				}

				//if there is no next element dont create a new section. if we got a sidebar always create a next section at the bottom
				if(empty($meta['siblings']['next']['tag']) && !avia_has_sidebar())
				{
				    $skipSecond = true;
				}
				
				if(empty($skipSecond)) 
				{
					$new_params['id'] = "after_section_".( avia_sc_section::$section_count );
					$output .= avia_new_section($new_params);
				}
				
				return $output;
			}
	}
}


function avia_new_section($params = array())
{
    $defaults = array('class'=>'main_color', 'bg'=>'', 'close'=>true, 'open'=>true, 'open_structure' => true, 'open_color_wrap' => true, 'data'=>'', "style"=>'', 'id' => "" );
    extract(array_merge($defaults, $params));
    
    $post_class = "";
    $output     = "";
    if($id) $id = "id='{$id}'";
    
    //close old
    if($close) $output .= '</div></div></div></div></div>';
    
    //start new
    if($open)
    {
        if(function_exists('avia_get_the_id')) $post_class = "post-entry-".avia_get_the_id();
        
        if($open_color_wrap)
        {
        	$output .= "<div {$id} class='{$class} container_wrap ".avia_layout_class( 'main' , false )."' {$bg} {$data} {$style}>";
        }
        
        if($open_structure)
        {
	        $output .= "<div class='container'>";
	        $output .= "<div class='template-page content  ".avia_layout_class( 'content' , false )." units'>";
	        $output .= "<div class='post-entry post-entry-type-page {$post_class}'>";
	        $output .= "<div class='entry-content clearfix'>";
        }
    }
    return $output;
    
}






