<?php
global $avia_config;


// check if we got posts to display:
if (have_posts()) :
	$first = true;

	$counterclass = "";
	$post_loop_count = 1;
	$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
	if($page > 1) $post_loop_count = ((int) ($page - 1) * (int) get_query_var('posts_per_page')) +1;
	$blog_style = avia_get_option('blog_style','multi-big');


	while (have_posts()) : the_post();


	$the_id 		= get_the_ID();
	$parity			= $post_loop_count % 2 ? 'odd' : 'even';
	$last           = count($wp_query->posts) == $post_loop_count ? " post-entry-last " : "";
	$post_class 	= "post-entry-".$the_id." post-loop-".$post_loop_count." post-parity-".$parity.$last." ".$blog_style;
	$post_format 	= get_post_format() ? get_post_format() : 'standard';

	?>

	<div <?php post_class('post-entry post-entry-type-'.$post_format . " " . $post_class . " "); ?>'>


			<div class="entry-content clearfix <?php echo $post_format; ?>-content">

				<?php
				echo "<span class='search-result-counter {$counterclass}'>{$post_loop_count}</span>";
				//echo the post title
			    echo "<h2 class='post-title'><a title='".the_title_attribute('echo=0')."' href='".get_permalink()."'>".get_the_title()."</a></h2>";

				?>
				<span class='post-meta-infos'>
					<span class='date-container minor-meta'><?php the_time('d M Y') ?></span>

					<?php
					if(get_post_type() !== "page")
					{
						if ( get_comments_number() != "0" || comments_open() )
						{
							echo "<span class='text-sep'>/</span>";
							echo "<span class='comment-container minor-meta'>";
							comments_popup_link(  "0 ".__('Comments','avia_framework'),
		    									  "1 ".__('Comment' ,'avia_framework'),
		    									  "% ".__('Comments','avia_framework'),'comments-link',
		    									  "".__('Comments Disabled','avia_framework'));
							echo "</span>";
						}
                    }


					$taxonomies  = get_object_taxonomies(get_post_type($the_id));
					$cats = '';
					$excluded_taxonomies =  apply_filters('avf_exclude_taxonomies', array('post_tag','post_format'), get_post_type($the_id), $the_id);

					if(!empty($taxonomies))
					{
						foreach($taxonomies as $taxonomy)
						{
							if(!in_array($taxonomy, $excluded_taxonomies))
							{
								$cats .= get_the_term_list($the_id, $taxonomy, '', ', ','').' ';
							}
						}
					}

					if(!empty($cats))
					{
						echo "<span class='text-sep'>/</span>";
						echo '<span class="blog-categories minor-meta">'.__('in','avia_framework')." ";
						echo $cats;
						echo '</span>';
					}

					?>

				</span>
				<?php

				the_excerpt()

				?>
			</div>

		</div><!--end post-entry-->

	<?php


		$first = false;
		$post_loop_count++;
		if($post_loop_count >= 100) $counterclass = "nowidth";
	endwhile;
	else:


?>

	<div class="entry entry-content clearfix" id='search-fail'>
		<p><strong><?php _e('Nothing Found', 'avia_framework'); ?></strong><br/>
		   <?php _e('Sorry, no posts matched your criteria. Please try another search', 'avia_framework'); ?>
	    </p>

		<div class='hr_invisible'></div>

		<?php _e('You might want to consider some of our suggestions to get better results:', 'avia_framework'); ?></p>
		<ul>
			<li><?php _e('Check your spelling.', 'avia_framework'); ?></li>
			<li><?php _e('Try a similar keyword, for example: tablet instead of laptop.', 'avia_framework'); ?></li>
			<li><?php _e('Try using more than one keyword.', 'avia_framework'); ?></li>
		</ul>

		<div class='hr_invisible'></div>
		<h3 class=''><?php _e('Feel like browsing some posts instead?', 'avia_framework'); ?></h3>

<?php
the_widget('avia_combo_widget', 'error404widget', array('widget_id'=>'arbitrary-instance-'.$id,
        'before_widget' => '<div class="widget avia_combo_widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));

	echo "</div>";

	endif;
	echo avia_pagination();
?>