<?php 
namespace Elementor;

if( !defined ( 'ABSPATH' ) )exit;

class HTevent_Elementor_Widget_Process extends Widget_Base{
	public function get_name(){
		return 'htevent_process';
	}
	public function get_title(){
		return __('HTevent:Work Process','htevent');
	}
	public function get_icon(){
		return 'eicon-import-export';
	}
	public function get_categories(){
		return ['htevent'];
	}
     public function get_style_depends() {
        return [];
    }

    public function get_script_depends() {
        return [];
    }
	protected function _register_controls(){
		$this->start_controls_section(
            'htevent-process',
            [
                'label' => __( 'Work Process', 'htevent' ),
            ]
        );

        $this->add_control(
            'htevent_process_style',
            [
                'label'     => __( 'Work Process style', 'htevent' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => [
                    '1'     => __( 'Style One', 'htevent' ),
                    '2'     => __( 'Style Two', 'htevent' ),
                ],
            ]
        );

        $this->add_control(
            'htevent_work_process_icon',
            [
                'label' => __( 'Work Process Icon', 'htevent' ),
                'type' => Controls_Manager::ICON,
            ]
        );

        $this->add_control(
            'htevent_work_process_title',
            [
                'label'     => __( 'Work Process Title', 'htevent' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Collect Information'
            ]
        );

        $this->add_control(
            'htevent_work_process_desc',
            [
                'label'     => __( 'Work Process Title', 'htevent' ),
                'type'      => Controls_Manager::WYSIWYG,
                'default'   => __('Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature','htevent'),
            ]
        );

    
        $this->end_controls_section();

        //style css
		$this->start_controls_section(
            'htevent_process_style_tab',
            [
                'label'  => __('Style','htevent'),
                'tab'    => Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs(
            'process_style_tab'
        );
        //title start
        $this->add_control(
            'title_options',
            [
                'label' => __( 'Title', 'htevent' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'htevent_title',
            [
                'label'     => __( 'Color', 'htevent' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .htevent-work-process-one .content h4' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htevent-work-process-two h4' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'htevent_border',
            [
                'label'     => __( 'Border', 'htevent' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .htevent-work-process-one .content' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .htevent-work-process-two h4::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => __( 'Typography', 'htevent' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .htevent-work-process-one .content h4, .htevent-work-process-two h4',
            ]
        );
        $this->add_responsive_control(
            'htevent_title_margin',
            [
                'label'         => __( ' Margin', 'htevent' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .htevent-work-process-one .content h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '{{WRAPPER}} .htevent-work-process-two h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        //end title
        //description start
        $this->add_control(
            'description_options',
            [
                'label' => __( 'Description', 'htevent' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'htevent_description',
            [
                'label'     => __( 'Color', 'htevent' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .htevent-work-process-one .content p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htevent-work-process-two p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'label'     => __( 'Typography', 'htevent' ),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .htevent-work-process-one .content p,{{WRAPPER}} .htevent-work-process-two p',
            ]
        );
        $this->add_responsive_control(
            'htevent_desc_margin',
            [
                'label'         => __( ' Margin', 'htevent' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .htevent-work-process-one .content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '{{WRAPPER}} .htevent-work-process-two p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        //end description
        //icon start
        $this->add_control(
            'icon_options',
            [
                'label' => __( 'Icon', 'htevent' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'htevent_icon',
            [
                'label'     => __( 'Color', 'htevent' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .htevent-work-process-one .icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htevent-work-process-two i' => 'color: {{VALUE}};',
                ],
            ]
        );
        

        $this->add_control(
            'htevent_icon_size',
            [
                'label' => __( 'Font Size', 'htevent' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .htevent-work-process-one .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .htevent-work-process-two i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'htevent_icon_margin',
            [
                'label'         => __( 'Margin', 'htevent' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .htevent-work-process-one .icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '{{WRAPPER}} .htevent-work-process-two i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );


        //end icon
        $this->end_controls_section();

	}
	protected function render(){ 

		$settings = $this->get_settings_for_display();

		if( $settings['htevent_process_style']== '1' ):
		?>
        <div class="htevent-work-process-one">
            <?php if(!empty( $settings['htevent_work_process_icon'] )){
               echo sprintf('<div class="icon"><i class="%s"></i></div>', $settings['htevent_work_process_icon'] );

            } ?>
            <div class="content">
                <?php if( !empty( $settings['htevent_work_process_title'] ) ){
                    echo '<h4>'.esc_html( $settings['htevent_work_process_title'] ).'</h4>';
                }
                if( !empty( $settings['htevent_work_process_desc'] ) ){
                    echo '<p>'.esc_html( $settings['htevent_work_process_desc'] ).'</p>';
                }

                 ?>
            </div>
            
        </div>
		<?php else: ?> 
        <div class="htevent-work-process-two">

            <?php if(!empty( $settings['htevent_work_process_icon'] )){
               echo sprintf('<i class="%s"></i>', $settings['htevent_work_process_icon'] );

            } ?>

            <?php if( !empty( $settings['htevent_work_process_title'] ) ){
                    echo '<h4>'.esc_html( $settings['htevent_work_process_title'] ).'</h4>';
                }
                if( !empty( $settings['htevent_work_process_desc'] ) ){
                    echo '<p>'.esc_html( $settings['htevent_work_process_desc'] ).'</p>';
                }
            ?>
            
        </div>
        <?php endif; 

	}
	protected function _content_template(){

	}

}
plugin::instance()->widgets_manager->register_widget_type( new HTevent_Elementor_Widget_Process() );