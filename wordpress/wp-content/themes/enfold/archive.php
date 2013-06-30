<?php
	global $avia_config, $more;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */
	 get_header();

	 echo avia_title(array('title' => avia_which_archive()));
	?>

		<div class='container_wrap main_color <?php avia_layout_class( 'main' ); ?>'>

			<div class='container template-blog '>

				<div class='content <?php avia_layout_class( 'content' ); ?> units'>
				<?php

				if(avia_get_option('blog_style','multi-big') == 'blog-grid')
				{
					global $posts;
					$post_ids = array();
					foreach($posts as $post) $post_ids[] = $post->ID;

					$atts   = array(
                        'type' => 'grid',
                        'items' => get_option('posts_per_page'),
                        'columns' => 3,
                        'class' => 'avia-builder-el-no-sibling',
                        'paginate' => 'yes',
                        'use_main_query_pagination' => 'yes',
                        'custom_query' => array( 'post__in'=>$post_ids, 'post_type'=>get_post_types() )
                    );

					$blog = new avia_post_slider($atts);
					$blog->query_entries();
					echo "<div class='entry-content'>".$blog->html()."</div>";
				}
				else
				{
					/* Run the loop to output the posts.
					* If you want to overload this in a child theme then include a file
					* called loop-index.php and that will be used instead.
					*/

					$more = 0;
					get_template_part( 'includes/loop', 'index' );
				}
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