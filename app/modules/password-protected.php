<?php

function ecrannoir_filter_is_password_protected($status, $pwd) {

    if ($status === true) {
        return true;
    }

    global $store_crypt, $colorr;
    include("password-protected.store.php");

    if ($store_crypt == null) {
        return false;
    }

    $encrypted_pwd = md5($pwd);

   if(in_array($encrypted_pwd, $store_crypt, true)) {
       return true;
   } else {
       return false;
   }
}
