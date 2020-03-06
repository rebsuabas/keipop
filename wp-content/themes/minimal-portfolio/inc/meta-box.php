<?php

function minimal_portfolio_page_title_metabox() {
	add_meta_box(
		'minimal-portfolio-page_title-metabox',
		__( 'Page Title', 'minimal-portfolio' ),
		'minimal_portfolio_page_title_form',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'minimal_portfolio_page_title_metabox' );

function minimal_portfolio_page_title_form( $post) {
	wp_nonce_field( '_feature_nonce', 'feature_nonce' ); 
	
	$minmal_portfolio_page_title = get_post_meta( $post->ID, 'minimal_portfolio_page_title', true );
	?>
	
	<p>
		<label for="minimal_portfolio_page_title"><?php esc_attr_e( 'Disable Page Title: ', 'minimal-portfolio' ); ?></label>
		<input type="checkbox" id="minimal_portfolio_page_title" name="minimal_portfolio_page_title" <?php checked( $minmal_portfolio_page_title, 'on' ); ?> />
	</p>
	
<?php
}

function minimal_portfolio_page_title_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['feature_nonce'] ) || ! wp_verify_nonce( $_POST['feature_nonce'], '_feature_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['minimal_portfolio_page_title'] ) ) {

        update_post_meta( $post_id, 'minimal_portfolio_page_title', esc_attr( $_POST['minimal_portfolio_page_title'] ) );
	}
	else{
		// delete data
		delete_post_meta( $post_id, 'minimal_portfolio_page_title' );
	}
}
add_action( 'save_post', 'minimal_portfolio_page_title_save' );