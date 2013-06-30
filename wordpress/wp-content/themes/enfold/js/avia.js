(function($)
{
    "use strict";

    $(document).ready(function()
    {
		$.avia_utilities = $.avia_utilities || {};
		
    	//responsive menu. needs to be at the top
    	avia_responsive_menu();

        // decreases header size when user scrolls down
        avia_header_size();

        //show scroll top button
        avia_scroll_top_fade();

        //creates search tooltip
        new $.AviaTooltip({"class": 'avia-search-tooltip',data: 'avia-search-tooltip', event:'click', position:'bottom', scope: "body", attach:'element'});

        //creates relate posts tooltip
        new $.AviaTooltip({"class": 'avia-related-tooltip', data: 'avia-related-tooltip', scope: ".related_posts", attach:'element', delay:0});

        //creates ajax search
        new $.AviaAjaxSearch({scope:'#header'});


		// actiavte portfolio sorting
		if($.fn.avia_iso_sort)
		$('.grid-sort-container').avia_iso_sort();


		//activates the mega menu javascript
		if($.fn.aviaMegamenu)
		$(".main_menu .menu").aviaMegamenu({modify_position:true});


		$('a.avianolink').on('click', function(){return false;});
        $('a.aviablank').attr('target', '_blank');

		
		$.avia_utilities.avia_ajax_call();
    });

	$.avia_utilities = $.avia_utilities || {};
	
	$.avia_utilities.avia_ajax_call = function(container)
	{
		if(typeof container == 'undefined'){ container = 'body';};
		
		//activates the prettyphoto lightbox
		if($.fn.avia_activate_lightbox)
		$(container).avia_activate_lightbox();
		
		//smooth scrooling
		if($.fn.avia_smoothscroll)
		$('a[href*=#]', container).avia_smoothscroll();
		
		avia_small_fixes(container);
		
		avia_hover_effect(container);
		
		//activate html5 video player
		if($.fn.avia_html5_activation && $.fn.mediaelementplayer)
		$(".avia_video, .avia_audio", container).avia_html5_activation({ratio:'16:9'});
		
	}


     // -------------------------------------------------------------------------------------------
	// responsive menu function
	// -------------------------------------------------------------------------------------------
	
    function avia_responsive_menu()
    {
    	var win = $(window), header = $('.responsive #header');

    	if(!header.length) return;

    	var menu 			  = header.find('.main_menu ul:eq(0)'),
	    	first_level_items = menu.find('>li').length,
	    	bottom_menu 	  = $('html').is('.bottom_nav_header'),
	    	switchWidth 	  = 767;

    	if(first_level_items > 18 && !bottom_menu)
    	{
    		switchWidth = 989;
    		header.addClass('mobile_menu_tablet');
    	}

    	if(header.is('.mobile_drop_down'))
    	{
	    	menu.mobileMenu({
			  switchWidth: switchWidth,                   					//width (in px to switch at)
			  topOptionText: jQuery('.main_menu').data('selectname'),     	//first option text
			  indentString: 'ontouchstart' in document.documentElement ? '- ' : "&nbsp;&nbsp;&nbsp;"//string for indenting nested items
			});
    	}
    	else
    	{
	    	var container		= $('#wrap_all'),
	    		show_menu		= $('<a id="advanced_menu_toggle" href="#" class="avia-font-entypo-fontello">&#57349;</a>'),
	    		hide_menu		= $('<a id="advanced_menu_hide" href="#" class="avia-font-entypo-fontello">&#10006;</a>'),
	    		mobile_advanced = menu.clone().attr({id:"mobile-advanced", "class":""}),
	    		menu_added 		= false;

	    		mobile_advanced.find('.noMobile').remove();

	    		show_menu.click(function()
	    		{
	    			if(container.is('.show_mobile_menu'))
	    			{
	    				container.removeClass('show_mobile_menu');
	    				container.css({'height':"auto"});
	    			}
	    			else
	    			{
	    				container.addClass('show_mobile_menu');
	    				set_height();
	    			}
	    			return false;
	    		});

	    		hide_menu.click(function()
	    		{
	    			container.removeClass('show_mobile_menu');
	    				container.css({'height':"auto"});
	    			return false;
	    		});


	    		var set_visibility = function()
	    		{
	    			if(win.width() > switchWidth)
	    			{
	    				header.removeClass('mobile_active');
	    				container.removeClass('show_mobile_menu');
	    				container.css({'height':"auto"});
	    			}
	    			else
	    			{
	    				header.addClass('mobile_active');
	    				if(!menu_added)
	    				{

	    					var after_menu = $('#header .logo');
	    					show_menu.insertAfter(after_menu);
	    					mobile_advanced.prependTo(container);
	    					hide_menu.prependTo(container);
	    					menu_added = true;
	    				}

	    				if(container.is('.show_mobile_menu'))
	    				{
	    					set_height();
	    				}
	    			}
	    		},

	    		set_height = function()
	    		{
	    			var height = mobile_advanced.css({position:'relative'}).outerHeight(true),
	    				win_h  = win.height();

	    			if(height < win_h) height = win_h;
	    			mobile_advanced.css({position:'absolute'});
	    			container.css({'height':height});
	    		};

	    		win.on("debouncedresize", set_visibility);
	    		set_visibility();
    	}
    }




    // -------------------------------------------------------------------------------------------
	// html 5 videos
	// -------------------------------------------------------------------------------------------
    $.fn.avia_html5_activation = function(options)
	{
		var defaults =
		{
			ratio: '16:9'
		};

		var options = $.extend(defaults, options);

		return this.each(function()
		{
		var fv 			= $(this),
	      	id_to_apply = '#' + fv.attr('id'),
	      	posterImg 	= fv.attr('poster');


		fv.mediaelementplayer({
		    // if the <video width> is not specified, this is the default
		    defaultVideoWidth: 480,
		    // if the <video height> is not specified, this is the default
		    defaultVideoHeight: 270,
		    // if set, overrides <video width>
		    videoWidth: -1,
		    // if set, overrides <video height>
		    videoHeight: -1,
		    // width of audio player
		    audioWidth: 400,
		    // height of audio player
		    audioHeight: 30,
		    // initial volume when the player starts
		    startVolume: 0.8,
		    // useful for <audio> player loops
		    loop: false,
		    // enables Flash and Silverlight to resize to content size
		    enableAutosize: true,
		    // the order of controls you want on the control bar (and other plugins below)
		    features: ['playpause','progress','current','duration','tracks','volume','fullscreen'],
		    // Hide controls when playing and mouse is not over the video
		    alwaysShowControls: false,
		    // force iPad's native controls
		    iPadUseNativeControls: false,
		    // force iPhone's native controls
		    iPhoneUseNativeControls: false,
		    // force Android's native controls
		    AndroidUseNativeControls: false,
		    // forces the hour marker (##:00:00)
		    alwaysShowHours: false,
		    // show framecount in timecode (##:00:00:00)
		    showTimecodeFrameCount: false,
		    // used when showTimecodeFrameCount is set to true
		    framesPerSecond: 25,
		    // turns keyboard support on and off for this instance
		    enableKeyboard: true,
		    // when this player starts, it will pause other players
		    pauseOtherPlayers: true,
		    // array of keyboard commands
		    keyActions: []

				});
			});
		}



 	// -------------------------------------------------------------------------------------------
	// hover effect for images
	// -------------------------------------------------------------------------------------------
    function avia_hover_effect(container)
    {
    	if(container == 'body')
    	{ 
    		var elements = $('#main a img').parents('a').not('.noLightbox, .noLightbox a, .avia-gallery-thumb a'); 
    	} 
    	else
    	{ 
    		var elements = $('a img', container).parents('a').not('.noLightbox, .noLightbox a, .avia-gallery-thumb a'); 
    	}

		var overlay = "", isMobile 	= 'ontouchstart' in document.documentElement;
		
		if(isMobile) return; //hover overlay for mobile device doesnt really make sense. in addition it often slows done the click event

		elements.on('mouseenter', function(e)
		{
			var link  		= $(this),
				current	 	= link.find('img:first'),
				url		 	= link.attr('href'),
				span_class	= "overlay-type-video",
				opa			= 0.7;
			
			if(current.hasClass('alignleft')) link.addClass('alignleft').css({float:'left', margin:0, padding:0});
            if(current.hasClass('alignright')) link.addClass('alignright').css({float:'right', margin:0, padding:0});
            if(current.hasClass('aligncenter')) link.addClass('aligncenter').css({float:'none','text-align':'center', margin:0, padding:0});
			
			overlay = link.find('.image-overlay');

			if(!overlay.length)
			{
				if(current.outerHeight() > 100)
				{
				if(link.height() == 0) { link.addClass(current.get(0).className); current.get(0).className = ""; }
				if(!link.css('position') || link.css('position') == 'static') { link.css({position:'relative', overflow:'hidden'}); }
				if(!link.css('display') || link.css('display') == 'inline') { link.css({display:'block'}); }
				if( url.match(/(jpg|gif|jpeg|png|tif)/) ) span_class = "overlay-type-image";
				if(!url.match(/(jpg|gif|jpeg|png|\.tif|\.mov|\.swf|vimeo\.com|youtube\.com)/) ) span_class = "overlay-type-extern";

				overlay = $("<span class='image-overlay "+span_class+"' style='opacity: 0;'><span class='image-overlay-inside'></span></span>").appendTo(link);
				}
			}

			if(current.outerHeight() > 100)
			{
				overlay.css({left:current.position().left + parseInt(current.css("margin-left"),10), top:current.position().top + parseInt(current.css("margin-top"),10)})
					   .css({display:'block','height':current.outerHeight(),'width':current.outerWidth()}).stop().animate({opacity:opa}, 400);
			}
			else
			{
				overlay.css({display:"none"});
			}

		}).on('mouseleave', elements, function(){

			if(overlay.length)
			{
				overlay.stop().animate({opacity:0}, 400);
			}
		});

    }








// -------------------------------------------------------------------------------------------
// Smooth scrooling when clicking on anchor links
// -------------------------------------------------------------------------------------------

	(function($)
	{
		$.fn.avia_smoothscroll = function(variables)
		{
			return this.each(function()
			{
				$(this).click(function() {

				   var newHash=this.hash;

				   if(newHash != '' && newHash != '#' && !$(this).is('.comment-reply-link, #cancel-comment-reply-link, .no-scroll'))
				   {
					   var container = $(this.hash);

					   if(container.length)
					   {
						   var target = container.offset().top,
							   oldLocation=window.location.href.replace(window.location.hash, ''),
							   newLocation=this,
							   duration=800,
							   easing='easeOutQuint';

						   // make sure it's the same location
						   if(oldLocation+newHash==newLocation)
						   {
						      // animate to target and set the hash to the window.location after the animation
						      $('html:not(:animated),body:not(:animated)').animate({ scrollTop: target }, duration, easing, function() {

						         // add new hash to the browser location
						         window.location.href=newLocation;
						      });

						      // cancel default click action
						      return false;
						   }
						}
					}
				});
			});
		};
	})(jQuery);





	// -------------------------------------------------------------------------------------------
	// small js fixes for pixel perfection :)
	// -------------------------------------------------------------------------------------------
	function avia_small_fixes(container)
	{
		if(!container) container = document;

		//make sure that iframes do resize correctly. uses css padding bottom iframe trick
		var iframes = jQuery('.avia-iframe-wrap iframe:not(.avia-slideshow iframe):not( iframe.no_resize)', container),
			adjust_iframes = function()
			{
				iframes.each(function(){

					var iframe = jQuery(this), parent = iframe.parent(), proportions = 56.25;

					if(this.width && this.height)
					{
						proportions = (100/ this.width) * this.height;
						parent.css({"padding-bottom":proportions+"%"});
					}
				});
			};

			adjust_iframes();
	}

	// -------------------------------------------------------------------------------------------
	// Ligthbox activation
	// -------------------------------------------------------------------------------------------

	(function($)
	{
		$.fn.avia_activate_lightbox = function(variables)
		{
			var defaults =
			{
				autolinkElements: 'a[rel^="prettyPhoto"], a[rel^="lightbox"], a[href$=jpg], a[href$=png], a[href$=gif], a[href$=jpeg], a[href$=".mov"] , a[href$=".swf"] , a[href*="vimeo.com"] , a[href*="youtube.com"] , a[href*="screenr.com"]'
			};

			var options 	= $.extend(defaults, variables),
				win		    = $(window),
				ww			= parseInt(win.width(),10) * 0.8, 	//controls the default lightbox width: 80% of the window size
				wh 			= (ww/16)*9;						//controls the default lightbox height (16:9 ration for videos. images are resized by the lightbox anyway)


			return this.each(function()
			{
				var elements = $(options.autolinkElements, this).not('.noLightbox, .noLightbox a, .fakeLightbox'),
					lastParent = "",
					counter = 0;

				elements.each(function()
				{
					var el = $(this),
						rel = el.data('rel'),
						parentPost = el.parents('.content:eq(0)'),
						group = 'auto_group';

					if(parentPost.get(0) != lastParent)
					{
						lastParent = parentPost.get(0);
						counter ++;
					}

					if(rel != "" && typeof rel != 'undefined')
					{
						el.attr('rel','lightbox['+rel+']');
					}

					if((el.attr('rel') == undefined || el.attr('rel') == '') && !el.hasClass('noLightbox'))
					{
						if(elements.length > 1)
						{
							el.attr('rel','lightbox['+group+counter+']');
						}
						else
						{
							el.attr('rel','lightbox');
						}
					}
				});

				if($.fn.prettyPhoto)
				elements.prettyPhoto({ social_tools:'',slideshow: 5000, deeplinking: false, overlay_gallery:false, default_width: ww, default_height: wh });
			});
		};
	})(jQuery);



// -------------------------------------------------------------------------------------------
// Avia Menu
// -------------------------------------------------------------------------------------------

(function($)
{
	$.fn.aviaMegamenu = function(variables)
	{
		var defaults =
		{
			modify_position:true,
			delay:300
		};

		var options = $.extend(defaults, variables);

		return this.each(function()
		{
			var left_menu	= $('html:first').is('.bottom_nav_header'),
				isMobile 	= 'ontouchstart' in document.documentElement,
				menu = $(this),
				menuItems = menu.find(">li"),
				megaItems = menuItems.find(">div").parent().css({overflow:'hidden'}),
				menuActive = menu.find('>.current-menu-item>a, >.current_page_item>a'),
				dropdownItems = menuItems.find(">ul").parent(),
				parentContainer = menu.parent(),
				mainMenuParent = menu.parents('.main_menu').eq(0),
				parentContainerWidth = parentContainer.width(),
				delayCheck = {},
				mega_open = [];

			if(!menuActive.length){ menu.find('.current-menu-ancestor:eq(0) a:eq(0), .current_page_ancestor:eq(0) a:eq(0)').parent().addClass('active-parent-item')}
			
			menuItems.on('click' ,'a', function()
			{
				if(this.href == window.location.href + "#" || this.href == window.location.href + "/#")
				return false;
			});
			
			menuItems.each(function()
			{
				var item = $(this),
					pos = item.position(),
					megaDiv = item.find("div:first").css({opacity:0, display:"none"}),
					normalDropdown = "";

				//check if we got a mega menu
				if(!megaDiv.length)
				{
					normalDropdown = item.find(">ul").css({display:"none"});
				}

				//if we got a mega menu or dropdown menu add the arrow beside the menu item
				if(megaDiv.length || normalDropdown.length)
				{
					var link = item.addClass('dropdown_ul_available').find('>a');
					link.append('<span class="dropdown_available"></span>');

					//is a mega menu main item doesnt have a link to click use the default cursor
					if(typeof link.attr('href') != 'string' || link.attr('href') == "#"){ link.css('cursor','default').click(function(){return false;}); }
				}


				//correct position of mega menus
				if(options.modify_position && megaDiv.length)
				{
					if(!left_menu)
					{	
						if(pos.left + megaDiv.width() < parentContainerWidth)
						{
							megaDiv.css({right: -megaDiv.outerWidth() + item.outerWidth()  });
							//item.css({position:'static'});
						}
						else if(pos.left + megaDiv.width() > parentContainerWidth)
						{
							megaDiv.css({right: -mainMenuParent.outerWidth() + (pos.left + item.outerWidth() ) }); 
						}
					}
					else
					{
						if(megaDiv.width() > pos.left + item.outerWidth())
						{
							megaDiv.css({left: (pos.left* -1)});
						}
						else if(pos.left + megaDiv.width() > parentContainerWidth)
						{
							megaDiv.css({left: (megaDiv.width() - pos.left) * -1 });
						}
					}
				}



			});


			function megaDivShow(i)
			{
				if(delayCheck[i] == true)
				{
					var item = megaItems.filter(':eq('+i+')').css({overflow:'visible'}).find("div:first"),
						link = megaItems.filter(':eq('+i+')').find("a:first");
						mega_open["check"+i] = true;

						item.stop().css('display','block').animate({opacity:1},300);

						if(item.length)
						{
							link.addClass('open-mega-a');
						}
				}
			}

			function megaDivHide (i)
			{
				if(delayCheck[i] == false)
				{
					megaItems.filter(':eq('+i+')').find(">a").removeClass('open-mega-a');

					var listItem = megaItems.filter(':eq('+i+')'),
						item = listItem.find("div:first");


					item.stop().css('display','block').animate({opacity:0},300, function()
					{
						$(this).css('display','none');
						listItem.css({overflow:'hidden'});
						mega_open["check"+i] = false;
					});
				}
			}

			if(isMobile)
			{
				megaItems.each(function(i){

					$(this).bind('click', function()
					{
						if(mega_open["check"+i] != true) return false;
					});
				});
			}


			//bind event for mega menu
			megaItems.each(function(i){

				$(this).hover(

					function()
					{
						delayCheck[i] = true;
						setTimeout(function(){megaDivShow(i); },options.delay);
					},

					function()
					{
						delayCheck[i] = false;
						setTimeout(function(){megaDivHide(i); },options.delay);
					}
				);
			});


			// bind events for dropdown menu
			dropdownItems.find('li').andSelf().each(function()
			{
				var currentItem = $(this),
					sublist = currentItem.find('ul:first'),
					showList = false;

				if(sublist.length)
				{
					sublist.css({display:'block', opacity:0, visibility:'hidden'});
					var currentLink = currentItem.find('>a');

					currentLink.bind('mouseenter', function()
					{
						sublist.stop().css({visibility:'visible'}).animate({opacity:1});
					});

					currentItem.bind('mouseleave', function()
					{
						sublist.stop().animate({opacity:0}, function()
						{
							sublist.css({visibility:'hidden'});
						});
					});

				}

			});

		});
	};
})(jQuery);




// -------------------------------------------------------------------------------------------
//Portfolio sorting
// -------------------------------------------------------------------------------------------

    $.fn.avia_iso_sort = function(options)
	{
		$.extend( $.Isotope.prototype, {
		  _customModeReset : function() {

		  	this.fitRows = {
		        x : 0,
		        y : 0,
		        height : 0
		      };

		   },
		  _customModeLayout : function( $elems ) {

		    var instance		= this,
		        containerWidth	= this.element.width(),
		        props			= this.fitRows,
		        margin			= this.element.is('.no_margin-container') ? 0 : (containerWidth / 100) * 6, //margin based on %
		        extraRange		= 2; // adds a little range for % based calculation error in some browsers
				
		      $elems.each( function() {
		        var $this = $(this),
		            atomW = $this.outerWidth() ,
		            atomH = $this.outerHeight(true);

		        if ( props.x !== 0 && atomW + props.x > containerWidth + extraRange ) {
		          // if this element cannot fit in the current row
		          props.x = 0;
		          props.y = props.height;
		        }

		     	//webkit gets blurry elements if position is a float value
		     	props.x = Math.round(props.x);
		     	props.y = Math.round(props.y);

		        // position the atom
		        instance._pushPosition( $this, props.x, props.y );

		        props.height = Math.max( props.y + atomH, props.height );
		        props.x += atomW + margin;


		      });

		  },
		  _customModeGetContainerSize : function() {

		  	return { height : this.fitRows.height };

		  },
		  _customModeResizeChanged : function() {

		  	return true;

		   }
		});



		return this.each(function()
		{
			var container		= $(this),
				portfolio_id	= container.data('portfolio-id'),
				parentContainer	= container.parents('.entry-content'),
				filter			= parentContainer.find('.sort_width_container[data-portfolio-id="' + portfolio_id + '"]').find('#js_sort_items').css({visibility:"visible", opacity:0}),
				links			= filter.find('a'),
				imgParent		= container.find('.grid-image'),
				isoActive		= false,
				items			= $('.post-entry', container);

			function applyIso()
			{
				container.addClass('isotope_activated').isotope({
					layoutMode : 'customMode', itemSelector : '.flex_column'
				}, function()
				{
					container.css({overflow:'visible'});
				});

				isoActive = true;
				setTimeout(function(){ parentContainer.addClass('avia_sortable_active'); }, 0);
			};

			links.bind('click',function()
			{
				var current		= $(this),
			  		selector	= current.data('filter');
					links.removeClass('active_sort');
					current.addClass('active_sort');

					parentContainer.find('.open_container .ajax_controlls .avia_close').trigger('click');
					//container.css({overflow:'hidden'})
					container.isotope({ layoutMode : 'customMode', itemSelector : '.flex_column' , filter: '.'+selector}, function()
					{
						container.css({overflow:'visible'});
					});

					return false;
			});

			// update columnWidth on window resize
			$(window).smartresize(function()
			{
			  	applyIso();
			});

			$.avia_utilities.preload({container: container, single_callback:  function()
				{
					filter.animate({opacity:1}, 400); applyIso();
					
					//call a second time to for the initial resizing
					setTimeout(function(){ applyIso(); });
					
					imgParent.css({height:'auto'}).each(function(i)
					{
						var currentLink = $(this);

						setTimeout(function()
						{
							currentLink.animate({opacity:1},1500);
						}, (100 * i));
					});
				}
			});

		});
	};




    //check if the browser supports element rotation
    function avia_header_size()
    {
        var win	            = $(window),
            header          = $('.fixed_header #header'),
            logo			= header.find('.logo img'),
            elements        = $('#header_main .container, .main_menu ul:first-child > li > a:not(.avia_mega_div a)'),
            el_height       = $(elements).filter(':first').height(),
            isMobile        = 'ontouchstart' in document.documentElement,
            scroll_top		= $('#scroll-top-link'),
            set_height      = function()
            {
                var st = win.scrollTop(), newH = 0;

                if(st < el_height/2)
                {
                    newH = el_height - st;
                    //header.removeClass('shadow');
                }
                else
                {
                    newH = el_height/2;
                    //header.addClass('shadow');
                }

                elements.css({height: newH + 'px', lineHeight: newH + 'px'});
            }

        	if(!header.length) return false;

            if(isMobile)
            {
                return false;
            }

            win.scroll(set_height);
            set_height();
    }


	//check if the browser supports element rotation
   function avia_scroll_top_fade()
   {
   		 var win 		= $(window),
   		 	 timeo = false,
   		 	 scroll_top = $('#scroll-top-link'),
   		 	 set_status = function()
             {
             	var st = win.scrollTop();

             	if(st < 500)
             	{
             		scroll_top.removeClass('avia_pop_class');
             	}
             	else if(!scroll_top.is('.avia_pop_class'))
             	{
             		scroll_top.addClass('avia_pop_class');
             	}
             };

   		 win.scroll(set_status);
         set_status();
	}




	$.AviaAjaxSearch  =  function(options)
	{
	   var defaults = {
            delay: 300,                //delay in ms until the user stops typing.
            minChars: 3,               //dont start searching before we got at least that much characters
            scope: 'body'

        }

        this.options = $.extend({}, defaults, options);
        this.scope   = $(this.options.scope);
        this.timer   = false;
        this.lastVal = "";

        this.bind_events();
	}


	$.AviaAjaxSearch.prototype =
    {
        bind_events: function()
        {
            this.scope.on('keyup', '#s' , $.proxy( this.try_search, this));
        },

        try_search: function(e)
        {
            clearTimeout(this.timer);

            //only execute search if chars are at least "minChars" and search differs from last one
            if(e.currentTarget.value.length >= this.options.minChars && this.lastVal != $.trim(e.currentTarget.value))
            {
                //wait at least "delay" miliseconds to execute ajax. if user types again during that time dont execute
                this.timer = setTimeout($.proxy( this.do_search, this, e), this.options.delay);
            }
        },

        do_search: function(e)
        {
            var obj          = this,
                currentField = $(e.currentTarget).attr( "autocomplete", "off" ),
                form         = currentField.parents('form:eq(0)'),
                results      = form.find('.ajax_search_response'),
                loading      = $('<div class="ajax_load"><span class="ajax_load_inner"></span></div>'),
                action 		 = form.attr('action'),
                values       = form.serialize();
                values      += '&action=avia_ajax_search';

           	//check if the form got get parameters applied and also apply them
           	if(action.indexOf('?') != -1)
           	{
           		action  = action.split('?');
           		values += "&" + action[1];
           	}

            if(!results.length) results = $('<div class="ajax_search_response"></div>').appendTo(form);

            //return if we already hit a no result and user is still typing
            if(results.find('.ajax_not_found').length && e.currentTarget.value.indexOf(this.lastVal) != -1) return;

            this.lastVal = e.currentTarget.value;

            $.ajax({
				url: avia_framework_globals.ajaxurl,
				type: "POST",
				data:values,
				beforeSend: function()
				{
					loading.insertAfter(currentField);
				},
				success: function(response)
				{
				    if(response == 0) response = "";
                    results.html(response);
				},
				complete: function()
				{
				    loading.remove();
				}
			});
        }
    }










	$.AviaTooltip  =  function(options)
	{
	   var defaults = {
            delay: 1500,                //delay in ms until the tooltip appears
            delayOut: 300,             //delay in ms when instant showing should stop
            "class": "avia-tooltip",     //tooltip classname for css styling and alignment
            scope: "body",             //area the tooltip should be applied to
            data:  "avia-tooltip",     //data attribute that contains the tooltip text
            attach:"body",          //either attach the tooltip to the "mouse" or to the "element" // todo: implement mouse, make sure that it doesnt overlap with screen borders
            event: 'mouseenter',       //mousenter and leave or click and leave
            position:'top'             //top or bottom
        }

        this.options = $.extend({}, defaults, options);
        this.body    = $('body');
        this.scope   = $(this.options.scope);
        this.tooltip = $('<div class="'+this.options['class']+' avia-tt"><span class="avia-arrow-wrap"><span class="avia-arrow"></span></span></div>');
        this.inner   = $('<div class="inner_tooltip"></div>').prependTo(this.tooltip);
        this.open    = false;
        this.timer   = false;
        this.active  = false;

        this.bind_events();
	}

	$.AviaTooltip.openTTs = [];
    $.AviaTooltip.prototype =
    {
        bind_events: function()
        {
            this.scope.on(this.options.event + ' mouseleave', '[data-'+this.options.data+']', $.proxy( this.start_countdown, this) );

            if(this.options.event != 'click')
            {
                this.scope.on('mouseleave', '[data-'+this.options.data+']', $.proxy( this.hide_tooltip, this) );
            }
            else
            {
                this.body.on('mousedown', $.proxy( this.hide_tooltip, this) );
            }
        },

        start_countdown: function(e)
        {
            clearTimeout(this.timer);

            if(e.type == this.options.event)
            {
                var delay = this.options.event == 'click' ? 0 : this.open ? 0 : this.options.delay;

                this.timer = setTimeout($.proxy( this.display_tooltip, this, e), delay);
            }
            else if(e.type == 'mouseleave')
            {
                this.timer = setTimeout($.proxy( this.stop_instant_open, this, e), this.options.delayOut);
            }
            e.preventDefault();
        },

        reset_countdown: function(e)
        {
            clearTimeout(this.timer);
            this.timer = false;
        },

        display_tooltip: function(e)
        {
            var element = $(e.currentTarget),
                text    = element.data(this.options.data),
                newTip  = element.data('avia-created-tooltip'),
                attach  = this.options.attach == 'element' ? element : this.body,
                offset  = this.options.attach == 'element' ? element.position() : element.offset();

            this.inner.html(text);
            newTip = typeof newTip != 'undefined' ? $.AviaTooltip.openTTs[newTip] : this.options.attach == 'element' ? this.tooltip.clone().insertAfter(attach) : this.tooltip.clone().appendTo(attach);
            this.open = true;
            this.active = newTip;

            if((newTip.is(':animated:visible') && e.type == 'click') || element.is('.'+this.options['class']) || element.parents('.'+this.options['class']).length != 0) return;


            var real_top  = offset.top - newTip.outerHeight(),
                real_left = (offset.left + (element.outerWidth() / 2)) - (newTip.outerWidth() / 2);

            if(this.options.position == 'bottom')
            {
                real_top = offset.top + element.outerHeight();
            }

            newTip.css({opacity:0, display:'block', top: real_top - 10, left: real_left }).stop().animate({top: real_top, opacity:1},200);
            newTip.find('input, textarea').focus();
            $.AviaTooltip.openTTs.push(newTip);
            element.data('avia-created-tooltip', $.AviaTooltip.openTTs.length - 1);

        },

        hide_tooltip: function(e)
        {
            var element = $(e.currentTarget) , newTip, animateTo;

            if(this.options.event == 'click')
            {
                element = $(e.target);

                if(!element.is('.'+this.options['class']) && element.parents('.'+this.options['class']).length == 0)
                {
                    if(this.active.length) { newTip = this.active; this.active = false;}
                }
            }
            else
            {
                newTip = element.data('avia-created-tooltip');
                newTip = typeof newTip != 'undefined' ? $.AviaTooltip.openTTs[newTip] : false;
            }

            if(newTip)
            {
                animateTo = parseInt(newTip.css('top'),10) - 10;
                newTip.animate({top: animateTo, opacity:0},200, function()
                {
                    newTip.css({display:'none'});

                });
            }
        },

        stop_instant_open: function(e)
        {
            this.open = false;
        }
    }


})( jQuery );



