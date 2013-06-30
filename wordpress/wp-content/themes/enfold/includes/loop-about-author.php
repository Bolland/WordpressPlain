<?php
	global $avia_config;

	$author_id    = get_query_var( 'author' );
	if(empty($author_id)) $author_id = get_the_author_meta('ID');
	$gravatar     = get_avatar( get_the_author_meta('email', $author_id), '75' );
	$name         = get_the_author_meta('display_name', $author_id);
	$heading      = __("About",'avia_framework') ." ".$name;
	$description  = get_the_author_meta('description', $author_id);

	if(empty($description))
	{
		$description  = __("This author has yet to write their bio.",'avia_framework');
		$description .= '</br>'.sprintf( __( 'Meanwhile lets just say that we are proud %s contributed a whooping %s entries.' ), $name, count_user_posts( $author_id ) );

		if(current_user_can('edit_users') || get_current_user_id() == $author_id)
		{
	    	$description .= "</br><a href='".admin_url( 'profile.php?user_id=' . $author_id )."'>".__( 'Edit the profile description here.' )."</a>";
		}
	}


	echo "<span class='post-author-format-type blog-meta'><span class='rounded-container'>{$gravatar}</span></span>";
    echo "<div class='author_description '><h3 class='author-title'>{$heading}</h3>".wpautop($description)."<span class='author-extra-border'></span></div>";

?>