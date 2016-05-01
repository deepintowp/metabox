<?php 





//Plugin Name: metaboex create

function add_style_n_scripts_for_plugin(){
 global $typenow, $pagenow;
 
 
 if($typenow == 'post' &&  ($pagenow == 'post.php' || $pagenow == 'post-new.php'  ) ){
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_style('meta-css', plugins_url( 'css/stylesheet.css', __FILE__ ), array(), '1.5.2016', 'all' );
	wp_enqueue_style('jqueryui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/base/jquery-ui.css', array(), '1.5.2016', 'all' );
	wp_enqueue_script('meta-js', plugins_url( 'js/meta.js', __FILE__ ), array('jquery', 'wp-color-picker', 'jquery-ui-datepicker', 'quicktags' ), '1.5.2016', true );
 
 
 }
}

add_action('admin_enqueue_scripts', 'add_style_n_scripts_for_plugin');




function create_different_metboxex(){
	add_meta_box(
		'new_metabex',
		__('Differnt Metaboxes', 'text-domain'),
		'create_different_metboxex_callback',
		'post',
		'normal',
		'low'
	
	);
	
}
add_action('add_meta_boxes', 'create_different_metboxex');
//callback
function create_different_metboxex_callback (){
	wp_nonce_field(basename(__FILE__), 'all_meta_nonce');
	$all_value = get_post_meta(get_the_ID());
	?>
		<div class="metboxes_container">
			
			<div class="single_metbox" style="margin:8px 0; padding:10px 0;" >
				<label for="simple_text">Simple text</label>
				<input type="" id="simple_text" name="simple_text" value="<?php 
					if($all_value['simple_text']){
					echo $all_value['simple_text'][0];
					}

				?>" />
			</div><!-- single_metbox -->
			<div class="single_metbox" style="margin:8px 0; padding:10px 0;">
				<label for="color__picker">Color Picker</label>
				<input type="" id="color__picker" name="color__picker" value="<?php 
					if($all_value['color__picker']){
					echo $all_value['color__picker'][0];
					}

				?>" />
			</div><!-- single_metbox -->
			<div class="single_metbox" style="margin:8px 0; padding:10px 0;">
				<label for="date__picker">Date Picker</label>
				<input type="" id="date__picker" name="date__picker" value="<?php 
					if($all_value['date__picker']){
					echo $all_value['date__picker'][0];
					}

				?>" />
			</div><!-- single_metbox -->
			<div class="single_metbox" style="margin:8px 0; padding:10px 0;">
				<label for="wp__editor">Date Picker</label>
				
				<?php
				$content = get_post_meta(get_the_ID(), 'wp__editor', true);
				
				wp_editor( $content, 'wp__editor', array(
				
				'media_buttons'=>false,
				'textarea_rows'=>8
				
				) );


				?>
			</div><!-- single_metbox -->
			
			<div class="single_metbox" style="margin:8px 0; padding:10px 0;">
				<label for="__quictags">Quicktags</label>
				<textarea name="__quictags" id="__quictags" cols="130" rows="10"><?php 
					if($all_value['__quictags']){
					echo $all_value['__quictags'][0];
					}

				
				
				?></textarea>
			</div><!-- single_metbox -->
		</div>
	
	<?php
}

function save_our_all_metaboxes(){
$autosave = wp_is_post_autosave(get_the_ID());
$revision = wp_is_post_revision(get_the_ID());
if($autosave || $revision ){

return;

}
if(!wp_verify_nonce($_POST['all_meta_nonce'], basename(__FILE__))){
return;
}
if(isset($_POST['simple_text'])){
update_post_meta(get_the_ID(), 'simple_text', sanitize_text_field($_POST['simple_text']));
}

if(isset($_POST['color__picker'])){
update_post_meta(get_the_ID(), 'color__picker', sanitize_text_field($_POST['color__picker']));
}

if(isset($_POST['date__picker'])){
update_post_meta(get_the_ID(), 'date__picker', sanitize_text_field($_POST['date__picker']));
}

if(isset($_POST['wp__editor'])){
update_post_meta(get_the_ID(), 'wp__editor', sanitize_text_field($_POST['wp__editor']));
}

if(isset($_POST['__quictags'])){
update_post_meta(get_the_ID(), '__quictags', sanitize_text_field($_POST['__quictags']));
}





}
add_action('save_post', 'save_our_all_metaboxes');







