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

if($_SERVER['REQUEST_METHOD']=='POST') {
 //print_r($_POST); exit;

    switch($_REQUEST['recipe_id']) {

        case 'clone':

            $recipe_id_from = $recipe_id;

            $recipe_id_to = $db->query("SELECT MAX(recipe_id)+1 FROM recipes_tx")->fetch()[0];

            if($db->query("INSERT INTO recipes_tx (SELECT $recipe_id_to, CONCAT(recipe_name,' [$recipe_id_to]'), recipe_font, servings, serving_unit FROM recipes_tx WHERE recipe_id=$recipe_id_from)")) {

                $db->query("INSERT INTO recipes (SELECT $recipe_id_to, ingredient_id, amount FROM recipes WHERE recipe_id=$recipe_id_from)");

                $recipe_id = $recipe_id_to;
                // setcookie('_recipe_id', $recipe_id, cookieopt());
            }

        break;   


        case 'del':
/*
        if($db->query("DELETE FROM recipes_tx WHERE recipe_id=$recipe_id")) {
           $db->query("DELETE FROM recipes WHERE recipe_id=$recipe_id");   
        }
        
        $recipe_id = $db->query("SELECT MIN(recipe_id) FROM recipes")->fetch()[0];
        setcookie('_rcpid', $recipe_id, cookieopt());
*/

        case 'new':      
        break;


    }

    $recipe = $db->query("SELECT ingredient_id, amount FROM `recipes` WHERE recipe_id='$recipe_id' ORDER BY amount DESC")->fetchAll(PDO::FETCH_KEY_PAIR);   

    if(isset($_REQUEST['ingr_add'])) {

        $ingredient_id=$_REQUEST['ingr_add'];

        if($ingredient_id=='new') {

            jsr("ingredient_editor.php?ingredient_id=0");
        
        } else if(ctype_digit($ingredient_id)) {

            if(!in_array($ingredient_id,$_REQUEST['ingredient_id'])) {

                $db->query("REPLACE INTO recipes VALUES('$recipe_id','$ingredient_id',0)");
            }
        }
    }


    if(ctype_digit($_REQUEST['recipe_id'])) {

//      print_r($_POST);// exit;

        $recipe_tx = array_merge(['recipe_id'=>$_REQUEST['recipe_id']],$_REQUEST['recipe']);

       //print_r($recipe_tx); // exit;

        $k = implode("`,`",array_keys($recipe_tx));
        $v = implode(',',str_split(str_pad("",count($recipe_tx),"?")));
     //   print "REPLACE INTO recipes_tx (`$k`) VALUES ($v)"; exit;
        $sql = $db->prepare("REPLACE INTO recipes_tx (`$k`) VALUES ($v)");
 //print $sql; exit;//
        $sql->execute(array_values($recipe_tx));
/*
        $k = implode(",",array_keys($_REQUEST['ingredient_id']));
        $v = implode(',',str_split(str_pad("",count($_REQUEST['amount']),"?")));
        $sql = $db->prepare("REPLACE INTO recipes ($k) VALUES ($v)");
        $sql->execute(array_values($_REQUEST['amount']));
*/
     // $db->query("REPLACE INTO recipes_tx VALUES ");

        foreach(array_combine(array_values($_REQUEST['ingredient_id']),array_values($_REQUEST['amount'])) as $k =>$v) {

           // print "==$k==$v=="; exit;

            if (array_key_exists($k,$recipe)) {

                if(is_numeric($v)) {

                    if($recipe[$k] != $v) {
                         
                        $query = "UPDATE recipes SET amount='$v' WHERE recipe_id='$recipe_id' AND ingredient_id='$k' LIMIT 1";
                       //print "$query\r\n";
                        $db->query($query);
                    }

                } else if($v=="del") {
                
                    $query = "DELETE FROM recipes WHERE recipe_id='$recipe_id' AND ingredient_id='$k' LIMIT 1";
                    // print "$query\r\n";
                    $db->query($query); 
                }
            }
        }




    } else {

    }


 //
    if(0) {

    } else {


    }
//    in_array($_POST[''])


//    print_r($_POST); exit;


}

// print $recipe_id; exit;

// setcookie("_recipe_id",'',cookieopt(['expires'=>LASTYEAR])); exit;
setcookie("_recipe_id",$recipe_id,cookieopt());

