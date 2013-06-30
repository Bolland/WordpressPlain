<?php
	global $avia_config, $more;

	/*
	* get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	*/
	get_header();


	$description = is_tag() ? tag_description() : category_description();
	echo avia_title(array('title' => avia_which_archive(), 'subtitle' => $description, 'link'=>false));

	$author_id    = get_query_var( 'author' );
	$name         = get_the_author_meta('display_name', $author_id);
	$heading_s    = __("Entries by",'avia_framework') ." ".$name;
	?>



		<div class='container_wrap main_color <?php avia_layout_class( 'main' ); ?>'>

			<div class='container template-blog template-author '>

				<div class='content <?php avia_layout_class( 'content' ); ?> units'>

				<div class='page-heading-container clearfix'>
				<?php

					get_template_part( 'includes/loop', 'about-author' );

				?>
				</div>


				<?php
                echo "<h4 class='extra-mini-title widgettitle'>{$heading_s}</h4>";



				/* Run the loop to output the posts.
				* If you want to overload this in a child theme then include a file
				* called loop-index.php and that will be used instead.
				*/


				$more = 0;
				get_template_part( 'includes/loop', 'author' );
				?>


				<!--end content-->
				</div>

				<?php

				//get the sidebar
				$avia_config['currently_viewing'] = 'blog';
				get_sidebar();

				?>

			</div><!--end container-->




<?php get_footer(); ?>