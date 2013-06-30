<?php  if (  ! defined( 'AVIA_FW' ) ) exit( 'No direct script access allowed' );
/**
 * This file holds the avia_form class which is needed to build contact and other forms for the website
 *
 * @todo: improve backend so users can build forms on the fly, add aditional elements like selects, checkboxes and radio buttons
 *
 * @author		Christian "Kriesi" Budschedl
 * @copyright	Copyright ( c ) Christian Budschedl
 * @link		http://kriesi.at
 * @link		http://aviathemes.com
 * @since		Version 1.0
 * @package 	AviaFramework
 */


/**
 * AVIA Form
 * A simple class that is able to build and submit contact forms with the help of simple arrays that are passed to the form
 * It is build in a way that ajax sending is easily possible, but also works without javascript
 *
 */

if( ! class_exists( 'avia_form' ) )
{
	class avia_form
	{
		/**
		 * This array holds some default parameters for each form that gets created
		 * @var array
		 */
		var $form_params;


		/**
		 * This array holds the form elements that where set by the create elements function
		 * @var array
		 */
		var $form_elements;

		/**
		 * This string holds the fnal html output
		 * @var string
		 */
		var $output = "";


		/**
		 * This string holds the html output for elements that gets merged with the final output in case an error occured or no submission took place
		 * @var string
		 */
		var $elements_html = "";


		/**
		 * This variable holds the information if we should display the form or not. it has to be displayed if an error occurs wihle validating or if no submission took place yet
		 * @var bool
		 */
		var $submit_form = true;

		/**
		 * This variable holds the information if we should check the form elements or not
		 * @var bool
		 */
		var $do_checks = true;

		/**
		 * Array that holds the auto responder field
		 * @var bool
		 */
		var $autoresponder = array();

		/**
		 * Static var that counts the numbers of forms and if one is submitted makes sure that the others arent checked
		 * @var bool
		 */
		static $form_id = 1;

		/**
         * Constructor
         *
         * The constructor sets up the default params
         * @param array $params array with default form information such as submit button label, heading and success message
         */
		function avia_form($params)
		{
			$this->form_params = $params;
			$this->formID 		= avia_form::$form_id ++;
			$this->id_sufix		= isset($params['multiform']) ? "_".$this->formID : "";

			$extraClass = isset($params['form_class']) ? $params['form_class'] : "";

			$this->output  = '<form action="'.$params['action'].'" method="post" class="ajax_form '.$extraClass.'" data-avia-form-id="'.$this->formID.'"><fieldset>';
			$this->output .=  $params['heading'];


			if(!isset($_POST) || !count($_POST) || empty($_POST['avia_generated_form'.$this->formID]))
			{
				$this->submit_form = false; //dont submit the form
				$this->do_checks   = false; //dont do any checks on the form elements
			}
		}


		/**
         * create_elements
         *
         * The create_elements method iterates over a set of elements passed and creates the according form element in the frontend
         * @param array $elements array with elements that should eb created
         */
		function create_elements($elements)
		{
			$this->form_elements = $elements;
			$iterations = 0;
			$width = "";
			$this->lastwidth = "";
			foreach($elements as $key => $element)
			{
				if(isset($element['type']) && method_exists($this, $element['type']))
				{
					$element_id = avia_backend_safe_string('avia_'.$key);
					if($element_id == "avia_")
					{
						$iterations ++;
						$element_id = "avia_".$iterations;
					}

					if(empty($element['class'])) $element['class'] = "";

					if(!empty($width) && strpos($this->lastwidth, '_2') === false)
					{
						$element['class'] .= " ".$width."_2 ";
					}

					$width = !empty($element['width']) ? " form_".$element['width'] : "";
					$element['class'] .= $width;


					$element['last_class'] = $this->lastwidth;
					$this->$element['type']($element_id.$this->id_sufix, $element);
					$this->lastwidth = $element['class'];
				}
			}
		}


		/**
         * display_form
         *
         * Checks if an error occured and if the user tried to send, if thats the case, and if sending worked display a success message, otherwise display the whole form
         */
		function display_form($return = false)
		{
			$success = '<div id="ajaxresponse'.$this->id_sufix.'" class="ajaxresponse ajaxresponse'.$this->id_sufix.' hidden"></div>';

			if($this->submit_form && $this->send())
			{
				$success = '<div id="ajaxresponse'.$this->id_sufix.'" class="ajaxresponse ajaxresponse'.$this->id_sufix.'">'.$this->form_params['success'].'</div>';
			}
			else
			{
				$p_class = !empty($this->lastwidth) ? "modified_width ".$this->lastwidth." ".str_replace('_2','',$this->lastwidth) : "";
				$this->output .= $this->elements_html;
				$this->output .= '<p class="'.$p_class.'">';
				$this->output .= '<input type="hidden" value="1" name="avia_generated_form'.$this->formID.'" />';
				$this->output .= '<input type="submit" value="'.$this->form_params['submit'].'" class="button" />';
				$this->output .= '</p>';
			}


			$this->output .= '</fieldset></form>'.$success;

			if($return)
			{
				return $this->output;
			}
			else
			{
				echo $this->output;
			}
		}


		/**
         * text
         *
         * The text method creates input elements with type text, and prefills them with $_POST values if available.
         * The method also checks against various input validation cases
         * @param string $id holds the key of the element
         * @param array $element data array of the element that should be created
         */
		function text($id, $element)
		{
			$p_class = $required = $element_class = $value = "";

			if(!empty($element['check']))
			{
				$required = ' <abbr class="required" title="required">*</abbr>';
				$element_class = $element['check'];
				$p_class = $this->check_element($id, $element);
			}

			if(!empty($_POST[$id])) $value = urldecode($_POST[$id]);

			$this->elements_html .= "<p class='".$p_class.$element['class']."' id='element_$id'>";
			$form_el = ' <input name="'.$id.'" class="text_input '.$element_class.'" type="text" id="'.$id.'" value="'.$value.'"/>';
			$label = '<label for="'.$id.'">'.$element['label'].$required.'</label>';

			if(isset($this->form_params['label_first']))
			{
				$this->elements_html .= $label.$form_el;
			}
			else
			{
				$this->elements_html .= $form_el.$label;
			}

			$this->elements_html .= "</p>";
		}

		/**
         * checkbox
         *
         * The text method creates input elements with type checkbox, and prefills them with $_POST values if available.
         * The method also checks against various input validation cases
         * @param string $id holds the key of the element
         * @param array $element data array of the element that should be created
         */
		function checkbox($id, $element)
		{
			$p_class = $required = $element_class = $checked = "";

			if(!empty($element['check']))
			{
				if(!empty($_POST[$id])) $checked = 'checked="checked"';
				$required = ' <abbr class="required" title="required">*</abbr>';
				$element_class = $element['check'];
				$p_class = $this->check_element($id, $element);
			}
			if(empty($_POST[$id])) $_POST[$id] = "false";


			$this->elements_html .= "<p class='".$p_class.$element['class']."' id='element_$id'>";
			$this->elements_html .= '    <input '.$checked.' name="'.$id.'" class="input_checkbox '.$element_class.'" type="checkbox" id="'.$id.'" value="true"/><label for="'.$id.'">'.$element['label'].$required.'</label>';
			$this->elements_html .= "</p>";
		}


		/**
         * Select
         *
         * The select method creates a dropdown element with type select, and prefills them with $_POST values if available.
         * The method also checks against various input validation cases
         * @param string $id holds the key of the element
         * @param array $element data array of the element that should be created
         */
		function select($id, $element)
		{

			if(empty($element['options'])) return;
			$element['options'] = explode(',',$element['options']);

			$p_class = $required = $element_class = $prefilled_value = $select = "";

			if(!empty($element['check']))
			{
				$required = ' <abbr class="required" title="required">*</abbr>';
				$element_class = $element['check'];
				$p_class = $this->check_element($id, $element);
			}

			if(!empty($_POST[$id])) $prefilled_value = urldecode($_POST[$id]);

			foreach($element['options'] as $option)
			{
				$key = $value = trim($option);
				$suboptions =  explode('|',$option);
				if(is_array($suboptions) && !empty($suboptions[1]))
				{
					$key = trim($suboptions[1]);
					$value = trim($suboptions[0]);
				}


				$active = $value == $prefilled_value ? "selected='selected'" : "";
				$select .= "<option $active value ='$key'>$value</option>";
			}


			$this->elements_html .= "<p class='".$p_class.$element['class']."' id='element_$id'>";
			$form_el = ' <select name="'.$id.'" class="select '.$element_class.'" id="'.$id.'">'.$select.'</select>';
			$label = '<label for="'.$id.'">'.$element['label'].$required.'</label>';

			if(isset($this->form_params['label_first']))
			{
				$this->elements_html .= $label.$form_el;
			}
			else
			{
				$this->elements_html .= $form_el.$label;
			}

			$this->elements_html .= "</p>";
		}


		/**
         * textarea
         *
         * The textarea method creates textarea elements, and prefills them with $_POST values if available.
         * The method also checks against various input validation cases
         * @param string $id holds the key of the element
         * @param array $element data array of the element that should be created
         */
		function textarea($id, $element)
		{
			$p_class = $required = $element_class = $value = "";

			if(!empty($element['check']))
			{
				$required = ' <abbr class="required" title="required">*</abbr>';
				$element_class = $element['check'];
				$p_class = $this->check_element($id, $element);
			}

			if(!empty($_POST[$id])) $value = urldecode($_POST[$id]);

			$this->elements_html .= "<p class='".$p_class.$element['class']."' id='element_$id'>";
			$this->elements_html .= '	 <label for="'.$id.'" class="textare_label hidden textare_label_'.$id.'">'.$element['label'].$required.'</label>';
			$this->elements_html .= '	 <textarea name="'.$id.'" class="text_area '.$element_class.'" cols="40" rows="7" id="'.$id.'" >'.$value.'</textarea>';
			$this->elements_html .= "</p>";
		}



		/**
         * decoy
         *
         * The decoy method creates input elements with type text but with an extra class that hides them
		 * The method is used to fool bots into filling the form element. Upon submission we check if the element contains any value, if so we dont submit the form
         * @param string $id holds the key of the element
         * @param array $element data array of the element that should be created
         */
		function decoy($id, $element)
		{
			$p_class = $required = $element_class = "";

			if(!empty($element['check']))
			{
				$this->check_element($id, $element);
			}

			$this->elements_html .= '<p class="hidden"><input type="text" name="'.$id.'" class="hidden '.$element_class.'" id="'.$id.'" value="" /></p>';
		}



		/**
         * Captcha
         *
         * The captcha method creates input element that needs to be filled  correctly to send the form
         * @param string $id holds the key of the element
         * @param array $element data array of the element that should be created
         */
		function captcha($id, $element)
		{

			$p_class = $required = $element_class = $value = $valueVer = "";

			if(!empty($element['check']))
			{
				$required = ' <abbr class="required" title="required">*</abbr>';
				$element_class = $element['check'];
				$p_class = $this->check_element($id, $element);
			}

			if(!empty($element['last_class']))
			{
				$p_class .= " ".$element['last_class']." ".str_replace('_2','',$element['last_class']);
			}
			$this->lastwidth = "";

			if(!empty($_POST[$id])) $value = urldecode($_POST[$id]);
			if(!empty($_POST[$id.'_verifier'])) $valueVer = urldecode($_POST[$id.'_verifier']);

			if(!$valueVer) $valueVer	= str_replace('0','4', str_replace('9','7', rand(123456789, 999999999)));
			$reverse 	= strrev( $valueVer );
			$enter		= $valueVer[$reverse[0]];
			$number_1	= rand(0, $enter);
			$number_2	= $enter - $number_1;

			$this->elements_html .= "<p class='".$p_class."' id='element_$id'>";
			$this->elements_html .= "    <span class='value_verifier_label'>$number_1 + $number_2 = ?</span>";
			$this->elements_html .= '    <input name="'.$id.'_verifier" type="hidden" id="'.$id.'_verifier" value="'.$valueVer.'"/>';
			$form_el = '    <input name="'.$id.'" class="text_input '.$element_class.'" type="text" id="'.$id.'" value="'.$value.'"/>';
			$label ='<label for="'.$id.'">'.$element['label'].$required.'</label>';

			if(isset($this->form_params['label_first']))
			{
				$this->elements_html .= $label.$form_el;
			}
			else
			{
				$this->elements_html .= $form_el.$label;
			}

			$this->elements_html .= "</p>";
		}



		/**
         * hidden
         *
         * The hidden method creates input elements with type hidden, and prefills them with values if available.
         * @param string $id holds the key of the element
         * @param array $element data array of the element that should be created
         */
		function hidden($id, $element)
		{
			$this->elements_html .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$element['value'].'" />';
		}


		/**
         * Send the form
         *
         * The send method tries to send the form. It builds the necessary email and submits it via wp_mail
         */
		function send()
		{
			$new_post = array();
			foreach ($_POST as $key => $post)
			{
				$new_post[str_replace('avia_','',$key)] = $post;
			}

			$mymail 	= empty($this->form_params['myemail']) ? $new_post['myemail'] : $this->form_params['myemail'];
			$myblogname = empty($this->form_params['myblogname']) ? $new_post['myblogname'] : $this->form_params['myblogname'];
			$subject 	= empty($new_post['subject']) ? __("New Message", 'avia_framework') : $new_post['subject'];

			$default_from = parse_url(home_url());


			//hook to stop execution here and do something different with the data
			$proceed = apply_filters('avf_form_send', true, $new_post, $this->form_params);

			if(!$proceed) return true;

			//set the email adress
			$from = "no-reply@wp-message.com";
			$usermail = false;

			if(!empty($default_from['host'])) $from = "no-reply@".$default_from['host'];

			if(!empty($this->autoresponder[0]))
			{
				$from = $_POST[$this->autoresponder[0]];
				$usermail = true;
			}
			else
			{
				$email_variations = array( 'e-mail', 'email', 'mail' );

				foreach($email_variations as $key)
				{
					foreach ($new_post as $current_key => $current_post)
					{
						if( strpos($current_key, $key) !== false)
						{
							$from = $new_post[$current_key];
							$usermail = true;
							break;
						}

					}

					if($usermail == true) break;
				}
			}

			$to = urldecode( $mymail );
			$to = apply_filters("avf_form_sendto", $to, $new_post, $this->form_params);

			$from = urldecode( $from );
			$from = apply_filters("avf_form_from", $from, $new_post, $this->form_params);

			$subject = urldecode( $subject  . " (".__('sent by contact form at','avia_framework')." ".$myblogname.")" );
			$subject = apply_filters("avf_form_subject", $subject, $new_post, $this->form_params);

			$message = "";
			$iterations = 0;

			foreach($this->form_elements as $key => $element)
			{
				$key = avia_backend_safe_string($key);

				if(empty($key))
				{
					$iterations++;
					$key = $iterations;
				}

				$key .= $this->id_sufix;

				if(!empty($new_post[$key]))
				{
					if($element['type'] != 'hidden' && $element['type'] != 'decoy')
					{
						if($element['type'] == 'textarea') $message .= "<br/>";
						$message .= $element['label'].": ".nl2br(urldecode($new_post[$key]))."<br/>";
						if($element['type'] == 'textarea') $message .= "<br/>";
					}
				}
			}


			$use_wpmail = apply_filters("avf_form_use_wpmail", false, $new_post, $this->form_params);

			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header .= 'From:'. $from . " \r\n";

			if($use_wpmail)
			{
				wp_mail($to, $subject, $message, $header);
			}
			else
			{
				mail($to, $subject, $message, $header);
			}


			//autoresponder?
			if($usermail && !empty($this->form_params['autoresponder']))
			{
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$header .= 'From:'. urldecode( $this->form_params['autoresponder_email']) . " \r\n";

				$message = nl2br($this->form_params['autoresponder'])."<br/><br/><br/><strong>".__('Your Message:','avia_framework')." </strong><br/><br/>".$message;
				$message = apply_filters("avf_form_autorespondermessage", $message);

				$from = apply_filters("avf_form_autoresponder_from", $from, $new_post, $this->form_params);

				if($use_wpmail)
				{
					wp_mail($from, $this->form_params['autoresponder_subject'], $message, $header);
				}
				else
				{
					mail($from, $this->form_params['autoresponder_subject'], $message, $header);
				}
			}
			unset($_POST);
			return true;
			//return wp_mail( $to, $subject, $message , $header);


		}


		/**
         * Check the value of an element
         *
         * The check_element method creates checks if the submitted value of a post element is valid
         * @param string $id holds the key of the element
         * @param array $element data array of the element that should be created
         */
		function check_element($id, $element)
		{
			if(isset($_POST) && count($_POST) && isset($_POST[$id]) && $this->do_checks)
			{
				switch ($element['check'])
				{
					case 'is_empty':

						if(!empty($_POST[$id])) return "valid";

					break;

					case 'must_empty':

						if(isset($_POST[$id]) && $_POST[$id] == "") return "valid";

					break;

					case 'is_email':

						$this->autoresponder[] = $id;
						if(preg_match("!^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$!", urldecode($_POST[$id]))) return "valid";

					break;

					case 'is_number':

						if(preg_match("!^(\d)*$!", urldecode($_POST[$id]))) return "valid";

					break;

					case 'is_phone':

						if(preg_match("!^(\d|\s|\-|\/|\(|\)|\[|\]|e|x|t|ension|\.|\+|\_|\,|\:|\;)*$!", urldecode($_POST[$id]))) return "valid";

					break;

					case 'captcha':

						$ver = $_POST[$id.'_verifier'];
						$reverse = strrev( $ver );

						if($ver[$reverse[0]] == $_POST[$id])
						{
							unset($_POST[$id], $_POST[$id.'_verifier']);
							return "valid";
						}
					break;

				} //end switch

				$this->submit_form = false;
				return "error";
			}
		}
	}
}









