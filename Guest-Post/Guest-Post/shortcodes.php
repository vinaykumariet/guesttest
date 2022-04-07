<?php
/*Guest form for login users*/
add_shortcode( 'save-post', 'save_posts');

function save_posts($atts){ 
	if ( is_user_logged_in() ) {
	?>
	<form action="" method="post" enctype="multipart/form-data">
	<label>Post tile<label>
	<input type="text"  name="title" />
	<label>Post Description<label>
	<textarea  name="descriptioon" rows="4" cols="50"></textarea>
	<input type="hidden" name="post_id" id="post_id" value="" />
	<label>Post Image<label>
	<input type="file" size="20"  name="test" />
	<?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
	<input type="submit" value="Submit" />
	</form>
	<?php
	}
}
/*show guest post for individual users*/
add_shortcode( 'show-post', 'show_posts');
function show_posts($atts){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array('post_type' => 'guest', 'post_status' => 'pending','posts_per_page' => 2, 'paged' => $paged );
	$guest_search = new WP_Query($args);
		if( $guest_search->have_posts() ) {	
			while ($guest_search->have_posts()) : $guest_search->the_post();
			$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
			$imgUrl = $large_image_url[0];									

			?>
				<p><?php echo get_the_title();?></p>	</br>
				<img src="<?php  echo $imgUrl;?>"/>
			<?php  endwhile;
			}
			wp_reset_query();
	
	
	
  $total_pages = $guest_search->max_num_pages;
 
  if ($total_pages > 1){
   $current_page = max(1, get_query_var('paged'));
  
   echo paginate_links(array(
   'format' => '/page/%#%',
    'current' => $current_page,
    'total' => $total_pages,
   ));
  }
	
	
	
}

