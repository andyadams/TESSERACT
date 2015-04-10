<div class="wrap">
	<h2>Tesseract Content Importer</h2>
	<?php $packages = tesseract_get_packages(); ?>
	<?php foreach ( $packages as $package ) : ?>
		<?php include( locate_template( 'importer/templates/partials/_package-display.php' ) ); ?>
	<?php endforeach; ?>
</div>