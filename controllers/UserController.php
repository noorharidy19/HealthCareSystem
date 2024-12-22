<?php
require_once(__DIR__ . '/../models/UsersModel.php');

class UserController {
    public static function log() {
        $result = User::login();
        if ($result) {
            echo "Login Successful";
        } else {
            echo "Login Failed";
        }
    }
    public static function out() {
        $result = User::logout();
        if ($result) {
            echo "logout successfully";
        } else {
            echo " failed";
        }
    }
}
?>