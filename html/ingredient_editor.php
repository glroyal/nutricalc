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

$rx = [
    'upc' => '/^\d{5}\-\d{5}$/',
    'printable_ascii' => '/[\x20-\x7E]/',
    'integer' => '/^\d+/',
    'real' => '/^\d+(\.d+)?/',
    'allergens' => '/(milk|eggs|shellfish|tree\snuts|peanuts|wheat|soy|sesame)(\,\s?(milk|eggs|shellfish|tree\snuts|peanuts|wheat|soy|sesame))*/',
];


$jsrx = [
    'ingredient_id' => $rx['integer'],
    'upc'  => $rx['upc'],
    'brand' => $rx['printable_ascii'],
    'identity' => $rx['printable_ascii'],
    'ingredients' => $rx['printable_ascii'],
    'unit_size' => $rx['integer'],
    'serving_size' => $rx['integer'],
    'calories' => $rx['integer'],
    'fat' => $rx['real'],
    's_fat' => $rx['real'],
    't_fat' => $rx['real'],
    'cholest' => $rx['real'],
    'na' => $rx['real'],
    'carb' => $rx['real'],
    'fiber' => $rx['real'],
    'sugar' => $rx['real'],
    'add_sugar' => $rx['real'],
    'protein' => $rx['real'],
    'd3' => $rx['real'],
    'ca' => $rx['real'],
    'fe' => $rx['real'],
    'k' => $rx['real'],
    'allergens' => $rx['allergens'],
];


$defaults = [
    'ingredient_id' => 0,
    'upc'  => "",
    'brand' => "",
    'identity' => "",
    'ingredients' => "",
    'unit_size' => 0,
    'serving_size' => 0,
    'calories' => 0,
    'fat' => 0,
    's_fat' => 0,
    't_fat' => 0,
    'cholest' => 0,
    'na' => 0,
    'carb' => 0,
    'fiber' => 0,
    'sugar' => 0,
    'add_sugar' => 0,
    'protein' => 0,
    'd3' => 0,
    'ca' => 0,
    'fe' => 0,
    'k' => 0,
    'allergens' => "",
];


$jsvars="";

$ingredient_id = (isset($_REQUEST['ingredient_id']) && is_numeric($_REQUEST['ingredient_id'])) ? $_REQUEST['ingredient_id'] : 0;

