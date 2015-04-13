<div class="package">
	<form action="<?php echo esc_url( tesseract_get_import_package_url() ); ?>" method="post" class="package-form" data-num-pages="<?php echo esc_attr( count( $package['posts'] ) ); ?>">
		<div class="image">
			<?php if ( ! empty( $package['image'] ) ) : ?>
				<img src="<?php echo esc_url( $package['image'] ); ?>">
			<?php else : ?>
				<span class="image-placeholder"><?php echo esc_html( $package['name'] ); ?></span>
			<?php endif; ?>
		</div>
		<div class="content">
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
			<input type="submit" class="button button-secondary" value="Import This Package">
		</div>

		<?php wp_nonce_field( 'tesseract_import_package' ); ?>
		<input type="hidden" name="package" value="<?php echo esc_attr( $package['id'] ); ?>">
	</form>
</div>