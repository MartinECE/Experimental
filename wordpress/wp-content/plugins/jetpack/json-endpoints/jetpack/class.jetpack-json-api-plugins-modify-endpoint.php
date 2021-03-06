<?php

class Jetpack_JSON_API_Plugins_Modify_Endpoint extends Jetpack_JSON_API_Plugins_Endpoint {
	// POST  /sites/%s/plugins/%s
	// POST  /sites/%s/plugins

	protected $needed_capabilities = 'activate_plugins';
	protected $action              = 'default_action';
	protected $expected_actions    = array( 'update', 'install', 'delete' );

	public function callback( $path = '', $blog_id = 0, $object = null ) {
		Jetpack_JSON_API_Endpoint::validate_input( $object );
		switch ( $this->action ) {
			case 'update' :
				$this->needed_capabilities = 'update_plugins';
				break;
			case 'install' :
				$this->needed_capabilities = 'install_plugins';
				break;
		}
		if ( isset( $args['autoupdate'] ) ) {
			$this->needed_capabilities = 'update_plugins';
		}

		return parent::callback( $path, $blog_id, $object );
	}

	public function default_action() {
		$args = $this->input();

		if ( isset( $args['autoupdate'] ) && is_bool( $args['autoupdate'] ) ) {
			if ( $args['autoupdate'] ) {
				$this->autoupdate_on();
			} else {
				$this->autoupdate_off();
			}
		}

		if ( isset( $args['active'] ) && is_bool( $args['active'] ) ) {
			if ( $args['active'] ) {
				return $this->activate();
			} else {
				return $this->deactivate();
			}
		}

		return true;
	}

	protected function autoupdate_on() {
		$autoupdate_plugins = Jetpack_Options::get_option( 'autoupdate_plugins', array() );
		$autoupdate_plugins = array_unique( array_merge( $autoupdate_plugins, $this->plugins) );
		Jetpack_Options::update_option( 'autoupdate_plugins', $autoupdate_plugins );
	}

	protected function autoupdate_off() {
		$autoupdate_plugins = Jetpack_Options::get_option( 'autoupdate_plugins', array() );
		$autoupdate_plugins = array_diff( $autoupdate_plugins, $this->plugins );
		Jetpack_Options::update_option( 'autoupdate_plugins', $autoupdate_plugins );
	}

	protected function activate() {
		foreach ( $this->plugins as $plugin ) {
			if ( ( ! $this->network_wide && Jetpack::is_plugin_active( $plugin ) ) || is_plugin_active_for_network( $plugin ) ) {
				$this->log[ $plugin ]['error'] = __( 'The Plugin is already active.', 'jetpack' );
				$has_errors = true;
				continue;
			}

			if( ! $this->network_wide && is_network_only_plugin( $plugin ) ) {
				$this->log[ $plugin ]['error'] = __( 'Plugin can only be Network Activated', 'jetpack' );
				$has_errors = true;
				continue;
			}

			$result = activate_plugin( $plugin, '', $this->network_wide );

			if ( is_wp_error( $result ) ) {
				$this->log[ $plugin ]['error'] = $result->get_error_messages();
				$has_errors = true;
				continue;
			}

			$success = Jetpack::is_plugin_active( $plugin );
			if ( $success &&  $this->network_wide ) {
				$success &= is_plugin_active_for_network( $plugin );
			}

			if ( ! $success ) {
				$this->log[ $plugin ]['error'] = $result->get_error_messages;
				$has_errors = true;
				continue;
			}
			$this->log[ $plugin ][] = __( 'Plugin activated.', 'jetpack' );
		}
		if ( ! $this->bulk && isset( $has_errors ) ) {
			$plugin = $this->plugins[0];
			return new WP_Error( 'activation_error', $this->log[ $plugin ]['error'] );
		}
	}

	protected function deactivate() {
		foreach( $this->plugins as $plugin ) {
			if ( ! Jetpack::is_plugin_active( $plugin ) ) {
				$error = $this->log[ $plugin ]['error'] = __( 'The Plugin is already deactivated.', 'jetpack' );
				continue;
			}

			deactivate_plugins( $plugin, false, $this->network_wide );

			$success = ! Jetpack::is_plugin_active( $plugin );
			if ( $success &&  $this->network_wide ) {
				$success &= ! is_plugin_active_for_network( $plugin );
			}

			if ( ! $success ) {
				$error = $this->log[ $plugin ]['error'] = __( 'There was an error deactivating your plugin', 'jetpack' );
				continue;
			}
			$this->log[ $plugin ][] = __( 'Plugin deactivated.', 'jetpack' );
		}
		if ( ! $this->bulk && isset( $error ) ) {
			return new WP_Error( 'deactivation_error', $error );
		}
	}

	protected function update() {

		wp_clean_plugins_cache();
		ob_start();
		wp_update_plugins(); // Check for Plugin updates
		ob_end_clean();

		$update_plugins = get_site_transient( 'update_plugins' );

		if ( isset( $update_plugins->response ) ) {
			$plugin_updates_needed = array_keys( $update_plugins->response );
		} else {
			$plugin_updates_needed = array();
		}

		$update_attempted = false;

		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

		// unhook this functions that output things before we send our response header.
		remove_action( 'upgrader_process_complete', array( 'Language_Pack_Upgrader', 'async_upgrade' ), 20 );
		remove_action( 'upgrader_process_complete', 'wp_version_check' );
		remove_action( 'upgrader_process_complete', 'wp_update_themes' );

		foreach ( $this->plugins as $plugin ) {

			if ( ! in_array( $plugin, $plugin_updates_needed ) ) {
				$this->log[ $plugin ][] = __( 'No update needed', 'jetpack' );
				continue;
			}

			$update_attempted = true;

			// Object created inside the for loop to clean the messages for each plugin
			$skin = new Automatic_Upgrader_Skin();
			// The Automatic_Upgrader_Skin skin shouldn't output anything.
			$upgrader = new Plugin_Upgrader( $skin );
			$upgrader->init();
			// This avoids the plugin to be deactivated.
			defined( 'DOING_CRON' ) or define( 'DOING_CRON', true );
			$result = $upgrader->upgrade( $plugin );

			$this->log[ $plugin ][]  = $upgrader->skin->get_upgrade_messages();
		}

		if ( ! $this->bulk && ! $result && $update_attempted ) {
			return new WP_Error( 'update_fail', __( 'There was an error updating your plugin', 'jetpack' ), 400 );
		}

		return $this->default_action();
	}
}
