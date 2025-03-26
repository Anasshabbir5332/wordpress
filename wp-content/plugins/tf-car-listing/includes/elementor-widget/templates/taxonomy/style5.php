<div class="list">
	<?php
	$term_link = get_term_link( $taxonomy->term_id, $taxonomy->taxonomy );
	?>
	<div class="taxonomy-post taxonomy-post-<?php echo esc_attr( $taxonomy->term_id ) ?>">
		<div class="box-card">
			<div class="box-card-inner">
				<div class="feature-image">
					<a href="<?php echo esc_url( $term_link ) ?>" class="image-wrap">
                        <?php echo __( $taxonomy->name ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>