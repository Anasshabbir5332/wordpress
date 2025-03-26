<div class="item seller-card-item">
	<div class="featured-post">
		<div class="image-wrap">
			<a href="<?php echo esc_url( $seller_data['seller_link_profile'] ); ?>" class="wrap-image">
				<img src="<?php echo esc_attr( $seller_data['seller_avatar_url'] ); ?>" alt="seller-avatar">
			</a>
			<?php if ( $settings['show_social'] == 'yes' ) : ?>
				<ul class="social">
					<?php foreach ( $seller_data['seller_social'] as $key => $social ) : ?>
						<li class="seller-social-item">
							<a href="<?php echo esc_url( $social ) ?>">
								<i class="<?php echo esc_attr( $key ) ?>"></i>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>

	<div class="content">
		<div class="info">
			<?php if ( $settings['show_name'] == 'yes' ) : ?>
				<h6 class="title">
					<a href="<?php echo esc_url( $seller_data['seller_link_profile'] ); ?>">
						<?php echo esc_html__( $seller_data['seller_name'] ); ?> </a>
				</h6>
			<?php endif; ?>
			<?php if ( $settings['show_position'] == 'yes' ) : ?>
				<p class="position">
					<?php
					$seller_career = ! empty( $seller_data['seller_career'] ) ? $seller_data['seller_career'] : '';
					echo esc_html__( $seller_career, 'tf-car-listing' );
					?>
				</p>
			<?php endif; ?>
				<?php if ( $settings['show_phone'] == 'yes' || $settings['show_email'] == 'yes' ) : ?>
				<div class="group-contact">
					<?php if ( $settings['show_phone'] == 'yes' ) : ?>
						<a href="tel:<?php echo esc_attr( $seller_data['seller_phone'] ); ?>" class="phone-user" aria-label="phone call"><i class="icon-autodeal-icon-145"></i></a>
					<?php endif; ?>
					<?php if ( $settings['show_email'] == 'yes' ) : ?>
						<a href="mailto:<?php echo esc_attr( $seller_data['seller_email'] ); ?>" class="mail-user" aria-label="email"><i class="icon-autodeal-icon-146"></i></a>
					<?php endif; ?>
				</div>
				<?php endif; ?>
		</div>
	</div>
</div>