(function($){

  //variable for storing the menu count when no ID is present
  var menuCount = 0;

  //plugin code
  $.fn.mobileMenu = function(options){

    //plugin's default options
    var settings = {
      switchWidth: 768,
      topOptionText: 'Select a page',
      indentString: '&nbsp;&nbsp;&nbsp;'
    };


    //function to check if selector matches a list
    function isList($this){
      return $this.is('ul, ol');
    }


    //function to decide if mobile or not
    function isMobile(){
      return ($(window).width() < settings.switchWidth);
    }


    //check if dropdown exists for the current element
    function menuExists($this){

      //if the list has an ID, use it to give the menu an ID
      if($this.attr('id')){
        return ($('#mobileMenu_'+$this.attr('id')).length > 0);
      }

      //otherwise, give the list and select elements a generated ID
      else {
        menuCount++;
        $this.attr('id', 'mm'+menuCount);
        return ($('#mobileMenu_mm'+menuCount).length > 0);
      }
    }


    //change page on mobile menu selection
    function goToPage($this){
      if($this.val() !== null){document.location.href = $this.val()}
    }


    //show the mobile menu
    function showMenu($this){
      $this.css('display', 'none');
      $('#mobileMenu_'+$this.attr('id')).show();
    }


    //hide the mobile menu
    function hideMenu($this){
      $this.css('display', '');
      $('#mobileMenu_'+$this.attr('id')).hide();
    }


    //create the mobile menu
    function createMenu($this){
      if(isList($this)){

        //generate select element as a string to append via jQuery
        var selectString = '<select id="mobileMenu_'+$this.attr('id')+'" class="mobileMenu">';

        //create first option (no value)
        selectString += '<option value="">'+settings.topOptionText+'</option>';

        //loop through list items
        var active_found = false;

        $this.find('li').each(function(){

          //when sub-item, indent
          var levelStr = '', disabled = '', selected = '', skip = false, current = $(this);
          var len = current.parents('ul, ol').length;
          for(i=1;i<len;i++){levelStr += settings.indentString;}

          //get url and text for option
          var link 		= current.find('a:first-child').attr('href');
          var the_clone = current.clone();

		  if(!active_found)
		  {
	          if(the_clone.is('.current-menu-item') || the_clone.is('.current_page_item'))
	          {
				selected = ' selected = "selected"';
				active_found = true;
	          }
          }

          if(the_clone.find('.avia_mega_text_block').length && the_clone.find('li:not(.avia_mega_text_block)').length == 0)
          {
         	skip = true;
          }

          if(the_clone.is('.noMobile'))
		  {
		  	skip = true;
		  }

		  if(the_clone.is('.disabled'))
		  {
			disabled = 'disabled="disabled"';
		  }

          if(!skip)
          {
	          var element 	= the_clone.children('ul, ol, .avia_mega_div').remove().end();
	          var text 		= levelStr + element.text();

	         if($.trim( element.text() ) == "")
	         {
	         	skip = true;
	         }

	         if(element.find('.mega_menu_title').length > 0 || link == "" || link == '#')
	         {
	         	disabled = 'disabled="disabled"';
	         }

	         if(element.is('.avia_mega_text_block'))
	         {
	         	skip = true;
	         }

	          //add option
	          if(!skip) selectString += '<option '+disabled+selected+' value="'+link+'">'+text+'</option>';
          }
        });

        selectString += '</select>';

        //append select element to ul/ol's container
        $this.parent().append(selectString);

        //add change event handler for mobile menu
        $('#mobileMenu_'+$this.attr('id')).change(function(){
          goToPage($(this));
        });

        //hide current menu, show mobile menu
        showMenu($this);
      } else {
        alert('mobileMenu will only work with UL or OL elements!');
      }
    }


    //plugin functionality
    function run($this){

      //menu doesn't exist
      if(isMobile() && !menuExists($this)){
        createMenu($this);
      }

      //menu already exists
      else if(isMobile() && menuExists($this)){
        showMenu($this);
      }

      //not mobile browser
      else if(!isMobile() && menuExists($this)){
        hideMenu($this);
      }

    }

    //run plugin on each matched ul/ol
    //maintain chainability by returning "this"
    return this.each(function() {

      //override the default settings if user provides some
      if(options){$.extend(settings, options);}

      //cache "this"
      var $this = $(this);

      //bind event to browser resize
      $(window).resize(function(){run($this);});

      //run plugin
      run($this);

    });

  };

})(jQuery);