if($recipe = $db->query("SELECT * FROM `recipes_tx` WHERE recipe_id='$recipe_id' LIMIT 1")->fetchAll(PDO::FETCH_ASSOC)[0]) {

    $recipe['ingredients'] = ($tmp = $db->query("SELECT a.ingredient_id, b.identity, a.amount FROM `recipes` a, `ingredients` b WHERE a.recipe_id='$recipe_id' AND b.ingredient_id=a.ingredient_id ORDER BY a.amount DESC")->fetchAll(PDO::FETCH_ASSOC)) ? $tmp : [];

    $where = count($recipe['ingredients']) ? "WHERE ingredient_id NOT IN (".implode(",",array_column($recipe['ingredients'], 'ingredient_id')).")" : '';

    $ingredients_avbl = ($tmp = $db->query("SELECT ingredient_id, identity, 0 as amount FROM `ingredients` $where ORDER BY identity")->fetchAll(PDO::FETCH_ASSOC)) ? $tmp : [];

    $recipes_avbl = $db->query("SELECT recipe_id, recipe_name FROM `recipes_tx` where recipe_id>0")->fetchAll(PDO::FETCH_ASSOC);

    $jsvars="const recipe=".json_encode($recipe).",ingredients_avbl=".json_encode($ingredients_avbl).",recipes_avbl=".json_encode($recipes_avbl).";";
}

?><!DOCTYPE html>
<html lang="en-US">
<head>
    <?php print(implode("\r\n\t",$ogmeta)."\r\n");?>
</head>
<body>
    <link href="./s/global.css" rel="stylesheet">
    <style>

    tr {
        line-height:28px;
    }

    td {
    	#
    }

    input[type="text"] {
        width:56px;
    }

    #recipe_id {
        width:100%;
    }

    .unit {
        text-align:left;
        width:30px;
        line-height:100%;
    }

    #fface {
        font-face:'Helvetica Bold';
        font-size:16pt;
        line-height:18pt;

    }

    .f1 {
    	#
    }

    .f1b {
    	#
    }

    </style>   
    <noscript>This Web Application requires JavaScript.</noscript>
    <script src="./j/global.js"></script> 
    <script><?php print($jsvars);?></script>
    <script>

    function setcolor(id) {
        var ndx = id.replace("TR","");
        $(id).style.background = ($(id).value != recipe[ndx]) ? '#FFFF8F' : '#FFFFFF';
    }
    
    function ingr_del(id) {
 
        pstate = Math.abs(pstate-1);

        var ndx = id.replace("TP","");

        if(pstate) {
            console.log('delete');
            $('TD'+ndx).style.background = '#FFFF8F';
            memo[id] = $('TR'+ndx).value;
            $('TR'+ndx).value = 'del';

        } else {
            console.log('restore');
            $('TR'+ndx).value = memo[id];
            $('TD'+ndx).style.background = '#FFFFFF';
        }   
    }



    var pstate=0, memo=[];


















    
    function hr(size) {

    	return `
			<tr>
	          <td colspan="2">
	            <div class=hr style="top:0pt;border-bottom:${size}px solid #000;"></div>
	          </td>
	        </tr>`;
    }

    const cnfmsg={
        'clone' : `Clone ${recipe['recipe_name']} to new recipe?`,
        'del' : `Delete  ${recipe['recipe_name']}?`,
        'new' : `Create a new recipe?`,        
    };    

    function set_recipe(recipe_id) {
    
        if(recipe_id != recipe['recipe_id']) {

            if(['clone','del','new'].includes(recipe_id)) {

                if(!confirm(cnfmsg[recipe_id])) {
                    $('recipe_id').value = recipe['recipe_id'];
                    return false;
                }

            } else {

                setCookie('_recipe_id', recipe_id, 0);
            }

             $('form1').submit();  
        }           
    }
