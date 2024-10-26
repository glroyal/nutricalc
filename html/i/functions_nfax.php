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

// Data for Nutrition Facts panel

$recipe_tx = $db->query("SELECT * FROM `recipes_tx` WHERE recipe_id='$recipe_id' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC)[0];

$recipe_tx['net_wt_g'] = $db->query("SELECT CEILING(SUM((a.amount / b.serving_size) * b.serving_size)/1) FROM recipes a, ingredients b WHERE a.recipe_id=1 AND b.ingredient_id=a.ingredient_id")->fetch()[0];

$recipe_tx['serving_size_g'] = ceil(decimalize($recipe_tx['net_wt_g']/$recipe_tx['servings']));

foreach($db->query("select * from `rda`")->fetchAll(PDO::FETCH_ASSOC) as $row) {

    $rda[$row['k']] = [
        'item'=>$row['item'],
        'unit'=>$row['unit'],
        'dv'=>$row['dv']
    ];

    $rda[$row['k']]['amount'] = $db->query("SELECT CEILING(SUM((a.amount / b.serving_size) * b.{$row['k']})/{$recipe_tx['servings']}) FROM recipes a, ingredients b WHERE a.recipe_id='$recipe_id' AND b.ingredient_id = a.ingredient_id")->fetch()[0];

    $rda[$row['k']]['pdv'] = ($rda[$row['k']]['amount']>0 && $rda[$row['k']]['dv']>0) ? round((float)($rda[$row['k']]['amount'] / $rda[$row['k']]['dv']) * 100 ) : (($rda[$row['k']]['dv']>0)?0:"");
}

?>