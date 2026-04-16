<?php 

if ( class_exists( 'WPForms_Template', false ) ) :
/**
 * Driver Template
 * Template for WPForms.
 */
class WPForms_Template_driver_template extends WPForms_Template {

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Template name
		$this->name = 'Driver Template';

		// Template slug
		$this->slug = 'driver_template';

		// Template description
		$this->description = 'Driver Template testing';

		// Template field and settings
		$this->data = array (
	'fields' => array (
		1 => array (
			'id' => '1',
			'type' => 'text',
			'label' => 'Single Line Text',
			'size' => 'medium',
			'limit_count' => '1',
			'limit_mode' => 'characters',
		),
		2 => array (
			'id' => '2',
			'type' => 'name',
			'label' => 'Name',
			'format' => 'first-last',
			'required' => '1',
			'size' => 'medium',
		),
		3 => array (
			'id' => '3',
			'type' => 'phone',
			'label' => 'Phone',
			'format' => 'smart',
			'size' => 'medium',
		),
	),
	'field_id' => 4,
	'settings' => array (
		'form_title' => 'Driver Template',
		'form_desc' => 'Driver Template testing',
		'submit_text' => 'Submit',
		'submit_text_processing' => 'Sending...',
		'ajax_submit' => '1',
		'notification_enable' => '1',
		'notifications' => array (
			1 => array (
				'notification_name' => 'Default Notification',
				'email' => '{admin_email}',
				'subject' => 'New Entry: Blank Form',
				'sender_name' => 'Global Logistics',
				'sender_address' => '{admin_email}',
				'message' => '{all_fields}',
				'file_upload_attachment_fields' => array (
				),
				'entry_csv_attachment_entry_information' => array (
				),
				'entry_csv_attachment_file_name' => 'entry-details',
			),
		),
		'confirmations' => array (
			1 => array (
				'name' => 'Default Confirmation',
				'type' => 'message',
				'message' => '<p>Thanks for contacting us! We will be in touch with you shortly.</p>',
				'message_scroll' => '1',
				'page' => '540',
				'message_entry_preview_style' => 'basic',
			),
		),
		'antispam' => '1',
		'anti_spam' => array (
			'country_filter' => array (
				'action' => 'allow',
				'country_codes' => array (
				),
				'message' => 'Sorry, this form does not accept submissions from your country.',
			),
			'keyword_filter' => array (
				'message' => 'Sorry, your message can\'t be submitted because it contains prohibited words.',
			),
		),
		'form_tags' => array (
		),
	),
	'meta' => array (
		'template' => 'driver_template',
	),
);
	}
}
new WPForms_Template_driver_template();
endif;

?>