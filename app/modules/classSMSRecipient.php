<?php
/**
 * ExampleRecipient recipient
 *
 * @package notification-slugnamexx
 */


// use BracketSpace\Notification\Abstracts;
// use BracketSpace\Notification\Defaults\Field;
// use BracketSpace\Notification\Traits\Users;


if ( ! class_exists( 'BracketSpace\Notification\Abstracts' )
	or !class_exists( 'BracketSpace\Notification\Defaults\Field' )) {
	class SmsRecipient extends BracketSpace\Notification\Abstracts\Recipient {
		
		/**
		 * ExampleRecipient constructor
		 *
		 * @since [Next]
		 */
		public function __construct() {
			parent::__construct( [
				'slug'          => 'sms',
				'name'          => __( 'SMS', 'ecrannoir' ),
				'default_value' => '',
			] );
		}

		/**
		 * {@inheritdoc}
		 *
		 * @param  string $value raw value saved by the user.
		 * @return array         array of resolved values
		 */
		public function parse_value( $value = '' ) {

			if ( empty( $value ) ) {
				$value = $this->get_default_value();
			}

			return [ esc_url( $value ) ];

		}

		/**
		 * {@inheritdoc}
		 *
		 * @return object
		 */
		public function input() {

			return new BracketSpace\Notification\Defaults\Field\InputField( [
				'label'     => __( 'SMS', 'ecrannoir' ),
				'name'      => 'sls',
				'css_class' => 'recipient-value',
				'value'     => 'sms',
				'pretty'    => true,
				// 'options'   => $opts,
			] );				

		}
		
	}
}


/**
 * ExampleRecipient recipient
 */
// class ExampleRecipient extends Abstracts\Recipient {

// 	use Users;

// 	/**
// 	 * ExampleRecipient constructor
// 	 *
// 	 * @since [Next]
// 	 */
// 	public function __construct() {
// 		parent::__construct( [
// 			'slug'          => 'user',
// 			'name'          => __( 'User', 'notification' ),
// 			'default_value' => get_current_user_id(),
// 		] );
// 	}

	/**
	 * {@inheritdoc}
	 *
	 * @since  [Next]
	 * @param  string $value Raw value saved by the user.
	 * @return array         Array of resolved values
	 */
	// public function parse_value( $value = '' ) {

	// 	if ( empty( $value ) ) {
	// 		$value = [ $this->get_default_value() ];
	// 	}

	// 	return [ $value ];

	// }

// 	/**
// 	 * {@inheritdoc}
// 	 *
// 	 * @since  [Next]
// 	 * @return object
// 	 */
// 	public function input() {

// 		$users = $this->get_all_users();

// 		$opts = [];

// 		foreach ( $users as $user ) {
// 			$opts[ $user->ID ] = esc_html( $user->display_name ) . ' (ID: ' . $user->ID . ')';
// 		}

// 		return new Field\SelectField( [
// 			'label'     => __( 'Recipient', 'notification' ),
// 			'name'      => 'recipient',
// 			'css_class' => 'recipient-value',
// 			'value'     => $this->get_default_value(),
// 			'pretty'    => true,
// 			'options'   => $opts,
// 		] );

// 	}

// }
