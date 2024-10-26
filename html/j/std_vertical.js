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
 
function nutrition_facts_tiny() {

    return  `<div class=nfax style="border:#000 1.5pt solid;padding:1pt;width:184pt;height:374pt;text-align:left;">
        
        <div style="position:relative;top:-1pt;">
            <span class="hbk facts" style="padding-left:2pt;">Nutrition</span><span class="hbk facts fright" style="padding-right:2pt">Facts</span>
        </div>

        <div class=hr style="top:0pt;border-bottom: 0.75pt solid #000;margin:0 2pt;"></div>

        <div style="position:relative;top:5pt;">
            <span class="hbr servings" style="margin:0 2pt;">${recipe_tx['servings']} servings per container</span>
        </div>    

        <div style="position:relative;top:5pt;">
            <span class="hbk size">Serving Size</span>&emsp;&emsp;&emsp;<span class="hbk size fright">${recipe_tx['serving_unit']}&nbsp;(${recipe_tx['serving_size_g']}g)</span>
        </div>

        <div class=hr style="top:6pt;border-bottom: 9pt solid #000;margin:0 2pt;"></div>

        <div style="position:relative;top:5pt;">
            <span class="hbk amount">Amount per serving</span>
        </div>

        <div style="position:relative;top:4pt;">
            <span class="hbk calories0"><a href="nutrients.php?n=calories">Calories</a></span>&emsp;<span class="hbk calories1 fright">${rda['calories']['amount']}</span>
        </div>

        <div class=hr style="top:5pt;border-bottom: 5pt solid #000;margin:0 2pt;"></div>

        <div style="position:relative;top:4pt;">
            <span class="hbk pdv">% Daily Value *</span>
        </div>

        <div class=hr style="top:18pt;border-bottom: 1.5pt solid #000;margin:0 2pt;"></div>    

        <table class="macro">

            <tr>
                <td class="hbk stub"><a href="nutrients.php?n=fat">Total Fat</a>&nbsp;<span class=hbr>${rda['fat']['amount']}g</span></td>
                <td class="hbk col">${rda['fat']['pdv']}%</td>
            </tr>

            <tr style="">
                <td class="hbr stub" style="padding-left:1em;"><a href="nutrients.php?n=s_fat">Saturated Fat</a>&nbsp;<span class=hbr>${rda['s_fat']['amount']}g</span></td>
                <td class="hbk col">${rda['s_fat']['pdv']}%</td>
            </tr>

            <tr class=tr2 style="position:relative;top:0.5pt;">
                <td class="hbr stub" style="padding-left:2em;line-height:12pt;"><a href="nutrients.php?n=t_fat"><span class=hob>Trans</span> Fat</a>&nbsp;<span class=hbr>${rda['t_fat']['amount']}g</span></td>
                <td class="hbk col"></td>
            </tr>

            <tr class=tr2 style="position:relative;top:-0.5pt;">
                <td class="hbk stub" style="line-height:9pt;"><a href="nutrients.php?n=cholest">Cholesterol</a>&nbsp;<span class=hbr>${rda['cholest']['amount']}mg</span></td>
                <td class="hbk col">${rda['cholest']['pdv']}%</td>
            </tr>

            <tr class=tr2 style="position:relative;top:-0.5pt;">
                <td class="hbk stub" style="line-height:11pt;"><a href="nutrients.php?n=na">Sodium</a>&nbsp;<span class=hbr>${rda['na']['amount']}mg</span></td>
                <td class="hbk col">${rda['na']['pdv']}%</td>
            </tr>

            <tr class=tr2 style="position:relative;top:-0.5pt;">
                <td class="hbk stub" style="line-height:11pt;"><a href="nutrients.php?n=carb">Total&nbsp;Carbohydrate</a>&nbsp;<span class=hbr>${rda['carb']['amount']}g</span></td>
                <td class="hbk col">${rda['carb']['pdv']}%</td>
            </tr>

            <tr class=tr2 style="position:relative;top:0.5pt;">
                <td class="hbr stub" style="padding-left:1em;line-height:11pt;"><a href="nutrients.php?n=fiber">Dietary&nbsp;Fiber&nbsp;<span class=hbr>${rda['fiber']['amount']}g</span></td>
                <td class="hbk col">${rda['fiber']['pdv']}%</td>
            </tr>

            <tr class=tr2 style="position:relative;top:0.5pt;">
                <td class="hbr stub" style="padding-left:2em;line-height:12pt;"><a href="nutrients.php?n=sugar">Total&nbsp;Sugars</a>&nbsp;<span class=hbr>${rda['sugar']['amount']}g</span></td>
                <td class="hbk col"></td>
            </tr>

            <tr class=tr2 style="position:relative;top:0.5pt;">
                <td class="hbr stub" style="padding-left:2em;line-height:12pt;"><a href="nutrients.php?n=calories">Includes&nbsp;<span class=hbr>${rda['add_sugar']['amount']}g</span>&nbsp;Added&nbsp;Sugars</a>&nbsp;</td>
                <td class="hbk col">${rda['add_sugar']['pdv']}%</td>
            </tr>

            <tr class=tr2 style="border:none;position:relative;top:1pt;">
                <td class="hbk stub" style="line-height:10pt;"><a href="nutrients.php?n=calories">Protein</a>&nbsp;<span class=hbr>${rda['protein']['amount']}g</span></td>
                <td class="hbk col">${rda['protein']['pdv']}%</td>
            </tr>

        </table>

        <div class=hr style="top:3pt;border-bottom: 9pt solid #000;margin:2pt 2pt 0 0;"></div>

        <table class="macro">

            <tr class=tr2 style="position:relative;top:-1pt;">
                <td class="hbr stub" style="line-height:10pt;"><a href="nutrients.php?n=d3">Vitamin D</a>&nbsp;<span class=hbr>${rda['d3']['amount']}mcg</span></td>
                <td class="hbk col">${rda['ca']['pdv']}%</td>
            </tr>            

            <tr style="position:relative;top:-0pt;">
                <td class="hbr stub"style="line-height:11pt;"><a href="nutrients.php?n=ca">Calcium</a>&nbsp;<span class=hbr>${rda['ca']['amount']}mg</span></td>
                <td class="hbk col">${rda['ca']['pdv']}%</td>
            </tr>            

            <tr style="">
                <td class="hbr stub" style=""><a href="nutrients.php?n=fe">Iron</a>&nbsp;<span class=hbr>${rda['fe']['amount']}mg</span></td>
                <td class="hbk col">${rda['fe']['pdv']}%</td>
            </tr>     

             <tr style="border:none;position:relative;top:0.5pt;">
                <td class="hbr stub"style="line-height:12pt;""><a href="nutrients.php?n=k">Potassium&nbsp;<span class=hbr>${rda['k']['amount']}mg</span></td>
                <td class="hbk col">${rda['k']['pdv']}%</td>
            </tr>      

        </table>

        <div class=hr style="top:2pt;border-bottom: 5pt solid #000;margin: 2pt;"></div>

        <div class="hbr foot1"><span class=hang>*&nbsp;The % Daily Value (DV) tells you how much a nutrient in a serving of food contributes to a daily diet. 2,000 calories a day is used for general nutrition advice.</span></div>

        <div class="hbd foot2" style="padding:0 2pt 0 2pt;">THESE FIGURES WERE DERIVED FROM INGREDIENT LABELS AND SHOULD BE CONSIDERED AN ESTIMATE</div>

    </div>`;
}