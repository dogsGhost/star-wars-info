<?php

require_once(plugin_dir_path(__FILE__) . 'star-wars-info-get-data.php');

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
		// use value from database to query api
		$swi_meta_key = get_post_custom_values('_swi_meta_key');

		// only display if value is set
		if ($swi_meta_key) {
			$swi_val = $swi_meta_key[0];
			$data = swi_get_data($swi_val);

			echo $args['before_widget'];

			if (!empty($instance['title'])) {
				// widget title
				echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
			} ?>

			<!-- widget output -->
			<div class="swi-container">
				<h4 class="swi-title">Character info for <?php echo $data->name ?></h4>
				<dl class="swi-dl">
					<dt class="swi-dt">height:</dt>
					<dd class="swi-dd"><?php echo $data->height ?>cm</dd>

					<dt class="swi-dt">weight:</dt>
					<dd class="swi-dd"><?php echo $data->mass ?>kg</dd>

					<dt class="swi-dt">eye color:</dt>
					<dd class="swi-dd"><?php echo $data->eye_color ?></dd>
				</dl>
			</div>
	<?php 
			echo $args['after_widget'];
		} // end if
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