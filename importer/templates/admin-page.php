<div class="wrap">
	<h2>Tesseract Content Importer</h2>
	<?php $packages = tesseract_get_packages(); ?>
	<?php foreach ( $packages as $package ) : ?>
		<a class="package" href="<?php echo esc_url( tesseract_import_package_url( $package['id'] ) ); ?>">
			<div class="image">
				<?php if ( ! empty( $package['image'] ) ) : ?>
					<img src="<?php echo esc_url( $package['image'] ); ?>">
				<?php else: ?>
					<span class="package-name"><?php echo esc_html( $package['name'] ); ?></span>
				<?php endif; ?>
			</div>
			<div class="name">
				<?php echo esc_html( $package['name'] ); ?>
			</div>
		</a>
	<?php endforeach; ?>
</div>