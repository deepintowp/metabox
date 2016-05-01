<?php 




//Plugin Name: metaboex create

function create_our_first_metabox(){
	add_meta_box(
			'our_first_meta',
			'About Aubhor',
			'create_our_first_metabox_callback',
			'post',
			'side',
			'high'
			
	
	);
	
}
add_action('add_meta_boxes','create_our_first_metabox');

// meta box callback
function create_our_first_metabox_callback(){
	wp_nonce_field( basename(__FILE__),  'nonce_name_formeta' );
	$value = get_post_meta(get_the_ID(), '__about_author', true );
	?>
	<div class="metabox-comtainer">
		<div class="single-metabox">
		<label for="">About Author</label>
		<input type="text" id="abt_author" style="height:200px; width:100%; "name="about_author" value="<?php
			if(!empty($value)){
				echo $value;
				
				
			}
	


		?>" />
		</div>
	</div>
	
	
	
<?php	
}

function save_our_metabox_value(){
	if(!wp_verify_nonce( $_POST['nonce_name_formeta'], basename(__FILE__)  )){
		return;
	}
	
	if(!isset($_POST['about_author'])){
		return;
		
	}
	
	update_post_meta(get_the_ID(), '__about_author', sanitize_text_field($_POST['about_author'])); 
	
	
}

add_action( 'save_post', 'save_our_metabox_value' );