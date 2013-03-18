<?php
class Builder_TinyMCE_Control extends WP_Customize_Control {
	public $type = 'tinymce';
	
	
	public function render_content() {
		$rich_editing = user_can_richedit();
		?>
		<span class="customize-control-title"><?php echo $this->label; ?></span>
		<textarea id="<?php echo $this->id; ?>" style="display:none" <?php echo $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
		<?php
		$quick_tags = false;
		$tinymce_options = array(
			'teeny' => false,
			'media_buttons' => true,
			'quicktags' => $quick_tags,
			'textarea_rows' => 25,
			'tinymce' => array(
				'onchange_callback' => 'builder_tinymce_onchange_callback',
				'theme_advanced_buttons1_add' => 'code'
			),
			'editor_css' => '<style type="text/css">body { background: #000; }</style>',
		);
		
		?>
		<style type="text/css">
			.wp-full-overlay.expanded.wider {
				margin-left:550px;
			}
			.wp-full-overlay.expanded.wider #customize-controls {
				width:550px;
			}
		</style>
		
		<script type="text/javascript">
			jQuery(document).ready( function() {
				// Our tinyMCE function to fire on every change
				window.builder_tinymce_onchange_callback = function(inst) {
					
					var content = tinyMCE.activeEditor.getContent();
										
					jQuery('#<?php echo $this->id; ?>').html(content).trigger('change');
				}
				window.builder_check_sidebar = function() {
					var sectionClicked = jQuery(this).attr('id');
					if( sectionClicked == 'customize-section-builder_email_content' && jQuery(this).hasClass('open')) {
						jQuery('.wp-full-overlay.expanded').addClass('wider')
					} else {
						jQuery('.wp-full-overlay.expanded').removeClass('wider');
					}
				}
				// If the tinyMCE editor is open then widen the sidebar
				// Slide animation is already handled with css transitions
				jQuery('#customize-theme-controls > ul > li').bind('click', builder_check_sidebar);
				jQuery('#customize-info').bind('click', builder_check_sidebar)
			});
		</script>
		<?php
		
		wp_editor(esc_textarea( $this->value() ),'content_tinymce', $tinymce_options);
		
	}
	public function enqueue() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('editor');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');
	}
}
?>