<?php
/**
 * Plugin Name: Post Countdown
 * Plugin URI: http://headwaymarketing.com/wordpress-post-countdown-plugin
 * Description: A widget that shows a countdown to a milestone post.
 * Version: 1.0
 * Author: Headway Marketing
 * Author URI: http://headwaymarketing.com
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

add_action( 'widgets_init', 'load_widgets' );

/**
 * Register the widget.
 */
function load_widgets() {
	register_widget( 'Post_Countdown' );
}

class Post_Countdown extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function Post_Countdown() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'post-countdown', 'description' => __('A widget that shows a countdown to a milestone post.', 'post-countdown') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'post-countdown-widget' );
		/* Create the widget. */
		$this->WP_Widget( 'post-countdown-widget', __('Post Countdown'), $widget_ops, $control_ops );
	}
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$text_before = $instance['text_before'];
		$countdown_from = $instance['countdown_from'];
		$text_after = $instance['text_after'];
		/* Before widget (defined by themes). */
		echo $before_widget;
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		/* Display Text Before Section. */
		if ( $text_before )
			echo "<p>" . $text_before;
		/* Get the countdown. */
		if ( $countdown_from )
			$post_count = wp_count_posts();
			$published_posts = $post_count->publish;
			$countdown = $countdown_from-$published_posts;
			echo " " . $countdown . " ";
		/* Display Text After Section. */
		if ( $text_after )
			echo $text_after . "</p>";
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text_before'] = strip_tags( $new_instance['text_before'] );
		$instance['countdown_from'] = strip_tags( $new_instance['countdown_from'] );
		$instance['text_after'] = strip_tags( $new_instance['text_after'] );
		return $instance;
	}
	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Post Countdown'), 'text_before' => __('Only'), 'countdown_from' => __('1000'), 'text_after' => __('until my 1000th post.') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<!-- Text Before: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'text_before' ); ?>"><?php _e('Text Before:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'text_before' ); ?>" name="<?php echo $this->get_field_name( 'text_before' ); ?>" value="<?php echo $instance['text_before']; ?>" style="width:100%;" />
		</p>
		<!-- Countdown From: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'countdown_from' ); ?>"><?php _e('Countdown From:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'countdown_from' ); ?>" name="<?php echo $this->get_field_name( 'countdown_from' ); ?>" value="<?php echo $instance['countdown_from']; ?>" style="width:100%;" />
		</p>
		<!-- Text After: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'text_after' ); ?>"><?php _e('Text After:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'text_after' ); ?>" name="<?php echo $this->get_field_name( 'text_after' ); ?>" value="<?php echo $instance['text_after']; ?>" style="width:100%;" />
		</p>
	<?php
	}
}
?>