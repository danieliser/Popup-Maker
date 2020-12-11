<?php
/********************************************
 * Copyright (c) 2020, Code Atlantic LLC
 *******************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_Admin_Extend
 */
class PUM_Admin_Extend {
	/**
	 * Return array of Popup Maker extensions.
	 *
	 * @return array|mixed|object
	 */
	public static function available_extensions() {
		$json_data = file_get_contents( Popup_Maker::$DIR . 'includes/extension-list.json' );

		return json_decode( $json_data, true );
	}

	/**
	 * Support Page
	 *
	 * Renders the support page contents.
	 */
	public static function page() {
		// Set a new campaign for tracking purposes
		$campaign   = 'PUMExtensionsPage';

		?>
        <div class="wrap">
			<h1><?php _e( 'Extend Popup Maker with Additional Premium Features', 'popup-maker' ) ?></h1>
			<?php PUM_Upsell::display_addon_tabs(); ?>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder">
                    <div id="post-body-content">
						<br class="clear" />
						<a href="https://wppopupmaker.com/extensions/?utm_source=plugin-extension-page&utm_medium=text-link&utm_campaign=<?php echo $campaign; ?>&utm_content=browse-all" class="button-primary" title="<?php _e( 'Browse All Extensions', 'popup-maker' ); ?>" target="_blank"><?php _e( 'Browse All Extensions', 'popup-maker' ); ?></a>
                        <br class="clear" />

						<div class="pum-tabs-container">
							<?php self::render_extension_list(); ?>

							<br class="clear" />

							<a href="https://wppopupmaker.com/extensions/?utm_source=plugin-extension-page&utm_medium=text-link&utm_campaign=<?php echo $campaign; ?>&utm_content=browse-all-bottom" class="button-primary" title="<?php _e( 'Browse All Extensions', 'popup-maker' ); ?>" target="_blank"><?php _e( 'Browse All Extensions', 'popup-maker' ); ?></a>

							<br class="clear" /> <br class="clear" /> <br class="clear" />
							<hr class="clear" /><br class="clear" />
						</div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}


