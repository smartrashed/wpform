<?php
class SF_Field_Select extends SF_Field {
	function __construct( $data = array() ) {
		$data['type'] = 'select';
		parent::__construct( $data );
	}
	public function form_field_html(){
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
			$html .= sprintf( 
				'<select class="%1$s %5$s" id="%2$s" name="%3$s"%4$s>', 
				$this->form_pitc_class('sff', $id, $type), 
				$id, 
				$name, 
				$input_attr, 
				$input_class 
			);

			foreach( $choices as $key => $label ){
				if( empty($label) ){
					continue;
				}
				elseif( is_array($label) && isset($label['optgroup_open']) ) {
					$html .= $label['optgroup_open'];
					continue;
				}
				elseif( is_array($label) && isset($label['optgroup_close']) ) {
					$html .= $label['optgroup_close'];
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

				$selected = esc_attr($value) == esc_attr($key) ? ' selected="selected"' : '';
				$html .= sprintf( 
					'<option value="%1$s"%2$s class="%4$s" %5$s>%3$s</option>', 
					$key, $selected, $label, $child_input_class, $child_input_attr
				);

				if( is_array($_label) && isset($_label['child_input_after']) ) {
					$html .= $_label['child_input_after'];
				}
			}
			$html .= '</select>';
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
	function get_html(){
		return $this->form_field_html();
	}
	function render(){
		echo $this->get_html();
	}
}

?>