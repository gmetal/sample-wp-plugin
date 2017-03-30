<?php
class Hello_World_Widget extends WP_Widget {
	
	// Constructor
	public function __construct() {
		$widget_ops = array (
				'classname' => 'hello_world_widget',
				'description' => 'Hello World Widget!' 
		);
		
		wp_enqueue_script('sample-plugin-script', plugins_url('/js/sample.js', __FILE__), array('jquery'), '1.0.0', true); 
		
		parent::__construct ( 'hello_world_widget', 'Hello World Widget', $widget_ops );
	}
	public function widget($args, $instance) {
		echo $args ['before_widget'];
		echo '<p>' . esc_html__ ( 'Hello, ' . $instance ['name'], 'text_domain' ) . '</p>';
		echo '<table id="my_tbl"></table>';
		echo '<button id="click_btn">Click me!</button><br/>';
		echo '<button id="hide_btn">Hide Table!</button><br/>';
		echo '<button id="show_btn">Show Table!</button>';
		echo $args ['after_widget'];
	}
	public function form($instance) {
		$name = esc_html__ ( 'world!', 'text_domain' );
		// Check if we already have a configured value
		if (! empty ( $instance ['name'] )) {
			$name = $instance ['name'];
		}
		?>
<!-- Output the form -->
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>">
		<?php esc_attr_e ( 'Name:', 'text_domain' );?>
	</label> <input class="widefat"
		id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>"
		type="text" value="<?php echo esc_attr( $name ); ?>">
</p>
<?php
	}
	public function update($new_instance, $old_instance) {
		$instance = array ();
		$instance ['name'] = 'world!';
		
		if ((! empty ( $old_instance )) && (! empty ( $old_instance ['name'] ))) {
			$instance ['name'] = $old_instance ['name'];
		}
		
		if ((! empty ( $new_instance )) && (! empty ( $new_instance ['name'] ))) {
			$instance ['name'] = strip_tags ( $new_instance ['name'] );
		}
		
		return $instance;
	}
}

