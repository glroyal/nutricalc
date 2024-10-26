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

// create a PDO database object

try {

    $db = new PDO(
        "mysql:host=localhost;dbname=nutricalc;charset=utf8mb4", // dsn
        'bbs',            // user
        'EwRy2rDve29EJYA7', // pswd 
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM
        ]
    );

} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// add the includes directory to the search path
ini_set('include_path', ini_get('include_path') . ":./i");

define('NEXTYEAR',time() + 31536000);
define('LASTYEAR',time() - 31536000);
define('SECURE',$_SERVER['SERVER_PORT'] == 443);

/*

define('CSRF_PREFIX',(SECURE) ? '__Host-csrf_token' : 'csrf_token');
define ('SALT','e09d1ck63fiscfbce1e10ce476c0d1f7');
define('PEPPER',[
    hash('crc32','e41b975377543032f12430daf66de18e') => 'e41b975377543032f12430daf66de18e',
]);
*/

// $defaults = $db->query('SELECT config_name, config_value FROM defaults')->fetchAll(PDO::FETCH_KEY_PAIR);

$ogmeta=[
    '<meta charset="utf-8">',
    '<meta name="viewport" content="width=device-width, user-scalable=no">',
    '<meta name="apple-mobile-web-app-capable" content="yes">',
    '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">',
    '<meta name="mobile-web-app-capable" content="yes">',
    '<meta name="description" content="Nutrition Analysis for Cottage Food Products">',
    '<title>NutriCalc</title>',
];

include("functions.php");

$recipe_id = (isset($_COOKIE['_recipe_id']) && ctype_digit($_COOKIE['_recipe_id'])) ? $_COOKIE['_recipe_id'] : $db->query("SELECT MIN(recipe_id) FROM recipes")->fetch()[0];

$jsvars="";

?>