$ingredients = ($ingredient_id==0) ? array_combine(array_keys($defaults),array_fill(0,count($defaults),"")) : $db->query("select * from `ingredients` where ingredient_id='$ingredient_id' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC)[0]; 

$ingredients['ingredient_id'] = $ingredient_id;


if(isset($_REQUEST['csrf']) && auth_csrf()) {

    foreach($_REQUEST as $k => $v) {

        if (array_key_exists($k,$ingredients)) {
            $ingredients[$k] = preg_match($jsrx[$k],$v) ? $v : $defaults[$k];
        }   
    }

    try {

        $db->beginTransaction();    

            $next_id = $db->query("SELECT MAX(`ingredient_id`)+1 FROM ingredients")->fetch()[0];

            $ingredients['ingredient_id'] = ($ingredient_id==0) ? $next_id : $ingredients['ingredient_id'];

            $k=implode("`,`",array_keys($ingredients));
            $v=implode(',',str_split(str_pad("",count($ingredients),"?")));

            $sql = $db->prepare("REPLACE INTO ingredients(`$k`) VALUES ($v)");
            $sql->execute(array_values($ingredients));

        $db->commit();

    } catch (Exception $e) {

        $db->rollback();
        throw $e;
    }

    rts();
}

 
// display labels for fields not in rda table

$rolabels = [
    'ingredient_id' => 'Ingredient ID',
    'upc' => 'UPC Code',
    'brand' => 'Brand',
    'identity' => 'Identity',
    'ingredients' => 'Ingredients',
    'unit_size' => 'Unit Size',
    'serving_size' => 'Serving Size',
    'allergens' => 'Allergens',
];


foreach($db->query("select * from `rda`")->fetchAll(PDO::FETCH_ASSOC) as $row) {

    $rda[$row['k']] = [
        'item'=>$row['item'],
        'unit'=>$row['unit'],
        'dv'=>$row['dv']
    ];

    $rda[$row['k']]['amount'] = ($ingredient_id>0) ? $db->query("SELECT `{$row['k']}` FROM ingredients WHERE ingredient_id='$ingredient_id' LIMIT 1")->fetch()[0] : 0;

    $rda[$row['k']]['pdv'] = ($rda[$row['k']]['amount']>0 && $rda[$row['k']]['dv']>0) ? round((float)($rda[$row['k']]['amount'] / $rda[$row['k']]['dv']) * 100 ) : (($rda[$row['k']]['dv']>0)?0:"");
}


if($tmp = $db->query("SELECT * FROM ingredients WHERE ingredient_id='$ingredient_id' LIMIT 1")->fetch(PDO::FETCH_ASSOC)) {



// round($tmp['unit_size']/$tmp['serving_size'],0),

    $recipe_tx = array_merge($recipe_tx,[
        'servings'=>$tmp['serving_size'] ? round($tmp['unit_size']/$tmp['serving_size'],0) : 0,
        'serving_size_g'=>$tmp['serving_size'],
        'serving_size_oz'=>decimalize($tmp['serving_size'] * 0.03527396),
        'serving_size_unit'=>'oz'
    ]);
}

$jjrx = str_replace('\/','',json_encode($jsrx)); // strip (escaped) php delimeters from regex array

$jsvars .= "const jjrx=$jjrx,ing=".json_encode($ingredients).",rolabels=".json_encode($rolabels).",rda=".json_encode($rda).",recipe_tx=".json_encode($recipe_tx).";";

?><!DOCTYPE html>
<html lang="en-US">
<head>
    <?php print(implode("\r\n\t",$ogmeta)."\r\n");?>
</head>
<body>
    <link href="./s/global.css" rel="stylesheet">
    <style>
    </style>   
    <noscript>This Web Application requires JavaScript.</noscript>
    <script src="./j/global.js"></script> 
    <script><?php print($jsvars);?></script>
    <script>


    const compileRegexes = (obj) => {
      Object.keys(obj).forEach((key) => {
        obj[key] = RegExp(obj[key]);
      });
    };

    compileRegexes(jjrx);


    function check_field(n) {

        var foo = $(n).value;
        return jjrx[n].test(foo);
    }


    function validate() {
        
        var isValid = true, n;

        for (n in ing) {

            if(!isSet(n)) {

                // these fields cannot be blank

                if(['brand','identity'].includes(n)) {

                    isValid = setErr(n); // console.log(n);
                } 

            } else {

                // otherwise field must match regex

                if(!check_field(n)) {

                    isValid = setErr(n); // console.log(n);
                }
            }
        }

        return isValid;
    }


    function render_editor() {

        var chtml=[], i=0, field, legend, unit, field_enable;

        chtml[i] = `<table style="margin:0 auto 1em auto;">`; i++;

        for(field in ing) {

            legend = (field in rda) ? rda[field]['item'] : rolabels[field];

            unit = (field in rda) ? rda[field]['unit'] : '';

            field_enable = (field != 'ingredient_id') ? "" : "disabled";

            chtml[i] =`<tr style="border:none;">
                <td class="hbd" style="font-size:10pt;line-height:16pt;">${legend}</td>
                <td>
                    <input type="text" style="width:100px;" id="${field}" name="${field}" value="${ing[field]}" ${field_enable} onfocus="clrErr(this.id);" onchange="check_field(this.id);">
                </td>
                <td class="hbr" style="font-size:10pt;line-height:16pt;">&thinsp;${unit}</td>
            </tr>`; i++;
        }

        chtml[i] = `
        </table>
        <input type="hidden" name="csrf" id="csrf" value="${CSRF}">
        <hr size="1">
        <p><input type="submit" value="Submit" name="b1"></p>
        <br><br>`; i++;      

        return chtml.join('');
    }


    document.addEventListener("DOMContentLoaded", function(){

       render_outer(1);
       $('titlebar').innerHTML='Ingredient Editor';
       $('inner').innerHTML = render_editor();
    });
    </script>
    <form name="form1" id="form1" enctype="multipart/form-data" method="POST" action="<?php print($_SERVER['REQUEST_URI']);?>" onsubmit="return validate();"></form>
</body>
</html>