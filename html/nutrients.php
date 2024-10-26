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

$recipe_tx = $db->query("SELECT * FROM `recipes_tx` WHERE recipe_id='$recipe_id' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC)[0];

$recipe_tx['net_wt_g'] = $db->query("SELECT CEILING(SUM((a.amount / b.serving_size) * b.serving_size)/1) FROM recipes a, ingredients b WHERE a.recipe_id=1 AND b.ingredient_id=a.ingredient_id")->fetch()[0];

$recipe_tx['serving_size_g'] = ceil(decimalize($recipe_tx['net_wt_g']/$recipe_tx['servings']));

foreach($db->query("select * from `rda`")->fetchAll(PDO::FETCH_ASSOC) as $row) {

    $rda[$row['k']] = [
        'item'=>$row['item'],
        'unit'=>$row['unit'],
        'dv'=>$row['dv'],
        'amount'=>0,
        'pdv'=>''
    ];

    $rda[$row['k']]['amount'] = $db->query("SELECT CEILING(SUM((a.amount / b.serving_size) * b.{$row['k']})/{$recipe_tx['servings']}) FROM recipes a, ingredients b WHERE a.recipe_id='$recipe_id' AND b.ingredient_id = a.ingredient_id")->fetch()[0];

    $rda[$row['k']]['pdv'] = ($rda[$row['k']]['amount']>0 && $rda[$row['k']]['dv']>0) ? round((float)($rda[$row['k']]['amount'] / $rda[$row['k']]['dv']) * 100 ) : (($rda[$row['k']]['dv']>0)?0:"");  
} 

$nutrient = isset($_REQUEST['n']) && in_array($_REQUEST['n'],array_keys($rda)) ? $_REQUEST['n'] : 'index';

$jsvars = "const recipe_tx=".json_encode($recipe_tx).",rda=".json_encode($rda).",nutrient='$nutrient'";

$servings = $recipe_tx['servings'];

if($nutrient != 'index') {

    $data = $db->query("select 
        b.identity, 
        b.serving_size, 
        a.amount as recipe_amount, 
        b.{$nutrient} as nutrient_value, 
        FORMAT(a.amount/b.serving_size,2) as ratio, 
        FORMAT(CEILING(b.{$nutrient}*(a.amount/b.serving_size)),0,'en_US') as total, 
        FORMAT(b.{$nutrient}*(a.amount/b.serving_size)/$servings,0) as nv, 
        FORMAT((b.{$nutrient}*(a.amount/b.serving_size)/$servings/c.dv)*100,0) as pdv 
        FROM recipes a, ingredients b, rda c 
        WHERE 
        b.{$nutrient}>0 AND 
        a.recipe_id='$recipe_id' AND 
        b.ingredient_id=a.ingredient_id and c.k = '{$nutrient}' order by a.amount desc")->fetchAll(PDO::FETCH_ASSOC);

    $jsvars .= ",sum_nv=".array_sum(array_column($data,'nv'));
    $jsvars .= ",sum_pdv=".array_sum(array_column($data,'pdv'));
    $jsvars .= ",data=".json_encode($data);
}

// $jsvars .= ",rda=".json_encode($rda).';';

?><!DOCTYPE html>
<html lang="en-US">
<head>
    <?php print(implode("\r\n\t",$ogmeta)."\r\n");?>
</head>
<body>
    <link href="./s/global.css" rel="stylesheet">
    <link href="./s/std_vertical.css" rel="stylesheet">       
    <style>

    table {
        margin:auto;
    }

    td {
        text-align:right;
        vertical-align:bottom;
    }

    td.stub {
        text-align:left;
        vertical-align: bottom;
    }

    .l1  {
        border-bottom:#000 1px solid;
        text-align:center;
        font-size:12px;
        font-weight:bold;
    }

    .l1d {
        border-style:double none none none;
        text-align:right;            
        font-size:16px;
    }

    .nfax {
      margin:0;
    }
    
    </style>   
    <noscript>This Web Application requires JavaScript.</noscript>
    <script src="./j/global.js"></script> 
    <script src="./j/std_vertical.js"></script> 
    <script><?php print($jsvars);?></script>
    <script>

    const thisurl = location.pathname;

    function jump_to(arg) {
        window.location = thisurl + '?n='+arg;
    }

    function nutrient_detail() {

        $('inner').innerHTML = `

            <table border="0" cellpadding="4" cellspacing="4">
              <tr>
                <td colspan="6" class="l1 stub">${rda[nutrient]['item'].toUpperCase()}</td>
                <td colspan="2" class="l1">DV ${rda[nutrient]['dv']}&thinsp;${rda[nutrient]['unit']}</td>
              </tr>
              <tr>
                <td></td>
                <td colspan="5" class="l1">Per Ingredient</td>
                <td colspan="2" class="l1">Per Serving</td>
              </tr>
              <tr>
                <td class="l1">Ingredient</td>
                <td class="l1">Serving<br> Size (g)</td>
                <td class="l1">Recipe<br> Amount (g)</td>
                 <td class="l1">Nutrient<br> Value</td>              
                <td class="l1">Ratio</td>
                <td class="l1">Total</td>
                <td class="l1">Nutrient<br> Value</td>
                <td class="l1">%DV</td>
              </tr>` +

                (function() {

                    var tmp=[], j=0;

                    for(i in data) { 
                        
                        tmp[j] =  `<tr>
                        <td class="stub">${data[i]['identity']}</td>
                        <td>${data[i]['serving_size']}</td>
                        <td>${data[i]['recipe_amount']}</td>
                        <td>${data[i]['nutrient_value']}</td>                        
                        <td>${data[i]['ratio']}</td>
                        <td>${data[i]['total']}</td>
                        <td>${data[i]['nv']}&thinsp;${rda[nutrient]['unit']}</td>
                        <td>${data[i]['pdv']}&thinsp;%</td>
                      </tr>`;

                      j++;
                    }
                    
                    tmp[j] =  `<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="l1d">${sum_nv}&thinsp;${rda[nutrient]['unit']}</td>
                        <td class="l1d">${sum_pdv}&thinsp;%</td>
                      </tr>`;

                    return tmp.join('');

                })() +         

        `</table><input type="button" value="Back" name="B3" onclick="jump_to('index');">`;
    }

    function nutrient_index() {

        $('inner').innerHTML = nutrition_facts_tiny();
    }


    document.addEventListener("DOMContentLoaded", function(){

        render_outer(2);
        $('titlebar').innerHTML=recipe_tx['recipe_name'];

        if(nutrient=='index') {
            nutrient_index();
        } else {
            nutrient_detail();
        }
    });

    </script>
    <form name="form1" id="form1" enctype="multipart/form-data" method="POST" action="<?php print($_SERVER['REQUEST_URI']);?>" onsubmit="return validate();"></form>
</body>
</html>