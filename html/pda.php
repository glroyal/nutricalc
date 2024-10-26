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
include('./i/functions_nfax.php');

$crate_no = 0; // 0 == today (DAY DD-MMM-YYYY) 

$baked_for_you = [
    1 => 'MON 12-AUG-2024',
    2 => 'TUE 13-AUG-2024',
    3 => 'WED 14-AUG-2024',
    4 => 'THU 15-AUG-2024', 
];

$recipe_tx['net_wt_kg'] = (float)decimalize($recipe_tx['net_wt_g']/1000);
$recipe_tx['net_wt_lb'] = floor($recipe_tx['net_wt_g'] * 0.002204623); // g to lb
$recipe_tx['serving_unit'] = str_replace(' ','&nbsp;',trim($recipe_tx['serving_unit']));
$recipe_tx['producer'] = implode(' &middot; ',array_map(function($n){ return str_replace(' ','&nbsp;',$n); },$db->query("SELECT * FROM `producer`")->fetch()));
$recipe_tx['baked'] = ($crate_no) ? $baked_for_you[$crate_no] : strtoupper(date("D j-M-Y"));

$ingredients = $db->query("SELECT b.identity, b.ingredients FROM recipes a LEFT JOIN ingredients b ON b.ingredient_id = a.ingredient_id WHERE a.recipe_id = $recipe_id ORDER BY a.amount DESC")->fetchAll(PDO::FETCH_KEY_PAIR);

$jsvars="const recipe_tx=".json_encode($recipe_tx).",ingredients=".json_encode($ingredients).",rda=".json_encode($rda).";";

?><!DOCTYPE html>
<html lang="en-US">
<head>
    <?php print(implode("\r\n\t",$ogmeta)."\r\n");?>
</head>
<body>
    <link href="./s/global.css" rel="stylesheet">
    <link href="./s/std_vertical.css" rel="stylesheet"> 
    <link href="./s/pda.css" rel="stylesheet">       
    <style>

    #preview {
        margin:-3em 0;
        transform: scale(0.8);
        border:#000 1px solid;
    }

    </style>   
    <noscript>This Web Application requires JavaScript.</noscript>
    <script src="./j/global.js"></script> 
    <script src="./j/printing.js"></script>    
    <script src="./j/std_vertical.js"></script>  
    <script><?php print($jsvars);?></script>
    <script>

    function list_ingredients() {

        var list=[], j=0, i;

        for(i in ingredients) {

           list[j] = `<span class="hbd">${i}</span>` + ((ingredients[i]>'')?[' (',ingredients[i],')'].join(''):ingredients[i]); j++;
        }

        return ['<p class=hbd><span class="hbk hbu">INGREDIENTS</span>:&nbsp;<span class="hbr ingredients">',list.join(', '),'</span></p>'].join(''); 
    }


    function render_label() {

        return `<div class="label">
            <div class="zone0">
                <div class="identity">
                    <p class=logo>${recipe_tx['recipe_name'].replace(/\[.*\]/,"")}</p>
                    <div style="margin:0 auto;text-align:justify;text-justify:inter-word;">${list_ingredients()}</div>
                    <p class="hbk hbu allergens">CONTAINS TREE NUTS, WHEAT, EGG<span class=hbr>.</span</p>
                    <p class="hbr baked" style=""><span class=hbo>Baked Especially For You</span><br>${recipe_tx['baked']}</p>
                    <p class="hbd producer">${recipe_tx['producer']}</p>
                    <p class="hbk disclaimer">THIS PRODUCT WAS PRODUCED IN A HOME KITCHEN NOT SUBJECT TO PUBLIC HEALTH INSPECTION THAT MAY ALSO PROCESS COMMON FOOD ALLERGENS</p>
                    <p class="hbk weight">Net Wt ${recipe_tx['net_wt_lb']} lbs (${recipe_tx['net_wt_kg']} kg)</p>
                    <p class=origin style="">Hand Made in USA</p>
                </div>
            </div>
            <div class="zone1">
                <div class="panel">${nutrition_facts_tiny()}</div>
            </div>
        </div>`;
    }

    function render_plate() {

        return  `<!DOCTYPE html>
        <html lang="en-US">
        <head>
            <meta charset="utf-8">
        </head>
        <body>
            <link href="./s/global.css" rel="stylesheet">
            <link href="./s/std_vertical.css" rel="stylesheet">  
            <link href="./s/pda.css" rel="stylesheet">   
            ${render_label()}${render_label()}
        </body>
        </html>`;
    }

    document.addEventListener("DOMContentLoaded", function(){

       render_outer(3);
       $('titlebar').innerHTML='Principal Display Area (PDA)';

       $('inner').innerHTML = `
       <div id="preview">${render_label()}</div>
       <div style="margin:1em 0;text-align:center;">
            <input type="button" value="PRINT" name="B3" onclick="printPage();">
        </div>
        `;
    });

    </script>
    <form name="form1" id="form1" enctype="multipart/form-data" method="POST" action="<?php print($_SERVER['REQUEST_URI']);?>" onsubmit="return validate();"></form>
</body>
</html>