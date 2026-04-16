<?php
/**
 * Handling all the Notification calls in Login Customizer.
 * 
 * @package 	    LoginCustomizer
 * @author 			WPBrigade
 * @copyright 		Copyright (c) 2021, WPBrigade
 * @link 			https://loginpress.pro/
 * @license			https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since 2.1.2
 * 
 */


namespace LoginCustomizer\Includes;

  class Notification {

    /** * * * * * * * *
    * Class constructor
    * * * * * * * * * */
    public function __construct() {

      $this->_hooks();
    }


    /**
    * Hook into actions and filters
    * @version 2.1.2
    */
    private function _hooks() {

		add_action( 'admin_init', array( $this, 'logincustomizer_review_notice' ) );
    }

    /**
  	 * Ask users to review our plugin on WordPress.org
  	 *
  	 * @return boolean false
	 * @since 2.1.2
  	 */
  	public function logincustomizer_review_notice() {

  		$this->logincustomizer_review_dismissal();
  		$this->logincustomizer_review_pending();

  		$activation_time 	= get_site_option( 'logincustomizer_active_time' );
		$review_dismissal	= get_site_option( 'logincustomizer_review_dismiss' );
		  
  		if ( 'yes' == $review_dismissal ) return;
		  
		if ( ! $activation_time ) :

			$activation_time = time();
			add_site_option( 'logincustomizer_active_time', $activation_time );
			  
  		endif;

		  // 604800 = 7 Days in seconds.
  		if ( time() - $activation_time > 604800 ) :

			wp_enqueue_style( 'logincustomizer_notification', LOGINCUST_FREE_RESOURCES . '/css/style-review.css', array(), LOGINCUST_FREE_VERSION );
			add_action( 'admin_notices' , array( $this, 'logincustomizer_review_notice_message' ) );
			  
  		endif;

  	}


    /**
  	 *	Check and Dismiss review message.
  	 *
  	 *	@since 2.1.2
  	 */
  	private function logincustomizer_review_dismissal() {

  		if ( ! is_admin() ||
  			! current_user_can( 'manage_options' ) ||
  			! isset( $_GET['_wpnonce'] ) ||
  			! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'logincustomizer-review-nonce' ) ||
  			! isset( $_GET['logincustomizer_review_dismiss'] ) ) :

  			return;
  		endif;

  		add_site_option( 'logincustomizer_review_dismiss', 'yes' );
  	}

    /**
  	 * Set time to current so review notice will popup after 14 days
  	 *
  	 * @since 2.1.2
  	 */
  	function logincustomizer_review_pending() {

  		if ( ! is_admin() ||
  			! current_user_can( 'manage_options' ) ||
  			! isset( $_GET['_wpnonce'] ) ||
  			! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'logincustomizer-review-nonce' ) ||
  			! isset( $_GET['logincustomizer_review_later'] ) ) :
			  
  			return;
  		endif;

  		// Reset Time to current time.
  		update_site_option( 'logincustomizer_active_time', time() );
  	}

    /**
  	 * Review notice message
  	 *
  	 * @since  2.1.2
  	 */
  	public function logincustomizer_review_notice_message() {

  		$scheme      = ( wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY ) ) ? '&' : '?';
  		$url         = $_SERVER['REQUEST_URI'] . $scheme . 'logincustomizer_review_dismiss=yes';
  		$dismiss_url = wp_nonce_url( $url, 'logincustomizer-review-nonce' );

  		$_later_link = $_SERVER['REQUEST_URI'] . $scheme . 'logincustomizer_review_later=yes';
  		$later_url   = wp_nonce_url( $_later_link, 'logincustomizer-review-nonce' ); ?>


  		<?php
  	}
}
