<?php 

function smart_service_is_secured( $nonce_field, $action, $post_id ) {
	$nonce = isset( $_POST[ $nonce_field ] ) ? $_POST[ $nonce_field ] : '';

	if ( $nonce == '' ) {
		return false;
	}
	if ( ! wp_verify_nonce( $nonce, $action ) ) {
		return false;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return false;
	}

	if ( wp_is_post_autosave( $post_id ) ) {
		return false;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return false;
	}

	return true;

}

function smart_service_add_metabox() {
	add_meta_box('smart_icon', __( 'Plase Type Your Icon', 'smart-service' ), 'smart_service_create_meta_box', array('service'));

}
add_action( 'admin_menu','smart_service_add_metabox');

function smart_service_create_meta_box( $post){
	wp_nonce_field( 'smart_service_icon', 'smart_service_icon_field' );
	$icon                = get_post_meta( $post->ID, 'smart_icon', true );
	$learnmore           = get_post_meta( $post->ID, 'learn_more_text', true );
	$servicelink         = get_post_meta( $post->ID, 'learn_more_link', true );
	$servicebgcolor      = get_post_meta( $post->ID, 'service_bg_c', true );
	$serviceiconcolor    = get_post_meta( $post->ID, 'service_icon_c', true );
	$serviceheadingcolor = get_post_meta( $post->ID, 'service_head_c', true );
	$servicebodycolor    = get_post_meta( $post->ID, 'service_body_c', true );
	$servicelinkcolor    = get_post_meta( $post->ID, 'service_link_c', true );

	$icon_text                 = __('Type Fontawsome Icon Name. You Can Find Here', 'smart-service');
	$learmore_text             = __('Type Learn More Text', 'smart-service');
	$service_url_link          = __('Type Service Url Link ', 'smart-service');
	$service_bg_text           = __('Select Service Background Color', 'smart-service');
	$service_icon_text         = __('Select Service Icon Color', 'smart-service');
	$service_heading_text      = __('Select Service Heading Color', 'smart-service');
	$service_body_text         = __('Select Service Body Color', 'smart-service');
	$service_link_text         = __('Select Service Link Color', 'smart-service');
	$service_bg_defult_color   = __('#ffffff', 'smart-service');
	$serviceiconcolor_color    = __('#677294', 'smart-service');
	$serviceheadingcolor_color = __('#222d39', 'smart-service');
	$servicebodycolort_color   = __('#677294', 'smart-service');
	$servicelinkcolor_color    = __('#2ea3f2', 'smart-service');

	$metabox_html = '
		<p>
			<label for="smart_icon">'.esc_html( $icon_text ).': </label>
			<input class="smart-service" type="text" name="smart_icon" id="smart_icon" value="'.$icon.'"/>
		</p>

		<br/>

		<p>
			<label for="learn_more_text">'.esc_html( $learmore_text ).': </label>
			<input class="smart-service" type="text" name="learn_more_text" id="learn_more_text" value="'.esc_html($learnmore).'"/>
		</p>

		<p>
			<label for="learn_more_link">'.esc_html( $service_url_link ).': </label>
			<input class="smart-service" type="text" name="learn_more_link" id="learn_more_link" value="'.esc_url($servicelink).'"/>
		</p>

		<br/>

		<p>
			<label for="service_bg_c">'.esc_html( $service_bg_text ).': </label>
			<input class="my-color-field" type="text" name="service_bg_c" id="service_bg_c" data-default-color="'.esc_attr($service_bg_defult_color).'" value="'.esc_attr($servicebgcolor).'"/>
		</p>

		<br/>

		<p>
			<label for="service_icon_c">'.esc_html( $service_icon_text ).': </label>
			<input class="my-color-field" type="text" name="service_icon_c" id="service_icon_c" data-default-color="'.esc_attr($serviceiconcolor_color).'" value="'.esc_attr($serviceiconcolor).'"/>
		</p>
		<br/>
		<p>
			<label for="service_head_c">'.esc_html( $service_heading_text ).': </label>
			<input class="my-color-field" type="text" name="service_head_c" id="service_head_c" data-default-color="'.esc_attr($serviceheadingcolor_color).'" value="'.esc_attr($serviceheadingcolor).'"/>
		</p>
		<br/>
		<p>
			<label for="service_body_c">'.esc_html( $service_body_text ).': </label>
			<input class="my-color-field" type="text" name="service_body_c" id="service_body_c" data-default-color="'.esc_attr($servicebodycolort_color).'" value="'.esc_attr($servicebodycolor).'"/>
		</p>
		<br/>
		<p>
			<label for="service_link_c">'.esc_html( $service_link_text ).': </label>
			<input class="my-color-field" type="text" name="service_link_c" id="service_link_c" data-default-color="'.esc_attr($servicelinkcolor_color).'" value="'.esc_attr($servicelinkcolor).'"/>
		</p>
		';

	echo $metabox_html;
}

function smart_service_save_post( $post_id ) {

	if ( !smart_service_is_secured( 'smart_service_icon_field', 'smart_service_icon', $post_id ) ) {
		return $post_id;
	}

	$icon                =  isset( $_POST['smart_icon'] ) ? $_POST['smart_icon'] : '';
	$learnmore           =  isset( $_POST['learn_more_text'] ) ? $_POST['learn_more_text'] : '' ;
	$servicelink         =  isset( $_POST['learn_more_link'] ) ? $_POST['learn_more_link'] : '' ;
	$servicebgcolor      =  isset( $_POST['service_bg_c'] ) ? $_POST['service_bg_c'] : '' ;
	$serviceiconcolor    =  isset( $_POST['service_icon_c'] ) ? $_POST['service_icon_c'] : '' ;
	$serviceheadingcolor =  isset( $_POST['service_head_c'] ) ? $_POST['service_head_c'] : '' ;
	$servicebodycolor    =  isset( $_POST['service_body_c'] ) ? $_POST['service_body_c'] : '' ;
	$servicelinkcolor    =  isset( $_POST['service_link_c'] ) ? $_POST['service_link_c'] : '' ;
	
	$icon                = sanitize_text_field($icon);
	$learnmore           = sanitize_text_field($learnmore);
	$servicelink         = sanitize_text_field($servicelink);
	$servicebgcolor      = sanitize_hex_color($servicebgcolor);
	$serviceiconcolor    = sanitize_hex_color($serviceiconcolor);
	$serviceheadingcolor = sanitize_hex_color($serviceheadingcolor);
	$servicebodycolor    = sanitize_hex_color($servicebodycolor);
	$servicelinkcolor    = sanitize_hex_color($servicelinkcolor);
	
	

	update_post_meta( $post_id, 'smart_icon', $icon );
	update_post_meta( $post_id, 'learn_more_text', $learnmore );
	update_post_meta( $post_id, 'learn_more_link', $servicelink );
	update_post_meta( $post_id, 'service_bg_c', $servicebgcolor );
	update_post_meta( $post_id, 'service_icon_c', $serviceiconcolor );
	update_post_meta( $post_id, 'service_head_c', $serviceheadingcolor );
	update_post_meta( $post_id, 'service_body_c', $servicebodycolor );
	update_post_meta( $post_id, 'service_link_c', $servicelinkcolor );
}

add_action( 'save_post', 'smart_service_save_post');

?>