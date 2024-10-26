<?php 
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

define('CHTML', true);
include('./i/common.php');

?><!DOCTYPE html>
<html lang="en-US">
<head>
    <?php print(implode("\r\n\t",$ogmeta)."\r\n");?>
</head>
<body>
    <link href="./s/global.css" rel="stylesheet">
    <link href="./s/std_vertical.css" rel="stylesheet">    
    <style>

    body {
        /*background-image: url("./a/nfax-tiny.png");*/
    }

    .nfaX {
        margin:14pt auto auto 20pt;
    }

    a,
    a:link,
    a:visited,
    a:hover,
    a:active {
        color: #000;
        text-decoration: none;
    }

    </style>   
    <noscript>This Web Application requires JavaScript.</noscript>
    <script src="./j/global.js"></script> 
    <script src="./j/std_vertical.js"></script>    
    <script><?php print($jsvars);?></script>
    <script>

    document.addEventListener("DOMContentLoaded", function(){
        
        $('form1').innerHTML = nutrition_facts_tiny();
    });

    </script>
    <form name="form1" id="form1" enctype="multipart/form-data" method="POST" action="<?php print($_SERVER['REQUEST_URI']);?>" onsubmit="return validate();"></form>
</body>
</html>