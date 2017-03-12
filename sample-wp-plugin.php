<?php
/*
 Plugin Name: HAEC Sample Plugin
 Plugin URI: http://localhost/wordpress/
 Description: This is a sample plugin.
 Author: George Metaxas
 Version: 0.1
 Author URI: http://localhost/wordpress
 */

include_once 'sample-wp-widget.php';
add_action( 'widgets_init', function(){
	register_widget( 'Hello_World_Widget' );
});

add_filter( 'the_title', 'modify_titles');

function modify_titles( $title ) {

	return "<i>".$title."</i>";
}

add_action( 'admin_notices', 'hello_haec' );

function hello_haec() {
	$haec_setting = get_option('haec_setting_name');
	
	if (!isset($haec_setting) || ($haec_setting == '')) {
		$haec_setting = "HAEC";
	}
	
	echo "<div id='haec'><p>Hello ".$haec_setting." plugin!</p></div>";
}

add_action('admin_menu', 'haec_options_page');
function haec_options_page() {
	add_submenu_page(
		'options-general.php',     // Parent slug (filename)
		'HAEC Options',            // Page title
		'HAEC Options menu',       // Menu title
		'manage_options',          // Capability
		'haec',                    // menu slug
		'haec_options_page_html'   // callback function
		);
}

function haec_options_page_html() {
	// check user capabilities
	if (!current_user_can('manage_options')) {
		return;
	}
	?>

    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form id="haec_options" action="options.php" method="post">
            <?php
            // output settings fields for the registered setting "haec_options"
            settings_fields('haec_options');
            // output setting sections and their fields
            // (sections are registered for "haec", each field is registered to a specific section)
            do_settings_sections('haec');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

/**
 * register haec_settings_init to the admin_init action hook
 */
add_action('admin_init', 'haec_settings_init');
function haec_settings_init() {
	// register a new setting for "haec" page
	register_setting('haec_options',      // option group 
		  			 'haec_setting_name'  // option name
			);

	// register a new section in the "haec" page
	add_settings_section(
			'haec_settings_section',    // id
			'HAEC Settings Section',    // title
			'haec_settings_section_cb', // callback function
			'haec'                      // page
			);

	// register a new field in the "haec_settings_section" 
	// section, inside the "haec" page
	add_settings_field(
			'haec_settings_field',          // id
			'HAEC Setting',                 // Title
			'haec_settings_field_cb',       // Callback
			'haec',                         // page
			'haec_settings_section'         // section
			);
}

/**
 * callback functions
 */

// section content cb
function haec_settings_section_cb() {
	echo '<p>HAEC Section Introduction.</p>';
}

// field content cb
function haec_settings_field_cb() {
	// get the value of the setting we've registered with register_setting()
	$setting = get_option('haec_setting_name');
	// output the field
	?>
    <input type="text" name="haec_setting_name" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
    <?php
}
