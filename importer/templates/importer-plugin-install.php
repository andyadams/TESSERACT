<div class="wrap">
	<h2>Before You Can Import This Package, You Must Install Some Plugins:</h2>
	<?php
		$activator = TGM_Plugin_Activation::get_instance();
		$activator->notices();
		$activator->install_plugins_page();
	?>
</div>