	/**
	 * Render extension tab extensions list.
	 */
	public static function render_extension_list() {
		// Set a new campaign for tracking purposes
		$campaign   = 'PUMExtensionsPage';
		$extensions = self::available_extensions();

		?>
        <ul class="extensions-available">
			<?php
			//		$plugins           = get_plugins();
			//		$installed_plugins = array();
			//		foreach ( $plugins as $key => $plugin ) {
			//			$is_active                          = is_plugin_active( $key );
			//			$installed_plugin                   = array(
			//				'is_active' => $is_active,
			//			);
			//			$installerUrl                       = add_query_arg( array(
			//				'action' => 'activate',
			//				'plugin' => $key,
			//				'em'     => 1,
			//			), network_admin_url( 'plugins.php' ) //admin_url('update.php')
			//			);
			//			$installed_plugin["activation_url"] = $is_active ? "" : wp_nonce_url( $installerUrl, 'activate-plugin_' . $key );
			//
			//
			//			$installerUrl                         = add_query_arg( array(
			//				'action' => 'deactivate',
			//				'plugin' => $key,
			//				'em'     => 1,
			//			), network_admin_url( 'plugins.php' ) //admin_url('update.php')
			//			);
			//			$installed_plugin["deactivation_url"] = ! $is_active ? "" : wp_nonce_url( $installerUrl, 'deactivate-plugin_' . $key );
			//			$installed_plugins[ $key ]            = $installed_plugin;
			//		}

			$existing_extension_images = self::extensions_with_local_image();

			if ( ! empty( $extensions ) ) {

				shuffle( $extensions );

				foreach ( $extensions as $key => $ext ) {
					unset( $extensions[ $key ] );
					$extensions[ $ext['slug'] ] = $ext;
				}

				$i = 0;

				foreach ( $extensions as $extension ) : ?>
                    <li class="available-extension-inner <?php echo esc_attr( $extension['slug'] ); ?>">
                        <h3>
                            <a target="_blank" href="<?php echo esc_url( $extension['homepage'] ); ?>?utm_source=plugin-extension-page&utm_medium=extension-title-<?php echo $i; ?>&utm_campaign=<?php echo $campaign; ?>&utm_content=<?php echo esc_attr( urlencode( str_replace( ' ', '+', $extension['name'] ) ) ); ?>">
								<?php echo esc_html( $extension['name'] ) ?>
                            </a>
                        </h3>
						<?php $image = in_array( $extension['slug'], $existing_extension_images ) ? POPMAKE_URL . '/assets/images/extensions/' . $extension['slug'] . '.png' : $extension['image']; ?>
                        <img class="extension-thumbnail" src="<?php echo esc_attr( $image ) ?>" />

                        <p><?php echo esc_html( $extension['excerpt'] ); ?></p>

                        <span class="action-links">
						<a class="button" target="_blank" href="<?php echo esc_url( $extension['homepage'] ); ?>?utm_source=plugin-extension-page&utm_medium=extension-button-<?php echo $i; ?>&utm_campaign=<?php echo $campaign; ?>&utm_content=<?php echo esc_attr( urlencode( str_replace( ' ', '+', $extension['name'] ) ) ); ?>"><?php _e( 'Get this Extension', 'popup-maker' ); ?></a>
					</span>

                        <!--					--><?php
						//
						//					if ( ! empty( $extension->download_link ) && ! isset( $installed_plugins[ $extension->slug . '/' . $extension->slug . '.php' ] ) ) {
						//						$installerUrl = add_query_arg( array(
						//							'action'            => 'install-plugin',
						//							'plugin'            => $extension->slug,
						//							'edd_sample_plugin' => 1,
						//						), network_admin_url( 'update.php' ) //admin_url('update.php')
						//						);
						//						$installerUrl = wp_nonce_url( $installerUrl, 'install-plugin_' . $extension->slug ) ?>
                        <!--						<span class="action-links">-->
                        <!--							--><?php
						//							printf( '<a class="button install" href="%s">%s</a>', esc_attr( $installerUrl ), __( 'Install' ) ); ?>
                        <!--						</span>-->
                        <!--						--><?php
						//					} elseif ( isset( $installed_plugins[ $extension->slug . '/' . $extension->slug . '.php' ]['is_active'] ) ) {
						//						?>
                        <!--						<span class="action-links">-->
                        <!--						--><?php
						//						if ( ! $installed_plugins[ $extension->slug . '/' . $extension->slug . '.php' ]['is_active'] ) {
						//							printf( '<a class="button install" href="%s">%s</a>', esc_attr( $installed_plugins[ $extension->slug . '/' . $extension->slug . '.php' ]["activation_url"] ), __( 'Activate' ) );
						//
						//						} else {
						//							printf( '<a class="button install" href="%s">%s</a>', esc_attr( $installed_plugins[ $extension->slug . '/' . $extension->slug . '.php' ]["deactivation_url"] ), __( 'Deactivate' ) );
						//						} ?>
                        <!--						</span>-->
                        <!--						--><?php
						//					} else {
						//						?>
                        <!--						<span class="action-links"><a class="button" target="_blank" href="--><?php //esc_attr_e( $extension->homepage ); ?><!--">--><?php //_e( 'Get It Now' ); ?><!--</a></span>-->
                        <!--						--><?php
						//					}
						//					?>

                    </li>
					<?php
					$i ++;
				endforeach;
			} ?>
        </ul>

		<?php
	}

	/**
	 * @return array
	 */
	public static function extensions_with_local_image() {
		return apply_filters( 'pum_extensions_with_local_image', array(
			'core-extensions-bundle',
			'aweber-integration',
			'mailchimp-integration',
			'remote-content',
			'scroll-triggered-popups',
			'popup-analytics',
			'forced-interaction',
			'age-verification-modals',
			'advanced-theme-builder',
			'exit-intent-popups',
			'ajax-login-modals',
			'advanced-targeting-conditions',
			'secure-idle-user-logout',
			'terms-conditions-popups',
		) );
	}

}
