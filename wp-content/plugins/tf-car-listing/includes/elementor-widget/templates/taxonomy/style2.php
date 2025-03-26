<div class="item">
	<?php
	$term_link = get_term_link( $taxonomy->term_id, $taxonomy->taxonomy );
	if ( $settings['taxonomy'] == 'make' ) {
		$term_image_id = get_term_meta( $taxonomy->term_id, 'make_image', true );
	} else if ( $settings['taxonomy'] == 'body' ) {
		if ($settings['taxonomy_render_image'] == 'image') {
			$term_image_id = get_term_meta( $taxonomy->term_id, 'body_image', true );
		} else {
			$term_image_id  = get_term_meta( $taxonomy->term_id, 'body_icon', true );
		}
	} else {
		$term_image_id = get_term_meta( $taxonomy->term_id, 'type_poster', true );
	}
	$toggle_lazy_load = tfcl_get_option( 'toggle_lazy_load' );
	?>
	<div class="taxonomy-post taxonomy-post-<?php echo esc_attr( $taxonomy->term_id ) ?>">
		<div class="box-card">
			<div class="box-card-inner">
				<div class="feature-image">
					<a href="<?php echo esc_url( $term_link ) ?>" class="image-wrap">
						<?php
						if ( $toggle_lazy_load == 'on' ) {
							echo sprintf( '<img loading="lazy" class="image-taxonomy lazy" src="" data-src="%s" alt="image">', empty( $term_image_id ) ? TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image.jpg" : wp_get_attachment_image_src( $term_image_id, 'full' )[0] );
						} else {
							echo sprintf( '<img loading="lazy" class="image-taxonomy" src="%s" alt="image">', empty( $term_image_id ) ? TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image.jpg" : wp_get_attachment_image_src( $term_image_id, 'full' )[0] );
						}
						?>
					</a>
				</div>
				<div class="content">
					<h3 class="name">
						<a href="<?php echo esc_url( $term_link ) ?>">
							<?php echo __( $taxonomy->name ); ?>
						</a>
					</h3>
					<p class="count-property">
                            <?php echo sprintf('%s ' . tfcl_get_number_text($taxonomy->count, esc_html__('Cars', 'tf-car-listing'), esc_html__('Car', 'tf-car-listing')), $taxonomy->count); ?>
                    </p>
				</div>
			</div>
		</div>
	</div>
</div>