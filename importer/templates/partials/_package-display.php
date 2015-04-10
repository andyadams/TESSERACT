<div class="package">
	<form action="<?php echo esc_url( tesseract_get_import_package_url() ); ?>" method="post" class="package-form" data-num-pages="<?php echo esc_attr( count( $package['posts'] ) ); ?>">
		<?php if ( ! empty( $package['image'] ) ) : ?>
			<div class="image">
				<img src="<?php echo esc_url( $package['image'] ); ?>">
			</div>
		<?php endif; ?>
		<h4 class="name">
			<?php echo esc_html( $package['name'] ); ?>
		</h4>
		<?php if ( ! empty( $package['details']['description'] ) ) : ?>
			<div class="description">
				<?php
					echo wp_kses( $package['details']['description'], array(
						'a' => array(
							'href' => array(),
							'title' => array()
						),
						'br' => array(),
						'em' => array(),
						'strong' => array(),
					) );
				?>
			</div>
		<?php endif; ?>
		<input type="hidden" name="package" value="<?php echo esc_attr( $package['id'] ); ?>">
		<input type="submit" class="button button-secondary" value="Import This Package">
		<?php wp_nonce_field( 'tesseract_import_package' ); ?>
	</form>
</div>