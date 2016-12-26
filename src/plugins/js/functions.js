//	ARQUIVO DE FUNÇÕES BÁSICAS DE JAVASCRIPT	//
//			DESENVOLVIDO POR OVELHAS			//

function import_js(url) {
	var tag = document.createElement("script");
	tag.type="text/javascript";
	tag.src = url;
	document.body.appendChild(tag);
}

function ajeita(palavra) {
	var nome_final;
	nome_final = "";
	
	//Deixa tudo em minuscula
	palavra = palavra.toLowerCase();
	
	//Dividindo a palavra num array
	palavra = palavra.split(" ");
	
	for (IntFor = 0; IntFor < palavra.length; IntFor++) {
		if (palavra[IntFor] == "de" || palavra[IntFor] == "la" || palavra[IntFor] == "el" || palavra[IntFor] == "dos" || palavra[IntFor] == "da" || palavra[IntFor] == "das" || palavra[IntFor] == "do" || palavra[IntFor] == "com" || palavra[IntFor] == "e" || palavra[IntFor] == "na" || palavra[IntFor] == "no" || palavra[IntFor] == "nas" || palavra[IntFor] == "nos" || palavra[IntFor] == "às" || palavra[IntFor] == "a" || palavra[IntFor] == "e" || palavra[IntFor] == "o" || palavra[IntFor] == "ou" || palavra[IntFor] == "para" || palavra[IntFor] == "pra" || palavra[IntFor] == "pras" || palavra[IntFor] == "y") {
		}
		
		else {
			//Primeira letra maiuscula
			palavra[IntFor] = ucfirst(palavra[IntFor]);
			
			//dando umas ajeitadas básicas
			if (palavra[IntFor] == "Sao") {
				palavra[IntFor] = "São";
			}
			
			else if (palavra[IntFor] == "Joao") {
				palavra[IntFor] = "João";
			}
		}
	}
	palavra = palavra.join(" ");
	return palavra;
}

function ucfirst(str) { //Upper Case First, deixa a primeira letra da palavra em maiuscula
	str1 = str.substring(0,1);
	str = str.replace(str1, str1.toUpperCase());
	return str;
}

function strstr (haystack, needle, bool) {
    // Finds first occurrence of a string within another  
    // 
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/strstr    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: strstr('Kevin van Zonneveld', 'van');
    // *     returns 1: 'van Zonneveld'    // *     example 2: strstr('Kevin van Zonneveld', 'van', true);
    // *     returns 2: 'Kevin '
    // *     example 3: strstr('name@example.com', '@');
    // *     returns 3: '@example.com'
    // *     example 4: strstr('name@example.com', '@', true);    // *     returns 4: 'name'
    var pos = 0;
 
    haystack += '';
    pos = haystack.indexOf(needle);    if (pos == -1) {
        return false;
    } else {
        if (bool) {
            return haystack.substr(0, pos);        } else {
            return haystack.slice(pos);
        }
    }
}

function str_replace (search, replace, subject, count) {
    // Replaces all occurrences of search in haystack with replace  
    // 
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/str_replace    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Gabriel Paderni
    // +   improved by: Philip Peterson
    // +   improved by: Simon Willison (http://simonwillison.net)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)    // +   bugfixed by: Anton Ongson
    // +      input by: Onno Marsman
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    tweaked by: Onno Marsman
    // +      input by: Brett Zamir (http://brett-zamir.me)    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   input by: Oleg Eremeev
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Oleg Eremeev
    // %          note 1: The count parameter must be passed as a string in order    // %          note 1:  to find a global variable in which the result will be given
    // *     example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
    // *     returns 1: 'Kevin.van.Zonneveld'
    // *     example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
    // *     returns 2: 'hemmo, mars'    var i = 0,
        j = 0,
        temp = '',
        repl = '',
        sl = 0,        fl = 0,
        f = [].concat(search),
        r = [].concat(replace),
        s = subject,
        ra = Object.prototype.toString.call(r) === '[object Array]',        sa = Object.prototype.toString.call(s) === '[object Array]';
    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    } 
    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + '';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {                this.window[count] += (temp.length - s[i].length) / f[j].length;
            }
        }
    }
    return sa ? s : s[0];}