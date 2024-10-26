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
    <style>

    body {
        font-size:10pt;
        line-height:12pt;
    }

    #box {
        width:80%;
        margin:auto;
        padding:1em;
       
        text-align:left;
        /* border:#000 2px solid;text-justify:inter-word;*/
    }

    #tstack {
        display: flex;
        /*     flex-direction:column;*/
        justify-content: space-evenly; 
        align-items:center;
        width:80%;
        margin:auto;

    }

    .tstack {
        width:50px;height:auto;
        /*background:#ccc;*/
    }

    .ctr {
        width:100%;
        text-align:center;
        margin:auto;
    }

    .hbk {
        font-size:14pt;
        line-height:18pt;
    }

    </style>   
    <noscript>This Web Application requires JavaScript.</noscript>
    <script src="./j/global.js"></script> 
    <script><?php print($jsvars);?></script>
    <script>

    document.addEventListener("DOMContentLoaded", function(){
    
       render_outer(4);
       $('titlebar').innerHTML='About This program';
    
       $('inner').innerHTML = `
                         
            <p class="hbk ctr" style="margin-top:1em;">NutriCalc</p>
            <p class="hbd ctr">Nutrition Analysis for Cottage Food Products</p>
            <p class="hbr ctr">© Copyright Gary Royal 2024</p>

            <p style="margin:1em auto;width:80%;">This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.</p>
   
            <div style="width:100%;text-align:center;"><a href="https://github.com/glroyal/nutricalc"><img id=github class=tstack style="width:auto;height:28px;" alt="GitHub" src="./a/github.png"></a></div>
       `;
    });

    </script>
    <form name="form1" id="form1" enctype="multipart/form-data" method="POST" action="<?php print($_SERVER['REQUEST_URI']);?>" onsubmit="return validate();"></form>
</body>
</html>