<div class="wrap">
	<h2>Before You Can Import This Package, You Must Install &amp; Activate Some Plugins:</h2>

	<?php include( locate_template( 'importer/templates/partials/_messages.php' ) ); ?>

	<?php
		$activator = TGM_Plugin_Activation::get_instance();
		$activator->notices();
		$plugin_table = new TGMPA_List_Table;
		$plugin_table->prepare_items();
	?>
    <form id="tgmpa-plugins" action="/wp-admin/themes.php?page=tgmpa-install-plugins" method="post">
        <?php echo $plugin_table->display(); ?>
    </form>
</div>