/**
 * Isotope v1.5.25
 * An exquisite jQuery plugin for magical layouts
 * http://isotope.metafizzy.co
 *
 * Commercial use requires one-time license fee
 * http://metafizzy.co/#licenses
 *
 * Copyright 2012 David DeSandro / Metafizzy
 */
(function(a,b,c){"use strict";var d=a.document,e=a.Modernizr,f=function(a){return a.charAt(0).toUpperCase()+a.slice(1)},g="Moz Webkit O Ms".split(" "),h=function(a){var b=d.documentElement.style,c;if(typeof b[a]=="string")return a;a=f(a);for(var e=0,h=g.length;e<h;e++){c=g[e]+a;if(typeof b[c]=="string")return c}},i=h("transform"),j=h("transitionProperty"),k={csstransforms:function(){return!!i},csstransforms3d:function(){var a=!!h("perspective");if(a){var c=" -o- -moz- -ms- -webkit- -khtml- ".split(" "),d="@media ("+c.join("transform-3d),(")+"modernizr)",e=b("<style>"+d+"{#modernizr{height:3px}}"+"</style>").appendTo("head"),f=b('<div id="modernizr" />').appendTo("html");a=f.height()===3,f.remove(),e.remove()}return a},csstransitions:function(){return!!j}},l;if(e)for(l in k)e.hasOwnProperty(l)||e.addTest(l,k[l]);else{e=a.Modernizr={_version:"1.6ish: miniModernizr for Isotope"};var m=" ",n;for(l in k)n=k[l](),e[l]=n,m+=" "+(n?"":"no-")+l;b("html").addClass(m)}if(e.csstransforms){var o=e.csstransforms3d?{translate:function(a){return"translate3d("+a[0]+"px, "+a[1]+"px, 0) "},scale:function(a){return"scale3d("+a+", "+a+", 1) "}}:{translate:function(a){return"translate("+a[0]+"px, "+a[1]+"px) "},scale:function(a){return"scale("+a+") "}},p=function(a,c,d){var e=b.data(a,"isoTransform")||{},f={},g,h={},j;f[c]=d,b.extend(e,f);for(g in e)j=e[g],h[g]=o[g](j);var k=h.translate||"",l=h.scale||"",m=k+l;b.data(a,"isoTransform",e),a.style[i]=m};b.cssNumber.scale=!0,b.cssHooks.scale={set:function(a,b){p(a,"scale",b)},get:function(a,c){var d=b.data(a,"isoTransform");return d&&d.scale?d.scale:1}},b.fx.step.scale=function(a){b.cssHooks.scale.set(a.elem,a.now+a.unit)},b.cssNumber.translate=!0,b.cssHooks.translate={set:function(a,b){p(a,"translate",b)},get:function(a,c){var d=b.data(a,"isoTransform");return d&&d.translate?d.translate:[0,0]}}}var q,r;e.csstransitions&&(q={WebkitTransitionProperty:"webkitTransitionEnd",MozTransitionProperty:"transitionend",OTransitionProperty:"oTransitionEnd otransitionend",transitionProperty:"transitionend"}[j],r=h("transitionDuration"));var s=b.event,t=b.event.handle?"handle":"dispatch",u;s.special.smartresize={setup:function(){b(this).bind("resize",s.special.smartresize.handler)},teardown:function(){b(this).unbind("resize",s.special.smartresize.handler)},handler:function(a,b){var c=this,d=arguments;a.type="smartresize",u&&clearTimeout(u),u=setTimeout(function(){s[t].apply(c,d)},b==="execAsap"?0:100)}},b.fn.smartresize=function(a){return a?this.bind("smartresize",a):this.trigger("smartresize",["execAsap"])},b.Isotope=function(a,c,d){this.element=b(c),this._create(a),this._init(d)};var v=["width","height"],w=b(a);b.Isotope.settings={resizable:!0,layoutMode:"masonry",containerClass:"isotope",itemClass:"isotope-item",hiddenClass:"isotope-hidden",hiddenStyle:{opacity:0,scale:.001},visibleStyle:{opacity:1,scale:1},containerStyle:{position:"relative",overflow:"hidden"},animationEngine:"best-available",animationOptions:{queue:!1,duration:800},sortBy:"original-order",sortAscending:!0,resizesContainer:!0,transformsEnabled:!0,itemPositionDataEnabled:!1},b.Isotope.prototype={_create:function(a){this.options=b.extend({},b.Isotope.settings,a),this.styleQueue=[],this.elemCount=0;var c=this.element[0].style;this.originalStyle={};var d=v.slice(0);for(var e in this.options.containerStyle)d.push(e);for(var f=0,g=d.length;f<g;f++)e=d[f],this.originalStyle[e]=c[e]||"";this.element.css(this.options.containerStyle),this._updateAnimationEngine(),this._updateUsingTransforms();var h={"original-order":function(a,b){return b.elemCount++,b.elemCount},random:function(){return Math.random()}};this.options.getSortData=b.extend(this.options.getSortData,h),this.reloadItems(),this.offset={left:parseInt(this.element.css("padding-left")||0,10),top:parseInt(this.element.css("padding-top")||0,10)};var i=this;setTimeout(function(){i.element.addClass(i.options.containerClass)},0),this.options.resizable&&w.bind("smartresize.isotope",function(){i.resize()}),this.element.delegate("."+this.options.hiddenClass,"click",function(){return!1})},_getAtoms:function(a){var b=this.options.itemSelector,c=b?a.filter(b).add(a.find(b)):a,d={position:"absolute"};return c=c.filter(function(a,b){return b.nodeType===1}),this.usingTransforms&&(d.left=0,d.top=0),c.css(d).addClass(this.options.itemClass),this.updateSortData(c,!0),c},_init:function(a){this.$filteredAtoms=this._filter(this.$allAtoms),this._sort(),this.reLayout(a)},option:function(a){if(b.isPlainObject(a)){this.options=b.extend(!0,this.options,a);var c;for(var d in a)c="_update"+f(d),this[c]&&this[c]()}},_updateAnimationEngine:function(){var a=this.options.animationEngine.toLowerCase().replace(/[ _\-]/g,""),b;switch(a){case"css":case"none":b=!1;break;case"jquery":b=!0;break;default:b=!e.csstransitions}this.isUsingJQueryAnimation=b,this._updateUsingTransforms()},_updateTransformsEnabled:function(){this._updateUsingTransforms()},_updateUsingTransforms:function(){var a=this.usingTransforms=this.options.transformsEnabled&&e.csstransforms&&e.csstransitions&&!this.isUsingJQueryAnimation;a||(delete this.options.hiddenStyle.scale,delete this.options.visibleStyle.scale),this.getPositionStyles=a?this._translate:this._positionAbs},_filter:function(a){var b=this.options.filter===""?"*":this.options.filter;if(!b)return a;var c=this.options.hiddenClass,d="."+c,e=a.filter(d),f=e;if(b!=="*"){f=e.filter(b);var g=a.not(d).not(b).addClass(c);this.styleQueue.push({$el:g,style:this.options.hiddenStyle})}return this.styleQueue.push({$el:f,style:this.options.visibleStyle}),f.removeClass(c),a.filter(b)},updateSortData:function(a,c){var d=this,e=this.options.getSortData,f,g;a.each(function(){f=b(this),g={};for(var a in e)!c&&a==="original-order"?g[a]=b.data(this,"isotope-sort-data")[a]:g[a]=e[a](f,d);b.data(this,"isotope-sort-data",g)})},_sort:function(){var a=this.options.sortBy,b=this._getSorter,c=this.options.sortAscending?1:-1,d=function(d,e){var f=b(d,a),g=b(e,a);return f===g&&a!=="original-order"&&(f=b(d,"original-order"),g=b(e,"original-order")),(f>g?1:f<g?-1:0)*c};this.$filteredAtoms.sort(d)},_getSorter:function(a,c){return b.data(a,"isotope-sort-data")[c]},_translate:function(a,b){return{translate:[a,b]}},_positionAbs:function(a,b){return{left:a,top:b}},_pushPosition:function(a,b,c){b=Math.round(b+this.offset.left),c=Math.round(c+this.offset.top);var d=this.getPositionStyles(b,c);this.styleQueue.push({$el:a,style:d}),this.options.itemPositionDataEnabled&&a.data("isotope-item-position",{x:b,y:c})},layout:function(a,b){var c=this.options.layoutMode;this["_"+c+"Layout"](a);if(this.options.resizesContainer){var d=this["_"+c+"GetContainerSize"]();this.styleQueue.push({$el:this.element,style:d})}this._processStyleQueue(a,b),this.isLaidOut=!0},_processStyleQueue:function(a,c){var d=this.isLaidOut?this.isUsingJQueryAnimation?"animate":"css":"css",f=this.options.animationOptions,g=this.options.onLayout,h,i,j,k;i=function(a,b){b.$el[d](b.style,f)};if(this._isInserting&&this.isUsingJQueryAnimation)i=function(a,b){h=b.$el.hasClass("no-transition")?"css":d,b.$el[h](b.style,f)};else if(c||g||f.complete){var l=!1,m=[c,g,f.complete],n=this;j=!0,k=function(){if(l)return;var b;for(var c=0,d=m.length;c<d;c++)b=m[c],typeof b=="function"&&b.call(n.element,a,n);l=!0};if(this.isUsingJQueryAnimation&&d==="animate")f.complete=k,j=!1;else if(e.csstransitions){var o=0,p=this.styleQueue[0],s=p&&p.$el,t;while(!s||!s.length){t=this.styleQueue[o++];if(!t)return;s=t.$el}var u=parseFloat(getComputedStyle(s[0])[r]);u>0&&(i=function(a,b){b.$el[d](b.style,f).one(q,k)},j=!1)}}b.each(this.styleQueue,i),j&&k(),this.styleQueue=[]},resize:function(){this["_"+this.options.layoutMode+"ResizeChanged"]()&&this.reLayout()},reLayout:function(a){this["_"+this.options.layoutMode+"Reset"](),this.layout(this.$filteredAtoms,a)},addItems:function(a,b){var c=this._getAtoms(a);this.$allAtoms=this.$allAtoms.add(c),b&&b(c)},insert:function(a,b){this.element.append(a);var c=this;this.addItems(a,function(a){var d=c._filter(a);c._addHideAppended(d),c._sort(),c.reLayout(),c._revealAppended(d,b)})},appended:function(a,b){var c=this;this.addItems(a,function(a){c._addHideAppended(a),c.layout(a),c._revealAppended(a,b)})},_addHideAppended:function(a){this.$filteredAtoms=this.$filteredAtoms.add(a),a.addClass("no-transition"),this._isInserting=!0,this.styleQueue.push({$el:a,style:this.options.hiddenStyle})},_revealAppended:function(a,b){var c=this;setTimeout(function(){a.removeClass("no-transition"),c.styleQueue.push({$el:a,style:c.options.visibleStyle}),c._isInserting=!1,c._processStyleQueue(a,b)},10)},reloadItems:function(){this.$allAtoms=this._getAtoms(this.element.children())},remove:function(a,b){this.$allAtoms=this.$allAtoms.not(a),this.$filteredAtoms=this.$filteredAtoms.not(a);var c=this,d=function(){a.remove(),b&&b.call(c.element)};a.filter(":not(."+this.options.hiddenClass+")").length?(this.styleQueue.push({$el:a,style:this.options.hiddenStyle}),this._sort(),this.reLayout(d)):d()},shuffle:function(a){this.updateSortData(this.$allAtoms),this.options.sortBy="random",this._sort(),this.reLayout(a)},destroy:function(){var a=this.usingTransforms,b=this.options;this.$allAtoms.removeClass(b.hiddenClass+" "+b.itemClass).each(function(){var b=this.style;b.position="",b.top="",b.left="",b.opacity="",a&&(b[i]="")});var c=this.element[0].style;for(var d in this.originalStyle)c[d]=this.originalStyle[d];this.element.unbind(".isotope").undelegate("."+b.hiddenClass,"click").removeClass(b.containerClass).removeData("isotope"),w.unbind(".isotope")},_getSegments:function(a){var b=this.options.layoutMode,c=a?"rowHeight":"columnWidth",d=a?"height":"width",e=a?"rows":"cols",g=this.element[d](),h,i=this.options[b]&&this.options[b][c]||this.$filteredAtoms["outer"+f(d)](!0)||g;h=Math.floor(g/i),h=Math.max(h,1),this[b][e]=h,this[b][c]=i},_checkIfSegmentsChanged:function(a){var b=this.options.layoutMode,c=a?"rows":"cols",d=this[b][c];return this._getSegments(a),this[b][c]!==d},_masonryReset:function(){this.masonry={},this._getSegments();var a=this.masonry.cols;this.masonry.colYs=[];while(a--)this.masonry.colYs.push(0)},_masonryLayout:function(a){var c=this,d=c.masonry;a.each(function(){var a=b(this),e=Math.ceil(a.outerWidth(!0)/d.columnWidth);e=Math.min(e,d.cols);if(e===1)c._masonryPlaceBrick(a,d.colYs);else{var f=d.cols+1-e,g=[],h,i;for(i=0;i<f;i++)h=d.colYs.slice(i,i+e),g[i]=Math.max.apply(Math,h);c._masonryPlaceBrick(a,g)}})},_masonryPlaceBrick:function(a,b){var c=Math.min.apply(Math,b),d=0;for(var e=0,f=b.length;e<f;e++)if(b[e]===c){d=e;break}var g=this.masonry.columnWidth*d,h=c;this._pushPosition(a,g,h);var i=c+a.outerHeight(!0),j=this.masonry.cols+1-f;for(e=0;e<j;e++)this.masonry.colYs[d+e]=i},_masonryGetContainerSize:function(){var a=Math.max.apply(Math,this.masonry.colYs);return{height:a}},_masonryResizeChanged:function(){return this._checkIfSegmentsChanged()},_fitRowsReset:function(){this.fitRows={x:0,y:0,height:0}},_fitRowsLayout:function(a){var c=this,d=this.element.width(),e=this.fitRows;a.each(function(){var a=b(this),f=a.outerWidth(!0),g=a.outerHeight(!0);e.x!==0&&f+e.x>d&&(e.x=0,e.y=e.height),c._pushPosition(a,e.x,e.y),e.height=Math.max(e.y+g,e.height),e.x+=f})},_fitRowsGetContainerSize:function(){return{height:this.fitRows.height}},_fitRowsResizeChanged:function(){return!0},_cellsByRowReset:function(){this.cellsByRow={index:0},this._getSegments(),this._getSegments(!0)},_cellsByRowLayout:function(a){var c=this,d=this.cellsByRow;a.each(function(){var a=b(this),e=d.index%d.cols,f=Math.floor(d.index/d.cols),g=(e+.5)*d.columnWidth-a.outerWidth(!0)/2,h=(f+.5)*d.rowHeight-a.outerHeight(!0)/2;c._pushPosition(a,g,h),d.index++})},_cellsByRowGetContainerSize:function(){return{height:Math.ceil(this.$filteredAtoms.length/this.cellsByRow.cols)*this.cellsByRow.rowHeight+this.offset.top}},_cellsByRowResizeChanged:function(){return this._checkIfSegmentsChanged()},_straightDownReset:function(){this.straightDown={y:0}},_straightDownLayout:function(a){var c=this;a.each(function(a){var d=b(this);c._pushPosition(d,0,c.straightDown.y),c.straightDown.y+=d.outerHeight(!0)})},_straightDownGetContainerSize:function(){return{height:this.straightDown.y}},_straightDownResizeChanged:function(){return!0},_masonryHorizontalReset:function(){this.masonryHorizontal={},this._getSegments(!0);var a=this.masonryHorizontal.rows;this.masonryHorizontal.rowXs=[];while(a--)this.masonryHorizontal.rowXs.push(0)},_masonryHorizontalLayout:function(a){var c=this,d=c.masonryHorizontal;a.each(function(){var a=b(this),e=Math.ceil(a.outerHeight(!0)/d.rowHeight);e=Math.min(e,d.rows);if(e===1)c._masonryHorizontalPlaceBrick(a,d.rowXs);else{var f=d.rows+1-e,g=[],h,i;for(i=0;i<f;i++)h=d.rowXs.slice(i,i+e),g[i]=Math.max.apply(Math,h);c._masonryHorizontalPlaceBrick(a,g)}})},_masonryHorizontalPlaceBrick:function(a,b){var c=Math.min.apply(Math,b),d=0;for(var e=0,f=b.length;e<f;e++)if(b[e]===c){d=e;break}var g=c,h=this.masonryHorizontal.rowHeight*d;this._pushPosition(a,g,h);var i=c+a.outerWidth(!0),j=this.masonryHorizontal.rows+1-f;for(e=0;e<j;e++)this.masonryHorizontal.rowXs[d+e]=i},_masonryHorizontalGetContainerSize:function(){var a=Math.max.apply(Math,this.masonryHorizontal.rowXs);return{width:a}},_masonryHorizontalResizeChanged:function(){return this._checkIfSegmentsChanged(!0)},_fitColumnsReset:function(){this.fitColumns={x:0,y:0,width:0}},_fitColumnsLayout:function(a){var c=this,d=this.element.height(),e=this.fitColumns;a.each(function(){var a=b(this),f=a.outerWidth(!0),g=a.outerHeight(!0);e.y!==0&&g+e.y>d&&(e.x=e.width,e.y=0),c._pushPosition(a,e.x,e.y),e.width=Math.max(e.x+f,e.width),e.y+=g})},_fitColumnsGetContainerSize:function(){return{width:this.fitColumns.width}},_fitColumnsResizeChanged:function(){return!0},_cellsByColumnReset:function(){this.cellsByColumn={index:0},this._getSegments(),this._getSegments(!0)},_cellsByColumnLayout:function(a){var c=this,d=this.cellsByColumn;a.each(function(){var a=b(this),e=Math.floor(d.index/d.rows),f=d.index%d.rows,g=(e+.5)*d.columnWidth-a.outerWidth(!0)/2,h=(f+.5)*d.rowHeight-a.outerHeight(!0)/2;c._pushPosition(a,g,h),d.index++})},_cellsByColumnGetContainerSize:function(){return{width:Math.ceil(this.$filteredAtoms.length/this.cellsByColumn.rows)*this.cellsByColumn.columnWidth}},_cellsByColumnResizeChanged:function(){return this._checkIfSegmentsChanged(!0)},_straightAcrossReset:function(){this.straightAcross={x:0}},_straightAcrossLayout:function(a){var c=this;a.each(function(a){var d=b(this);c._pushPosition(d,c.straightAcross.x,0),c.straightAcross.x+=d.outerWidth(!0)})},_straightAcrossGetContainerSize:function(){return{width:this.straightAcross.x}},_straightAcrossResizeChanged:function(){return!0}},b.fn.imagesLoaded=function(a){function h(){a.call(c,d)}function i(a){var c=a.target;c.src!==f&&b.inArray(c,g)===-1&&(g.push(c),--e<=0&&(setTimeout(h),d.unbind(".imagesLoaded",i)))}var c=this,d=c.find("img").add(c.filter("img")),e=d.length,f="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==",g=[];return e||h(),d.bind("load.imagesLoaded error.imagesLoaded",i).each(function(){var a=this.src;this.src=f,this.src=a}),c};var x=function(b){a.console&&a.console.error(b)};b.fn.isotope=function(a,c){if(typeof a=="string"){var d=Array.prototype.slice.call(arguments,1);this.each(function(){var c=b.data(this,"isotope");if(!c){x("cannot call methods on isotope prior to initialization; attempted to call method '"+a+"'");return}if(!b.isFunction(c[a])||a.charAt(0)==="_"){x("no such method '"+a+"' for isotope instance");return}c[a].apply(c,d)})}else this.each(function(){var d=b.data(this,"isotope");d?(d.option(a),d._init(c)):b.data(this,"isotope",new b.Isotope(a,this,c))});return this}})(window,jQuery);



