<?php
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
