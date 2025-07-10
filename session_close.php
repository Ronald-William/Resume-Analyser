<?php
if($_SERVER['REQUEST_METHOD']=='POST'){

    if (session_status() == PHP_SESSION_ACTIVE) {
        // echo 'Session is active';
        session_destroy();
    }

}
?>
