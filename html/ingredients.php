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

$pantry = $db->query("SELECT ingredient_id, upc, brand, identity FROM ingredients ORDER BY ingredient_id")->FetchAll(PDO::FETCH_ASSOC);

$labels = [
    'ingredient_id' => 'ID',
    'upc' => 'UPC',
    'brand' => 'Brand',
    'identity' => 'Identity',
    'ingredients' => 'Ingredients',
    'unit_size' => 'Unit Size',
    'serving_size' => 'Serving Size',
    'allergens' => 'Allergens',
];

$jsvars .= "const pantry=".json_encode($pantry).",labels=".json_encode($labels).";";

?><!DOCTYPE html>
<html lang="en-US">
<head>
    <?php print(implode("\r\n\t",$ogmeta)."\r\n");?>
</head>
<body>
    <link href="./s/global.css" rel="stylesheet">
    <style>

        body {
            font-family:'Helvetica';
        }

        .th {
            font-family:'Helvetica Bold';
            font-size:8pt;line-height:10pt;
            border-bottom:#222 1px solid;
            text-align:center;
        }

        .tra {
            text-align:left;;padding-right:1em;
            font-size:10pt; line-height:12pt;
            /*text-overflow: ellipsis;overflow:hidden;white-space:nowrap;*/
        }

        .trn {
            text-align:right;padding-right:1em;
        }

        .gry {
            background:#ccc;
        }

    </style>   
    <noscript>This Web Application requires JavaScript.</noscript>
    <script src="./j/global.js"></script> 
    <script><?php print($jsvars);?></script>
    <script>

    var barcolor = 0;

    function new_ingredient() {
        window.location.href = "ingredient_editor.php?item=0";
    }

    document.addEventListener("DOMContentLoaded", function(){

       render_outer(1);

        var chtml=[], i=0, j;

        chtml[i] = `<table style="margin:1em auto;">`; i++;

        chtml[i] = `
            <tr>
              <td class="th">${labels['ingredient_id']}</td>
              <td class="th">${labels['upc']}</td>
              <td class="th">${labels['brand']}</td>
              <td class="th">${labels['identity']}</td>
            </tr>`; i++;

        for(j=0; j<pantry.length; j++) {

            chtml[i] = `<tr class="${colorbar()}">
              <td class="trn">${pantry[j]['ingredient_id']}</td>
              <td class="trn">${pantry[j]['upc']}</td>
              <td class="tra">${pantry[j]['brand']}</td>
              <td class="tra"><a href="javascript:jsr('ingredient_editor.php?ingredient_id=${pantry[j]['ingredient_id']}');">${pantry[j]['identity']}</a></td>
            </tr>`; i++;
        }

        chtml[i] = `</table>
        <hr size="1"<p><input type="button" value="Add New Ingredient" name="b1" onclick="new_ingredient();"></p>`; i++;       

        document.getElementById('inner').innerHTML = chtml.join('');
    });

    </script>
    <form name="form1" id="form1" enctype="multipart/form-data" method="POST" action="<?php print($_SERVER['REQUEST_URI']);?>" onsubmit="return validate();"></form>
</body>
</html>