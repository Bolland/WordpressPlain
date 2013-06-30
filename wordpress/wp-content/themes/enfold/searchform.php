<?php global $avia_config; ?>


<form action="<?php echo home_url( '/' ); ?>" id="searchform" method="get">
	<div>
		<input type="submit" value="<?php echo $avia_config['font_icons']['search']; ?>" id="searchsubmit" class="button"/>
		<input type="text" id="s" name="s" value="<?php if(!empty($_GET['s'])) echo get_search_query(); ?>" placeholder='<?php _e('Search','avia_framework')?>' />
		<?php 
		
		// allows to add aditional form fields to modify the query (eg add an input with name "post_type" and value "page" to search for pages only)
		do_action('avia_frontend_search_form'); 
		
		?>
	</div>
</form>