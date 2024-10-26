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
var 
    window_width, window_height, scrollbar_width, 
    viewport_width, viewport_height,

    mustate=0;

get_window_geometry(); 

const   
    last_width = viewport_width, 
    last_height = viewport_height,

    COOKIEPATH = "/",
    COOKIEDOMAIN = "",
    COOKIESECURE = ('https:' == document.location.protocol),
    
    $_COOKIE = function() {

        var params = {},
            pairs = document.cookie.split('; '),
            pl = pairs.length,
            nameVal,
            i;

        if (pl > 0) {
            for (i = 0; i < pl; i++) {
                nameVal = pairs[i].split('=');
                params[nameVal[0]] = unescape(nameVal[1]);
            }
        }

        return params;
    }(),

//    CSRF = $_COOKIE[(COOKIESECURE) ? '__Host-csrf_token' : 'csrf_token'],
    CSRF = true,
    MOBILE = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
    DESKTOP = !MOBILE,
    TODAY = new Date(),
    ANONYMOUS = '000000',
    SYSOP = '999999',

    udata = ("_udata" in $_COOKIE) ? atob($_COOKIE['_udata']).split("\t") : [ANONYMOUS, 'anonymous', '0000', 'Z', 0, 0],
    ulevel = ((udata[0] == ANONYMOUS)?0:((udata[0] == SYSOP)?4:(udata[3] == 'A')?2:1)),

    icons = {
        "ic_menu" : '<img id="ic_menu" class=icon alt="Menu" width=24 height=24 src="./a/k/menu_24dp_222_FILL0_wght400_GRAD0_opsz24.svg">',
        "ic_close" : '<img id="ic_close" class=icon alt="Close" width=24 height=24 src="./a/k/close_24dp_222_FILL0_wght400_GRAD0_opsz24.svg">',
    },

    mu =[["Recipes","recipe_editor.php"],
        ["Ingredients","ingredients.php"],
        ["Nutrients","nutrients.php"],
        ["PDA","pda.php"],
        ["About","about.php"]],
    
    noicon = '<div class="icon">&nbsp</div>',
    
    mlogo = '<span class="mlogo">NutriCalc</span>';


function get_window_geometry() {

    window_width = function() {
        var x = 0;
        if (self.innerHeight) {
            x = self.innerWidth;
        } else if (document.documentElement && document.documentElement.clientHeight) {
            x = document.documentElement.clientWidth;
        } else if (document.body) {
            x = document.body.clientWidth;
        }
        return x;
    }(),

    window_height = function() {
        var y = 0;
        if (self.innerHeight) {
            y = self.innerHeight;
        } else if (document.documentElement && document.documentElement.clientHeight) {
            y = document.documentElement.clientHeight;
        } else if (document.body) {
            y = document.body.clientHeight;
        }
        return y;
    }(),

    scrollbar_width = function() {
        // Creating invisible container
        const outer = document.createElement('div');
        outer.style.visibility = 'hidden';
        outer.style.overflow = 'scroll'; // forcing scrollbar to appear
        outer.style.msOverflowStyle = 'scrollbar'; // needed for WinJS apps
        document.body.appendChild(outer);

        // Creating inner element and placing it in the container
        const inner = document.createElement('div');
        outer.appendChild(inner);

        // Calculating difference between container's full width and the child width
        const scrollbar_width = (outer.offsetWidth - inner.offsetWidth);

        // Removing temporary elements from the DOM
        outer.parentNode.removeChild(outer);

        return scrollbar_width;
    }();

    const
        viewport_width = window_width, // - scrollbar_width;
        viewport_height = window_height - 38; // control bar adjustment     
}


function colorbar() {
    barcolor = Math.abs(barcolor -1);
    return (barcolor) ? "" : "gry";
}


function $(el) {

    // that handy $('foo') shortcut thing

    try {
        return (typeof el == 'string') ? document.getElementById(el) : el;
    } catch (e) {
        if (debug) {
            alert(el);
        }
    }
}       

