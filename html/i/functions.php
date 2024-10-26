<?php if (!defined('CHTML')) { die("Hacking attempt"); }
/**************************************************************************
*                                NutriCalc
*                              -------------
*               Nutrition Analysis for Cottage Food Products
*                      © Copyright Gary Royal 2024
*
*   This program is free software; you can redistribute it and/or modify   
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version. 
*
***************************************************************************/

function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function csrf($session_id) {
    return hash_hmac("md5",$session_id,CSALT);
}

/*
function auth_csrf($session_id) {    
  return $_REQUEST['csrf'] == csrf($session_id);
//    return (isset($_REQUEST[CSRF_PREFIX]) && $_REQUEST[CSRF_PREFIX] == csrf($session_id));
}
*/

function auth_csrf() {
    // dummy function for CSRF token auth
    // not needed for single-user programs but call structure preserved for upward compatibility
    return $_REQUEST['csrf']=='true';
}

function cookieopt($overlay=[]) {

  return array_merge([
    'expires' => 0,
    'path' => '/',
    'domain' => '', // leading dot for compatibility or use subdomain
    'secure' => SECURE,
    'httponly' => false, // or false
    'samesite' => ((SECURE)?'Strict':'Lax') // None || Lax  || Strict
  ],$overlay);
}


function jump_to($page) {
  header("Location: $page");
  exit;
}

function jsr($page) {
  setcookie("_rts",base64url_encode($_SERVER['REQUEST_URI']),cookieopt());
  jump_to($page);
}


function rts() {

  if(isset($_COOKIE['_rts'])) {
    
    $target = base64url_decode($_COOKIE['_rts']);
    setcookie('_rts', '', cookieopt(['expires'=>LASTYEAR]));
    jump_to($target); 
  }

  exit("*** Done ***");
}

function decimalize($a) {
    return number_format((float)$a, 1, '.', '');
}
?>