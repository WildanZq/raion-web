<?php
/* at the top of 'check.php' */
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* 
        Up to you which header to send, some prefer 404 even if 
        the files does exist for security
    */
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );

    /* choose the appropriate page to redirect users */
    die( header( 'location: ../' ) );
}

session_start();
class FlashMessage {
    public static function get_err() {
        if (!isset($_SESSION['err_message'])) {
            return null;
        }
        $messages = $_SESSION['err_message'];
        unset($_SESSION['err_message']);
        return $messages;
    }

    public static function set_err($message) {
        $_SESSION['err_message'] = $message;
    }

    public static function get_success() {
        if (!isset($_SESSION['success_message'])) {
            return null;
        }
        $messages = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        return $messages;
    }

    public static function set_success($message) {
        $_SESSION['success_message'] = $message;
    }
}
?>
