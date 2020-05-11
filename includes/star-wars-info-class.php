<?php

/**
 * @todo move api request to server-side
 * @todo change meta key name used from 'test field'
 */

/**
 * Adds Star Wars Info widget.
 */
class SWI_Widget extends WP_Widget
{

	/**
	 * Register widget with WordPress.
	 */
	function __construct()
	{
		parent::__construct(
			'swi_widget', // Base ID
			esc_html__('Star Wars Info', 'swi_domain'), // Name
			array(
				'description' => esc_html__('A Star Wars Info Widget', 'swi_domain'),
			) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance)
	{
		// value from database
		$swi_val = get_post_custom_values('test field')[0];

		echo $args['before_widget'];

		if (!empty($instance['title'])) {
			// widget title
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}

		// widget output
		echo '
    <div id="sw-app" class="sw-app">
			<div id="sw-dashboard" class="sw-dashboard">
				...loading dashboard...
			</div>
		</div>
		<script>
			window.addEventListener("load", loadSWI(' . $swi_val . '));
		</script>';

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('Star Wars Info', 'swi_domain');
?>
		<!-- title markup -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
				<?php esc_attr_e('Title:', 'swi_domain'); ?>
			</label>
			<input 
				class="widefat" 
				id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
				name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
				type="text" 
				value="<?php echo esc_attr($title); ?>">
		</p>
<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';

		return $instance;
	}
} // class SWI_Widget

?>