/*
jQuery Waypoints - v2.0.2
Copyright (c) 2011-2013 Caleb Troughton
Dual licensed under the MIT license and GPL license.
https://github.com/imakewebthings/jquery-waypoints/blob/master/licenses.txt
*/
(function(){var t=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++){if(e in this&&this[e]===t)return e}return-1},e=[].slice;(function(t,e){if(typeof define==="function"&&define.amd){return define("waypoints",["jquery"],function(n){return e(n,t)})}else{return e(t.jQuery,t)}})(this,function(n,r){var i,o,l,s,f,u,a,c,h,d,p,y,v,w,g,m;i=n(r);c=t.call(r,"ontouchstart")>=0;s={horizontal:{},vertical:{}};f=1;a={};u="waypoints-context-id";p="resize.waypoints";y="scroll.waypoints";v=1;w="waypoints-waypoint-ids";g="waypoint";m="waypoints";o=function(){function t(t){var e=this;this.$element=t;this.element=t[0];this.didResize=false;this.didScroll=false;this.id="context"+f++;this.oldScroll={x:t.scrollLeft(),y:t.scrollTop()};this.waypoints={horizontal:{},vertical:{}};t.data(u,this.id);a[this.id]=this;t.bind(y,function(){var t;if(!(e.didScroll||c)){e.didScroll=true;t=function(){e.doScroll();return e.didScroll=false};return r.setTimeout(t,n[m].settings.scrollThrottle)}});t.bind(p,function(){var t;if(!e.didResize){e.didResize=true;t=function(){n[m]("refresh");return e.didResize=false};return r.setTimeout(t,n[m].settings.resizeThrottle)}})}t.prototype.doScroll=function(){var t,e=this;t={horizontal:{newScroll:this.$element.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.$element.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};if(c&&(!t.vertical.oldScroll||!t.vertical.newScroll)){n[m]("refresh")}n.each(t,function(t,r){var i,o,l;l=[];o=r.newScroll>r.oldScroll;i=o?r.forward:r.backward;n.each(e.waypoints[t],function(t,e){var n,i;if(r.oldScroll<(n=e.offset)&&n<=r.newScroll){return l.push(e)}else if(r.newScroll<(i=e.offset)&&i<=r.oldScroll){return l.push(e)}});l.sort(function(t,e){return t.offset-e.offset});if(!o){l.reverse()}return n.each(l,function(t,e){if(e.options.continuous||t===l.length-1){return e.trigger([i])}})});return this.oldScroll={x:t.horizontal.newScroll,y:t.vertical.newScroll}};t.prototype.refresh=function(){var t,e,r,i=this;r=n.isWindow(this.element);e=this.$element.offset();this.doScroll();t={horizontal:{contextOffset:r?0:e.left,contextScroll:r?0:this.oldScroll.x,contextDimension:this.$element.width(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:r?0:e.top,contextScroll:r?0:this.oldScroll.y,contextDimension:r?n[m]("viewportHeight"):this.$element.height(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};return n.each(t,function(t,e){return n.each(i.waypoints[t],function(t,r){var i,o,l,s,f;i=r.options.offset;l=r.offset;o=n.isWindow(r.element)?0:r.$element.offset()[e.offsetProp];if(n.isFunction(i)){i=i.apply(r.element)}else if(typeof i==="string"){i=parseFloat(i);if(r.options.offset.indexOf("%")>-1){i=Math.ceil(e.contextDimension*i/100)}}r.offset=o-e.contextOffset+e.contextScroll-i;if(r.options.onlyOnScroll&&l!=null||!r.enabled){return}if(l!==null&&l<(s=e.oldScroll)&&s<=r.offset){return r.trigger([e.backward])}else if(l!==null&&l>(f=e.oldScroll)&&f>=r.offset){return r.trigger([e.forward])}else if(l===null&&e.oldScroll>=r.offset){return r.trigger([e.forward])}})})};t.prototype.checkEmpty=function(){if(n.isEmptyObject(this.waypoints.horizontal)&&n.isEmptyObject(this.waypoints.vertical)){this.$element.unbind([p,y].join(" "));return delete a[this.id]}};return t}();l=function(){function t(t,e,r){var i,o;r=n.extend({},n.fn[g].defaults,r);if(r.offset==="bottom-in-view"){r.offset=function(){var t;t=n[m]("viewportHeight");if(!n.isWindow(e.element)){t=e.$element.height()}return t-n(this).outerHeight()}}this.$element=t;this.element=t[0];this.axis=r.horizontal?"horizontal":"vertical";this.callback=r.handler;this.context=e;this.enabled=r.enabled;this.id="waypoints"+v++;this.offset=null;this.options=r;e.waypoints[this.axis][this.id]=this;s[this.axis][this.id]=this;i=(o=t.data(w))!=null?o:[];i.push(this.id);t.data(w,i)}t.prototype.trigger=function(t){if(!this.enabled){return}if(this.callback!=null){this.callback.apply(this.element,t)}if(this.options.triggerOnce){return this.destroy()}};t.prototype.disable=function(){return this.enabled=false};t.prototype.enable=function(){this.context.refresh();return this.enabled=true};t.prototype.destroy=function(){delete s[this.axis][this.id];delete this.context.waypoints[this.axis][this.id];return this.context.checkEmpty()};t.getWaypointsByElement=function(t){var e,r;r=n(t).data(w);if(!r){return[]}e=n.extend({},s.horizontal,s.vertical);return n.map(r,function(t){return e[t]})};return t}();d={init:function(t,e){var r;if(e==null){e={}}if((r=e.handler)==null){e.handler=t}this.each(function(){var t,r,i,s;t=n(this);i=(s=e.context)!=null?s:n.fn[g].defaults.context;if(!n.isWindow(i)){i=t.closest(i)}i=n(i);r=a[i.data(u)];if(!r){r=new o(i)}return new l(t,r,e)});n[m]("refresh");return this},disable:function(){return d._invoke(this,"disable")},enable:function(){return d._invoke(this,"enable")},destroy:function(){return d._invoke(this,"destroy")},prev:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e>0){return t.push(n[e-1])}})},next:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e<n.length-1){return t.push(n[e+1])}})},_traverse:function(t,e,i){var o,l;if(t==null){t="vertical"}if(e==null){e=r}l=h.aggregate(e);o=[];this.each(function(){var e;e=n.inArray(this,l[t]);return i(o,e,l[t])});return this.pushStack(o)},_invoke:function(t,e){t.each(function(){var t;t=l.getWaypointsByElement(this);return n.each(t,function(t,n){n[e]();return true})});return this}};n.fn[g]=function(){var t,r;r=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(d[r]){return d[r].apply(this,t)}else if(n.isFunction(r)){return d.init.apply(this,arguments)}else if(n.isPlainObject(r)){return d.init.apply(this,[null,r])}else if(!r){return n.error("jQuery Waypoints needs a callback function or handler option.")}else{return n.error("The "+r+" method does not exist in jQuery Waypoints.")}};n.fn[g].defaults={context:r,continuous:true,enabled:true,horizontal:false,offset:0,triggerOnce:false};h={refresh:function(){return n.each(a,function(t,e){return e.refresh()})},viewportHeight:function(){var t;return(t=r.innerHeight)!=null?t:i.height()},aggregate:function(t){var e,r,i;e=s;if(t){e=(i=a[n(t).data(u)])!=null?i.waypoints:void 0}if(!e){return[]}r={horizontal:[],vertical:[]};n.each(r,function(t,i){n.each(e[t],function(t,e){return i.push(e)});i.sort(function(t,e){return t.offset-e.offset});r[t]=n.map(i,function(t){return t.element});return r[t]=n.unique(r[t])});return r},above:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset<=t.oldScroll.y})},below:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset>t.oldScroll.y})},left:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset<=t.oldScroll.x})},right:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset>t.oldScroll.x})},enable:function(){return h._invoke("enable")},disable:function(){return h._invoke("disable")},destroy:function(){return h._invoke("destroy")},extendFn:function(t,e){return d[t]=e},_invoke:function(t){var e;e=n.extend({},s.vertical,s.horizontal);return n.each(e,function(e,n){n[t]();return true})},_filter:function(t,e,r){var i,o;i=a[n(t).data(u)];if(!i){return[]}o=[];n.each(i.waypoints[e],function(t,e){if(r(i,e)){return o.push(e)}});o.sort(function(t,e){return t.offset-e.offset});return n.map(o,function(t){return t.element})}};n[m]=function(){var t,n;n=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(h[n]){return h[n].apply(null,t)}else{return h.aggregate.call(null,n)}};n[m].settings={resizeThrottle:100,scrollThrottle:30};return i.load(function(){return n[m]("refresh")})})}).call(this);