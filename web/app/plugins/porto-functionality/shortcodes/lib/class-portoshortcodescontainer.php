<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) && ! class_exists( 'PortoShortCodesContainer' ) ) :
	/**
	 * Class PortoShortCodesContainer
	 */
	abstract class PortoShortCodesContainer extends WPBakeryShortCodesContainer {
		/**
		 * @param string $controls
		 * @param string $extended_css
		 *
		 * @return string
		 * @throws \Exception
		 */
		public function getColumnControls( $controls = 'full', $extended_css = '' ) {
			$controls_arr = array();

			$controls_arr['start'] = '<div class="vc_controls vc_controls-visible controls_column' . ( ! empty( $extended_css ) ? " {$extended_css}" : '' ) . '">';
			$controls_arr['end']   = '</div>';

			if ( 'bottom-controls' === $extended_css ) {
				$controls_arr['title'] = sprintf( esc_attr__( 'Append to this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) );
			} else {
				$controls_arr['title'] = sprintf( esc_attr__( 'Prepend to this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) );
			}

			$controls_arr['move'] = '<a class="vc_control column_move vc_column-move" data-vc-control="move" href="#" title="' . sprintf( esc_attr__( 'Move this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><i class="vc-composer-icon vc-c-icon-dragndrop"></i></a>';
			$moveAccess           = vc_user_access()->part( 'dragndrop' )->checkStateAny( true, null )->get();
			if ( ! $moveAccess ) {
				$controls_arr['move'] = '';
			}
			$controls_arr['add']    = '<a class="vc_control column_add" data-vc-control="add" href="#" title="' . $controls_arr['title'] . '"><i class="vc-composer-icon vc-c-icon-add"></i></a>';
			$controls_arr['edit']   = '<a class="vc_control column_edit" data-vc-control="edit" href="#" title="' . sprintf( esc_html__( 'Edit this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><i class="vc-composer-icon vc-c-icon-mode_edit"></i></a>';
			$controls_arr['clone']  = '<a class="vc_control column_clone" data-vc-control="clone" href="#" title="' . sprintf( esc_html__( 'Clone this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><i class="vc-composer-icon vc-c-icon-content_copy"></i></a>';
			$controls_arr['delete'] = '<a class="vc_control column_delete" data-vc-control="delete" href="#" title="' . sprintf( esc_html__( 'Delete this %s', 'js_composer' ), strtolower( $this->settings( 'name' ) ) ) . '"><i class="vc-composer-icon vc-c-icon-delete_empty"></i></a>';
			$controls_arr['full']   = $controls_arr['move'] . $controls_arr['add'] . $controls_arr['edit'] . $controls_arr['clone'] . $controls_arr['delete'];

			$editAccess = vc_user_access_check_shortcode_edit( $this->shortcode );
			$allAccess  = vc_user_access_check_shortcode_all( $this->shortcode );

			if ( ! empty( $controls ) ) {
				if ( is_string( $controls ) ) {
					$controls = array( $controls );
				}
				$controls_string = $controls_arr['start'];
				foreach ( $controls as $control ) {
					$control_var = $control;
					if ( ( $editAccess && 'edit' === $control ) || $allAccess ) {
						if ( isset( $controls_arr[ $control_var ] ) ) {
							$controls_string .= $controls_arr[ $control_var ];
						}
					}
				}
				return $controls_string . $controls_arr['end'];
			}

			if ( $allAccess ) {
				return $controls_arr['start'] . $controls_arr['full'] . $controls_arr['end'];
			} elseif ( $editAccess ) {
				return $controls_arr['start'] . $controls_arr['edit'] . $controls_arr['end'];
			}

			return $controls_arr['start'] . $controls_arr['end'];
		}
	}
endif;
