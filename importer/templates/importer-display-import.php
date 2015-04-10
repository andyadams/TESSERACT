<div class="wrap">
	<h2>Importing Package</h2>
	<?php if ( tesseract_has_success_messages() ) : ?>
		<ul class="success">
			<?php foreach ( tesseract_get_messages( 'success' ) as $message ) : ?>
				<li><?php echo esc_html( $message ); ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<?php if ( tesseract_has_error_messages() ) : ?>
		<ul class="error">
			<?php foreach ( tesseract_get_messages( 'error' ) as $message ) : ?>
				<li><?php echo esc_html( $message ); ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php global $tesseract_import_result; ?>

	<?php if ( isset( $tesseract_import_result ) ) : ?>
		<?php if ( ! empty( $tesseract_import_result['post_ids'] ) ) : ?>
			<h3>The following content was added:</h3>
			<ul>
				<?php foreach ( $tesseract_import_result['post_ids'] as $post_id ) : ?>
					<li>
						<strong><?php echo esc_html( get_the_title( $post_id ) ); ?></strong>
						<a href="<?php echo get_permalink( $post_id ); ?>">View</a>
						<?php edit_post_link( 'Edit', '', '', $post_id ); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>
</div>