<?php
/**
 * Handles the login process: Verifies, then logs in, a valid user, or throws an
 * error if login credentials are faulty.
 *
 * TODO: handle the error situations in the else clauses.
 *
 * PHP version 5.3.28
 *
 * @category Default
 * @package  Default
 * @author   Roy Vanegas <roy@thecodeeducators.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://roy.vanegas.org Roy Vanegas
 */

session_start();

require_once "includes/main.php";

if (isset($_POST["submitted"])) {
    if (1 == $_POST["submitted"]) {
        if (whiteList()) {
            if (0 < strlen($_POST['username']) && 0 < strlen($_POST['password'])) {
                $username = htmlentities(
                    trim($_POST['username']), ENT_QUOTES | 'ENT_HTML5', "UTF-8"
                );
                $password = trim($_POST['password']);

                if (authenticate_user($username, $password)) {
                    $_SESSION['valid'] = true;
                    $_SESSION['username'] = $username;
                    header("Location: home.php");
                } else {
                    header("Location: error.php?message_type=login_error");
                }
            }
        }
    }
}