/*
    function ingr_del(ingredient_id) {


        console.log(ingredient_id);
        console.log($(ingredient_id).value);

    //    jump_to("recipe_editor.php?recipe_id=del&ingredient_id="+ ingredient_id);      
    }
*/
    function new_ingr(ingredient_id) {

//        console.log(ingredient_id);
    $('ingr_add').style.background = (ingredient_id != "0") ? '#FFFF8F' : '#FFFFFF';
 $('form1').submit();  

    }

    function validate() {

        console.log('custom validation');
        
        var isValid = true;

        if(!isSet('recipe_name')) {
            isValid = setErr('recipe_name'); 
        }
console.log(isValid);
        if($('recipe_servings').value<1) {
            isValid = setErr('recipe_servings');
        }
console.log(isValid);  
        if(!isSet('serving_unit')) {
            isValid = setErr('serving_unit');
        }
console.log(isValid);       
        /*
        if(ingredients_used.length==0) {
            isValid = setErr('D1');
        }
        */
console.log(isValid);
        return isValid;
    }



    function render_editor() {
		
		var chtml=[], 
			i = ingredients_avbl.length,
			id,
			j = 0,
			k = 0,
			r = recipe['ingredients'].length; 

        chtml[j] = `
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2">
						<select size=1 name="recipe_id" id="recipe_id" onchange="set_recipe(this.value);">`; j++;

        for(k=0; k<recipes_avbl.length; k++) {

        	chtml[j] = `<option ${(k+1 == recipe['recipe_id']) ? 'selected' : ''} value="${recipes_avbl[k]['recipe_id']}">${recipes_avbl[k]['recipe_name']}</option>`; j++;
        }

        chtml[j] = `<option value="del">&nbsp;&nbsp;Delete ${recipe['recipe_name']}</option>
		            <option value="clone">&nbsp;&nbsp;Clone ${recipe['recipe_name']}</option>
		            <option value="new">----&nbsp;New Recipe</option>
  				</select>
			</td>
		</tr>`; j++;
       
		chtml[j] = hr(1); j++;

		chtml[j] = `
				<tr style="height:36px;">
                  <td></td>
                  <td id=fface>${recipe['recipe_name'].replace(/\[.*\]/,"")}</td>
                </tr>

                <tr>
                  <td><span class="hbd">Recipe Name&nbsp;</span></td>
                  <td><input type="text" name="recipe[recipe_name]" id="recipe_name" onfocus="clrErr('recipe_name');" onblur="setfont();" style="width:100%;" value="${recipe['recipe_name']}"></td>
                </tr>
                
                <tr>
                  <td><span class="hbd">Display Font</span></td>
                  <td><select size="1" name="recipe[recipe_font]" id="recipe_font" value="${recipe['recipe_font']}" onchange="setfont();">
                    <option>Berkshire Swash</option>                  
                    <option>Helvetica Black</option>
                    <option>Paladin</option>
                    <option>Splash</option>
                    </select>
                  </td>
                </tr>

                <tr>
                  <td><span class="hbd">Servings</span></td>
                  <td><input type="text" name="recipe[servings]" id="recipe_servings" size="5" value="${recipe['servings']}" onfocus="clrErr('recipe_servings');"></td>
                </tr>
                
                <tr>
                  <td><span class="hbd">Serving Unit</span></td>
                  <td><input type="text" name="recipe[serving_unit]" id="serving_unit" size="10" value="${recipe['serving_unit']}"></td>
                </tr>`; j++;

		chtml[j] = hr(1); j++;

        if(r) {

        	for(k=0; k<r; k++) {
 				
 				id = recipe['ingredients'][k]['ingredient_id'];
                
                chtml[j] = `
                   <tr>
                     <td valign="middle" align="center"><input type="text" id="TR${id}" name="amount[${k}]" size="20" style="text-align:right;" value="${recipe['ingredients'][k]['amount']}" onchange="setcolor(this.id);">&#8201;g&#8195;</td>
                     <td id="TD${id}">
                       <select size="1" id="TP${id}" name="ingredient_id[${k}]" onchange="ingr_del(this.id);">
                         <option selected value="${id}">${recipe['ingredients'][k]['identity']}</option>
                         <option value="${id}">Delete ${recipe['ingredients'][k]['identity']}</option>
                       </select>
                     </td>
                   </tr>       
                `; j++;
        	}

			chtml[j] = hr(1); j++;
        }

        chtml[j] = `
                <tr>
                  <td></td>
                  <td><select size="1" id="ingr_add" name="ingr_add" onchange="new_ingr(this.value);"><option value="0">More Ingredients</option><option value="new">--- New Ingredient</option>`; j++;

        if(i) {

        	for(k=0; k<i; k++) {

				chtml[j] = `<option value="${ingredients_avbl[k]['ingredient_id']}">${ingredients_avbl[k]['identity']}</option>`; j++; 
        	}

			chtml[j] = hr(1); j++;
        }

        chtml[j] = `</select>
            </td>
        </tr>`; j++;

        chtml[j] = `
        	<tr>
            	<td colspan="2" valign="middle" align="left"><input style="margin:1em;" type="submit" value="Submit" name="mode" id="mode"></td>
            </tr>
        </table>`; j++;

       $('inner').innerHTML = chtml.join('');

       $('fface').style.fontFamily = $('recipe_font').value;
    }

	document.addEventListener("DOMContentLoaded", function(){

	    render_outer(0);
	    $('titlebar').innerHTML='Recipe Editor';
    	render_editor();
    });

    </script>
    <form name="form1" id="form1" enctype="multipart/form-data" method="POST" action="<?php print($_SERVER['REQUEST_URI']);?>" onsubmit="return validate();"></form>
</body>
</html>