<?php
class SF_Field_Checkbox extends SF_Field {
	function __construct( $data = array() ) {
		$data['type'] = 'checkbox';
		parent::__construct( $data );
	}
	public function get_html( $form ){
		$data = $this->sanitize_data( $this->data );
		extract( $data );

		$html = $before;

		if( $field_wrap ){
			$html .= sprintf( '<div class="%1$s"%2$s>', $this->form_pitc_class('sffw', $id, $type, $class), $attr );
		}

		$html .= $field_before;
			// label
			$html .= $label_wrap_before;
			$html .= $this->form_field_label( $data );

			// description
			if( ! empty($desc) ){
				$html .= sprintf( '<div class="%1$s">%2$s</div>', $this->form_pitc_class('sffdw', $id, $type), $desc );
			}

			// input
			$html .= $input_wrap_before;
			if( $input_wrap ){
				$html .= sprintf( '<div class="%1$s %2$s"%3$s>', $this->form_pitc_class('sffew', $id, $type), $input_wrap_class, $input_wrap_attr );
			}
			$html .= $input_before;
			foreach( $choices as $key => $label ){
				if( empty($label) ){
					continue;
				}

				$child_input_attr = '';
				$child_input_class = '';
				$_label = $label;

				if( is_array($_label) && isset($_label['child_input_before']) ) {
					$html .= $_label['child_input_before'];
				}

				if( isset($label->id) && isset($label->name) ){
					$key = $label->id;
					$label = $label->name;
				}
				elseif( $label instanceof SF_Data ){
					$key = $label->get_id();
					$label = $label->get_name();
				}
				elseif( isset($label['key']) && isset($label['name']) ){
					$key = $label['key'];
					$label = $label['name'];
					$child_input_attr = isset($_label['input_attr']) ? $_label['input_attr'] : '';
					$child_input_class = isset($_label['input_class']) ? $_label['input_class'] : '';
				}
				elseif( is_array($label) ) {
					$child_input_attr = isset($label['attr']) ? $label['attr'] : '';
					$label = $l['label'];
				}

				$checked = is_array($value) && in_array($key, $value) ? ' checked="checked"' : '';
				$html .= sprintf( 
					'<label class="%6$s"><input id="%1$s_%2$s" name="%3$s[]" value="%2$s" type="checkbox"%4$s%6$s /> %5$s</label>', 
					$id, $key, $name, $checked, $label, $child_input_class, $child_input_attr
				);

				if( is_array($_label) && isset($_label['child_input_after']) ) {
					$html .= $_label['child_input_after'];
				}
			}
			$html .= $input_after;
			if( $input_wrap ){
				$html .= '</div>';
			}

		$html .= $field_after;
		
		if( isset($desc_after) ){
			if( ! empty($desc_after) ){
				$html .= sprintf( '<div class="%1$s">%2$s</div>', $this->form_pitc_class('sffdaw', $id, $type), $desc_after );
			}
		}

		if( $field_wrap ){
			$html .= '</div>';
		}

		return $html;
	}
}

?>