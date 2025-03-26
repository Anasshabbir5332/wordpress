<?php foreach ($settings['carousel_list'] as $carousel): 
		$image =  \Elementor\Group_Control_Image_Size::get_attachment_image_html( $carousel, 'thumbnail','avatar' );
	?>			

	<div class="item">	
			<div class="item-testimonial">	
                    <div class="tes-top">
                        <div class="rating">
                            <?php for ($i = 1; $i <= $carousel['rating']; $i++){
                                echo '<i class="icon-autodeal-icon-172"></i>';
                            } ?>
                        </div>
                        <?php echo sprintf( '<div class="date-pub"> %1$s </div>', $carousel['date'] ); ?>
                    </div>
					<div class="description"><?php echo sprintf( '%1$s', $carousel['description'] ); ?></div>
					<div class="group-author">
                        <div class="thumb">
                            <?php echo sprintf( '%1$s', $image ); ?>
                        </div>
                        <div class="content">
                            <?php echo sprintf( '<h6> %1$s </h6>', $carousel['name'] ); ?>
                            <?php echo sprintf( '<p> %1$s </p>', $carousel['position'] ); ?>
                        </div>
                    </div>
			</div>
	</div>				
<?php endforeach;?>