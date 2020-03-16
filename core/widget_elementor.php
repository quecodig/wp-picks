<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */



class Elementor_CPT_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'mincrease_widget';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'MindFY Increase CPT', 'mincrease' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-code';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'mincrease' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'field_type',
			[
				'label' => __( 'Campo', 'mincrease' ),
				'type' =>  \Elementor\Controls_Manager::SELECT2,
				'options' => [
					'event_state' => __( 'Estado', 'mincrease' ),
					'event_type' => __( 'Tipo', 'mincrease' ),
					'event_depo' => __( 'Deporte', 'mincrease' ),
					'event_desc' => __( 'Descripción', 'mincrease' ),
					'event_price' => __( 'Cuota', 'mincrease' ),
					'event_date' => __( 'Hora', 'mincrease' ),
					'event_aprx' => __( 'Probabilidad', 'mincrease' ),
					'event_stake' => __( 'Stake', 'mincrease' ),
					'event_anali' => __( 'Analisis', 'mincrease' ),
					'event_image' => __( 'Image', 'mincrease' )
                ],
                'multiple' => false,
                'default' => true
			]
        );

		$this->add_control(
			'post_id',
			[
				'label' => __( 'Post Id', 'mincrease' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type Id', 'mincrease' ),
				'default' => get_the_ID(),
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$field_type = $settings['field_type'];
		if($field_type === "event_state"){
			$text_state = get_post_meta($settings['post_id'], $field_type, true);
			switch ($text_state) {
				case '0':
					$text_custom_field = "En espera";
				break;

				case '1':
					$text_custom_field = "Perdida";
				break;

				case '2':
					$text_custom_field = "Reembolso";
				break;

				case '3':
					$text_custom_field = "Ganada";
				break;
			}
		}else if($field_type === "event_image"){
			if ( has_post_thumbnail() ) { the_post_thumbnail(); }
		}else{
			$text_custom_field = get_post_meta($settings['post_id'], $field_type, true);
			echo '<span class="cpt-text">' . $text_custom_field . '</span>' ;
		}

	}   

}