<div class="wrap">
	<h2>Importing Package</h2>
	<?php if ( tesseract_has_success_messages() ) : ?>
		<ul class="tm-messages success">
			<?php $success_messages = tesseract_get_messages( 'success' ); ?>
			<?php foreach ( $success_messages as $message ) : ?>
				<li><?php echo esc_html( $message ); ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<?php if ( tesseract_has_error_messages() ) : ?>
		<ul class="tm-messages error">
			<?php $error_messages = tesseract_get_messages( 'error' ); ?>
			<?php foreach ( $error_messages as $message ) : ?>
				<li><?php echo esc_html( $message ); ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php global $tesseract_import_result; ?>

	<?php if ( isset( $tesseract_import_result ) ) : ?>
		<?php if ( ! empty( $tesseract_import_result['post_ids'] ) ) : ?>
			<h3>The following content was added:</h3>
			<table class="added-content">
				<?php foreach ( $tesseract_import_result['post_ids'] as $post_id ) : ?>
					<tr>
						<td>
							<strong><?php echo esc_html( get_the_title( $post_id ) ); ?></strong>
						</td>
						<td><a href="<?php echo get_permalink( $post_id ); ?>">View</a></td>
						<td><?php edit_post_link( 'Edit', '', '', $post_id ); ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
		<?php if ( ! empty( $tesseract_import_result['options'] ) ) : ?>
			<h3>Your settings were also updated.</h3>
		<?php endif; ?>
	<?php endif; ?>
</div>