<h1>Configurator</h1>

<p>Here you can edit your <code>wp-config.php</code> file.<br />
<strong>Warning! Messing with these MIGHT render your website unusable. Only continue if you know what you're doing!</strong>.<br />If at any point your website becomes unusable when saving your config, go to where your WordPress is installed, delete <code>wp-config.php</code> and rename <code>wp-config.php.bak</code> to <code>wp-config.php</code>.</p>

<form id="configurator_form" action="<?php echo site_url( '/wp-admin/admin-post.php' ) ?>" method="post">
	<?php
	/** @var Configurator_Line $config_line */
	foreach ( $config_lines as $config_line ) : ?>
		<p>
			<label for="<?php echo strtolower( $config_line->get_name() ) ?>"><?php echo $config_line->get_name() ?></label>

			<?php if ( is_bool( $config_line->get_value() ) ) : ?>
				On <input id="<?php echo strtolower( $config_line->get_name() ) ?>" name="configurator[<?php echo $config_line->get_name() ?>]" type="radio" <?php echo $config_line->get_value() ? 'checked' : '' ?> value="bool_true" />

				Off <input id="<?php echo strtolower( $config_line->get_name() ) ?>" name="configurator[<?php echo $config_line->get_name() ?>]" type="radio" <?php echo !$config_line->get_value() ? 'checked' : '' ?> value="bool_false" />
			<?php else : ?>
				<input id="<?php echo strtolower( $config_line->get_name() ) ?>" name="configurator[<?php echo $config_line->get_name() ?>]" type="text" value="<?php echo Configurator_Util::e( $config_line->get_value() ) ?>" />
			<?php endif; ?>

		</p>
	<?php
	endforeach; ?>

	<p>
		<input name="action" type="hidden" value="configurator_handle_post" />
		<input type="submit" value="Save" />
	</p>
</form>
