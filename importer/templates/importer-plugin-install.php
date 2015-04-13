<div class="wrap">
	<h2>Before You Can Import This Package, You Must Install &amp; Activate Some Plugins:</h2>
	<?php
		$activator = TGM_Plugin_Activation::get_instance();
		$activator->notices();
	?>
</div>