<?php 
global $avia_config;


	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */	
	 get_header();
	 
	 $results = avia_which_archive();	
	 echo avia_title(array('title' => $results )); 
	 ?>
		
		<div class='container_wrap main_color <?php avia_layout_class( 'main' ); ?>'>
		
			<div class='container'>
				
				<div class='content template-search <?php avia_layout_class( 'content' ); ?> units'>
				
				<div class='page-heading-container clearfix'>
				<?php
				echo "<h4>".__('New Search','avia_framework')."</h4>";
				echo "<p>".__('If you are not happy with the results bellow please do another search','avia_framework')."</p>";
				
                get_search_form();
                echo "<span class='author-extra-border'></span>";
				
				?>
				</div>
				
				
				<?php
				if(!empty($_GET['s']))
				{
	                echo "<h4 class='extra-mini-title widgettitle'>{$results}</h4>";
					
					/* Run the loop to output the posts.
					* If you want to overload this in a child theme then include a file
					* called loop-search.php and that will be used instead.
					*/
					$more = 0;
					get_template_part( 'includes/loop', 'search' );
					
				}
				
				?>
				
				
				<!--end content-->
				</div>
				
				<?php 

				//get the sidebar
				$avia_config['currently_viewing'] = 'page';
				
				get_sidebar();
				
				?>
				
			</div><!--end container-->

	


<?php get_footer(); ?>