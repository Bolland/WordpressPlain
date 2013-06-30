<?php
global $avia_config, $post_loop_count;

$post_loop_count= 1;
$post_class 	= "post-entry-".avia_get_the_id();



// check if we got posts to display:
if (have_posts()) :

	while (have_posts()) : the_post();
?>

		<div class='post-entry post-entry-type-page <?php echo $post_class; ?>'>

			<div class="entry-content clearfix">

				<?php

				$thumb = get_the_post_thumbnail(get_the_ID(), $avia_config['size']);

				if($thumb) echo "<div class='page-thumb'>{$thumb}</div>";

				//display the actual post content
				the_content(__('Read more','avia_framework').'<span class="more-link-arrow">  &rarr;</span>');

				wp_link_pages(array('before' =>'<div class="pagination_split_post">',
				    					'after'  =>'</div>',
				    					'pagelink' => '<span>%</span>'
				    					));

				if(has_tag() && is_single())
				{
					echo '<span class="blog-tags minor-meta">';
					the_tags('<strong>'.__('Tags:','avia_framework').'</strong><span> ');
					echo '</span></span>';
				}

				?>

			</div>


		</div><!--end post-entry-->


<?php
	$post_loop_count++;
	endwhile;
	else:
?>

	<div class="entry">
		<h1 class='post-title'><?php _e('Nothing Found', 'avia_framework'); ?></h1>
		<?php get_template_part('includes/error404'); ?>
	</div>
<?php

	endif;
?>