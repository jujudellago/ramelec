<?php

// Porto Lightbox Container
add_shortcode( 'porto_lightbox_container', 'porto_shortcode_lightbox_container' );
add_action( 'vc_after_init', 'porto_load_lightbox_container_shortcode' );

function porto_shortcode_lightbox_container( $atts, $content = null ) {
	ob_start();
	if ( $template = porto_shortcode_template( 'porto_lightbox_container' ) ) {
		include $template;
	}
	return ob_get_clean();
}

function porto_load_lightbox_container_shortcode() {
	$animation_type     = porto_vc_animation_type();
	$animation_duration = porto_vc_animation_duration();
	$animation_delay    = porto_vc_animation_delay();
	$custom_class       = porto_vc_custom_class();

	vc_map(
		array(
			'name'         => 'Porto ' . __( 'Lightbox Container', 'porto-functionality' ),
			'base'         => 'porto_lightbox_container',
			'category'     => __( 'Porto', 'porto-functionality' ),
			'icon'         => 'porto_vc_lightbox',
			'is_container' => true,
			'js_view'      => 'VcColumnView',
			'params'       => array(
				array(
					'type'       => 'textfield',
					'heading'    => __( 'Delegate', 'porto-functionality' ),
					'param_name' => 'delegate',
					'value'      => 'a',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => __( 'Type', 'porto-functionality' ),
					'param_name' => 'type',
					'value'      => array(
						__( 'Image', 'porto-functionality' )  => 'image',
						__( 'Iframe', 'porto-functionality' ) => 'iframe',
						__( 'Inline', 'porto-functionality' ) => 'inline',
						__( 'Ajax', 'porto-functionality' )   => 'ajax',
					),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => __( 'Enable Gallery', 'porto-functionality' ),
					'param_name' => 'gallery',
					'std'        => 'yes',
					'value'      => array( __( 'Yes', 'js_composer' ) => 'yes' ),
				),
				$custom_class,
				$animation_type,
				$animation_duration,
				$animation_delay,
			),
		)
	);

	if ( ! class_exists( 'WPBakeryShortCode_Porto_Lightbox_Container' ) ) {
		class WPBakeryShortCode_Porto_Lightbox_Container extends PortoShortCodesContainer {
		}
	}
}