function setCookie(name, value, expires, path, domain, secure) {

    path = path || COOKIEPATH;
    domain = domain || COOKIEDOMAIN;
    secure = secure || COOKIESECURE;

    document.cookie = name + "=" + escape(value) + ((expires) ? "; expires=" + expires.toGMTString() : "") + ((path) ? "; path=" + path : "") + ((domain) ? "; domain=" + domain : "") + ((secure) ? "; secure" : "");
}

function deleteCookie(name, path, domain) {

    path = path || COOKIEPATH;
    domain = domain || COOKIEDOMAIN;

    if (typeof $_COOKIE['name'] !== 'undefined') {
        document.cookie = name + "=" + ((path) ? "; path=" + path : "") + ((domain) ? "; domain=" + domain : "") + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}

function base64urlEncode(str) {
  const base64Encoded = btoa(str); // Use btoa() for Base64 encoding
  return base64Encoded.replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, ''); // Replace '+' with '-', '/' with '_', and remove trailing '='
}

function base64urlDecode(encodedString) {
  const m = encodedString.length % 4;
  const paddedEncoded = encodedString.padEnd(encodedString.length + (m === 0 ? 0 : 4 - m), '=');
  const decodedBytes = atob(paddedEncoded.replace(/-/g, '+').replace(/_/g, '/'));
  return new TextDecoder('utf-8').decode(decodedBytes);
}


function page_refresh() {
    location.reload();
}

function jump_to(page) {
    window.location.href = page;
}

function jsr(url) {
    setCookie('_rts',base64urlEncode(window.location.pathname));
    jump_to(url); 
}

function rts() {
    if($_COOKIE.includes('_rts')) {
        url = base64urlDecode($_COOKIE['_rts']);
        deleteCookie('_rts');
        jump_to(url);
    }
}


function print_r(obj) {
        console.log(JSON.stringify(obj));
}


function isSet(el) {
    $(el).value = $(el).value.trim();
    return ($(el).style.backgroundColor == document.body.style.backgroundColor && $(el).value != '')  ? true : false;
}

function setErr(el) {
    $(el).style.backgroundColor = 'pink'; return false;
}

function clrErr(el) {
    if($(el).style.backgroundColor == 'pink') {
        $(el).style.backgroundColor = document.body.style.backgroundColor;
        $(el).value = '';
    }
}

function validate() {
    console.log('default validation');
    return false;
}



function toggle_menu() {

    mustate = Math. abs(mustate-1);

    if(mustate==0) {
        $('menu').style.left = "-166px";
    } else {
        $('menu').style.left = "0px";
    }
}


function set_menu(ls) {

    ls = 0 || ls;
    
    var i, j=0, p=[], mcls, pgtitle;

    for (i=0; i<mu.length; i++) {

        mcls = (ls == i) ? 'vm2' : 'vm1';

        pgtitle = mu[i][0].toUpperCase();
        
        p[j] = '<a ' + ((mcls == 'vm0') ? '' : 'href="' + mu[i][1] + '"') + ' class="' + mcls + '">' + mu[i][0] + '</a>'; j++;  
    }

    return p.join('');
}


function render_outer(ls) {

    $('form1').innerHTML = MOBILE ? `

        <div id="header">
            <div id="menubar" class="m0 hflex" style="">
                <span onclick="toggle_menu();">${icons["ic_menu"]}</span>
                <span>${mlogo}</span>
                <span class="ico">${noicon}</span>
            </div>
            <div id=menu>${set_menu(ls)}</div>
        </div> 
        <div id="titlebar" class=hbk style="">${mu[ls][0]}</div>
        <div id="pga">
            <div class="vflex z0">
                <div id="inner"></div>  
            </div>  
        </div>

        <input type="hidden" name="csrf" id="csrf" value="${CSRF}">    
    ` : `
        <div id="header">
            <div id="menubar" class="m0 hflex" style="">
                <span onclick="toggle_menu();">${icons["ic_menu"]}</span>
                <span>${mlogo}</span>
                <span class="ico">${noicon}</span>
            </div>
            <div id=menu>${set_menu(ls)}</div>
        </div> 
        <div id="titlebar" class=hbk style="">${mu[ls][0]}</div>
        <div id="pga">
            <div class="vflex z0">
                <div id="inner"></div>  
            </div>  
        </div>

        <input type="hidden" name="csrf" id="csrf" value="${CSRF}">  

    `;
} 