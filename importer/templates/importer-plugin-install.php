<div class="wrap">
	<h2>Before You Can Import This Package, You Must Install &amp; Activate Some Plugins:</h2>

	<?php include( locate_template( 'importer/templates/partials/_messages.php' ) ); ?>

	<?php
		$activator = TGM_Plugin_Activation::get_instance();
		$activator->notices();
	?>
</div>