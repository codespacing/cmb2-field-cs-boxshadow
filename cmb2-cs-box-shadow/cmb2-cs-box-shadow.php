<?php

// Exit if accessed directly

if(!defined('ABSPATH'))
	exit;

if(!class_exists('CS_CMB2_BoxShadow_Field')){

	/**
	 * Class CS_CMB2_BoxShadow_Field */
	 
	class CS_CMB2_BoxShadow_Field {
		
		/**
		 * Current version number */
		 
		const VERSION = '1.0';
				
		private $plugin_path;
		private $plugin_url;
		
		public $box_shadow_options;
		public $box_shadow_fields;
	
		/**
		 * Initialize the plugin by hooking into CMB2
		 *
		 * @since 1.0
		 */
		public function __construct(){
					 
			$this->plugin_path = plugin_dir_path( __FILE__ );
			$this->plugin_url = plugin_dir_url( __FILE__ );
				
			add_filter( 'cmb2_render_cs_boxshadow', array( $this, 'cs_render_boxshadow_field' ), 10, 5 );
				
		}
		
	
		/**
		 * Render field
		 *
		 * @since 1.0
		 */
		public function cs_render_boxshadow_field($field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
		
			$field_id = $field->_id();
			$field_title = $field->_name();
			
			/**
			 * Get the field options */
			 
			$field_options = $field->args('options');
					
			/**
			 * Typograpgy fields */
	
			$this->box_shadow_options = wp_parse_args($field_options, array(
				'preview' => true,
				'toggle' => true,
			));
			
			/**
			 * Enqueue scripts & styles */
			 
			$this->cs_enqueue_scripts();
			
			/**
			 * Render */
			
			$inside_class = '';
			 
			if(is_bool($this->box_shadow_options['toggle']) && $this->box_shadow_options['toggle']){ 
			
				$inside_class = 'inside'; ?>

            <div class="cs-boxshadow-fields-toggle postbox cmb-row cmb-repeatable-grouping closed">
                
                <div class="cmbhandle" title="Click to toggle"><br></div>               
                <h3 class="cmb-group-title cmbhandle-title"><?php _e('Toggle Box-Shadow Options', 'cs_boxshadow'); ?></h3>

            <?php } ?>
			
                <div class="cs-boxshadow-fields-container <?php echo $inside_class; ?>" data-field-id="<?php echo $field_id; ?>">
                
                    <?php
                    
                    /**
                     * Horizontal Length */
                    
                    $this->cs_build_range_field(array(
                        'field_object' => $field_type_object,
                        'field_id' => $field_id,
                        'field_value' => $field_escaped_value,
                        'field_name' => 'horizontal_length',
                        'field_label' => 'Horizontal Length',
                    ));
                    
                    /**
                     * Vertical Length */
                    
                    $this->cs_build_range_field(array(
                        'field_object' => $field_type_object,
                        'field_id' => $field_id,
                        'field_value' => $field_escaped_value,
                        'field_name' => 'vertical_length',
                        'field_label' => 'Vertical Length',
                    ));
                    
                    /**
                     * Blur Radius */
                    
                    $this->cs_build_range_field(array(
                        'field_object' => $field_type_object,
                        'field_id' => $field_id,
                        'field_value' => $field_escaped_value,
                        'field_name' => 'blur_radius',
                        'field_label' => 'Blur Radius',
                    ));
                    
                    /**
                     * Spread Radius */
                    
                    $this->cs_build_range_field(array(
                        'field_object' => $field_type_object,
                        'field_id' => $field_id,
                        'field_value' => $field_escaped_value,
                        'field_name' => 'spread_radius',
                        'field_label' => 'Spread Radius',
                    ));
                    
                    /**
                     * Shadow Color */ ?>
                        
                    <div class="cs-boxshadow-element half-size" style="margin-bottom: 13px;">
                         
                        <label for="text_decoration_color" class="cs-field-label"><?php _e('Shadow Color', 'cs_boxshadow'); ?></label>
                
                        <div class="cs-boxshadow-field">
                            <?php 
                            echo $field_type_object->colorpicker(array(
                                'name' => $field_id . '[color]',
                                'desc' => '',
                                'id' => 'color',
                                'value' => isset($field_escaped_value['color']) ? $field_escaped_value['color'] : '#000000',
                                'data-field-id' => $field_id,
                                'data-shadow-property' => 'color',
                            )); 
                            ?>
                        </div>
                        
                    </div><?php
                    
                    /**
                     * Opacity */
                    
                    $this->cs_build_range_field(array(
                        'field_object' => $field_type_object,
                        'field_id' => $field_id,
                        'field_value' => $field_escaped_value,
                        'field_name' => 'opacity',
                        'field_label' => 'Opacity',
						'min' => 0,
						'max' => 1,
						'step' => 0.01,	
						'unit' => '',					
                    ));                
                    
					?>
                    
                    <div style="clear:both;"></div>
                    
                    <?php
										
                    /**
                     * Preview style */
                     
                    if(is_bool($this->box_shadow_options['preview']) && $this->box_shadow_options['preview']){ 
					
						$box_shadow = isset($field_escaped_value['box-shadow']) ? 'box-shadow: ' . $field_escaped_value['box-shadow'] . ';' : ''; ?>
                    
                        <div class="cs-boxshadow-element full-size">
                             
                            <label class="cs-field-label">
								<?php _e('Perview', 'cs_boxshadow'); ?> 
                                <code class="cs-boxshadow-code" data-field-id="<?php echo $field_id; ?>">
                                    <?php echo $box_shadow; ?>
                                </code>
                            </label>
                        
                            <div class="cs-boxshadow-preview" data-field-id="<?php echo $field_id; ?>">
                                <div class="cs_box" style=" <?php echo $box_shadow; ?> "></div>                                
                            </div>
                        
                        </div><?php
                        
                    }
                    
					/**
					 * Box-shadow value */
					 
					echo $field_type_object->input(array(
                        'name' => $field_id . '[box-shadow]',
                        'desc' => '',
                        'id' => 'box-shadow',
                        'type' => 'hidden',
                        'value' => isset($field_escaped_value['box-shadow']) ? $field_escaped_value['box-shadow'] : '',
                        'data-field-id' => $field_id,
                    ));
					
                    ?>
                    
                </div>
           			
            <?php if(is_bool($this->box_shadow_options['toggle']) && $this->box_shadow_options['toggle']){ ?>
				</div>
            <?php } ?>
            				
			<?php         
	
			if(!empty($field->args('desc')))
				echo '<p class="cmb2-metabox-description">'.$field->args('desc').'</p>'; 
			
		}
		
		
		/**
		 * This will build the range filed 
		 *
		 * @since 1.0 
		 */	 
		private function cs_build_range_field($atts = array()){
			
			extract( wp_parse_args( $atts, array(
				'field_object' => '',
				'field_id' => '',
				'field_value' => '',
				'field_name' => '',
				'field_label' => '',
				'min' => -200,
				'max' => 200,
				'step' => 1,
				'unit' => 'px',
			)));
			
			$css_property = str_replace('_', '-', $field_name);

			?>
			
			<div class="cs-boxshadow-element half-size">
				 
				<label for="<?php echo $field_id; ?>" class="cs-field-label">
					<?php _e($field_label, 'cs_boxshadow'); ?>
                	<code class="cs-property-value" data-field-id="<?php echo $field_id; ?>" data-shadow-property="<?php echo str_replace('_', '-', $field_name); ?>">
                    	<?php echo isset($field_value[$field_name]) ? $field_value[$field_name] . $unit : 0 . $unit; ?>
                    </code>
                </label>
				
				<div class="cs-boxshadow-field full-size">
					<button type="button" class="cs-boxshadow-minus button-secondary" data-field-id="<?php echo $field_id; ?>" data-shadow-property="<?php echo str_replace('_', '-', $field_name); ?>">-</button>
					<?php 
					echo $field_object->input(array(
						'name' => $field_id . '['.$field_name.']',
						'desc' => '',
						'id' => $field_id,
						'class' => 'cs-boxshadow-text',
						'type' => 'range',
						'pattern' => '\d*',
						'min' => $min,
						'max' => $max,
						'step' => $step,
						'list' => 'tickmarks_'.$max,
						'value' => isset($field_value[$field_name]) ? $field_value[$field_name] : '0',
						'data-field-id' => $field_id,
						'data-shadow-property' => str_replace('_', '-', $field_name),
						'data-unit' => $unit,
					)); 
					?>
                    <button type="button" class="cs-boxshadow-plus button-secondary" data-field-id="<?php echo $field_id; ?>" data-shadow-property="<?php echo str_replace('_', '-', $field_name); ?>">+</button>
				</div>
                
                <datalist id="tickmarks_200">
                    <option value="-200" label="-200<?php echo $unit; ?>">
                    <option value="-150" label="-150<?php echo $unit; ?>">
                    <option value="-100" label="-100<?php echo $unit; ?>">
                    <option value="-50" label="-50<?php echo $unit; ?>">                                    
                    <option value="0" label="0<?php echo $unit; ?>">
                    <option value="50" label="50<?php echo $unit; ?>">
                    <option value="100" label="100<?php echo $unit; ?>">
                    <option value="150" label="150<?php echo $unit; ?>">
                    <option value="200" label="200<?php echo $unit; ?>">                    
                </datalist>
                
                <datalist id="tickmarks_1">
                    <option value="0" label="0">
                    <option value="1" label="1">
                    <option value="2" label="2">
                    <option value="3" label="3">
                    <option value="4" label="4">
                    <option value="5" label="5">
                    <option value="6" label="6">
                    <option value="7" label="7">
                    <option value="8" label="8">
                    <option value="9" label="9">
                    <option value="10" label="10">                    
                </datalist>
	
			</div>
			
			<?php		 
					
		}

	
		/**
		 * Enqueue scripts and styles
		 *
		 * @since 1.0
		 */
		public function cs_enqueue_scripts(){
			
			/**
			 * CSS */
								
			wp_enqueue_style('cs-boxshadow-style', $this->plugin_url.'/css/style.css', array(), self::VERSION);
			
			/**
			 * JS */
								
			wp_enqueue_script('cs-boxshadow-script', $this->plugin_url.'/js/script.js', array('jquery'), self::VERSION);
			
		}
		
	}
	
	$CS_CMB2_BoxShadow_Field = new CS_CMB2_BoxShadow_Field();
	
}
		