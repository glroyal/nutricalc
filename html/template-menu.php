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
    <link href="./s/global.css" rel="stylesheet">
<style>

</style>   
</head>
<body>
    <form name="form1" id="form1" enctype="multipart/form-data" method="POST" action="<?php print($_SERVER['REQUEST_URI']);?>" onsubmit="return validate();"><div id="outer">Loading...</div></form>
    <noscript>This Web Application requires JavaScript.</noscript>
    <script src="./j/global.js"></script>    
    <script><?php print($jsvars);?></script>
<script>

document.addEventListener("DOMContentLoaded", function(){

   render_outer(0);

   $('inner').innerHTML = ``;
});

</script>
</body>
</html>