/**
 * @name validators.js
 * @description Javascript validation tools library, additional tools and embedded validation extensions
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl>
 * @version 0.9.4
 */

/**
 * Strange strings (e.g nicknames) protection
 * Allow a-zA-Z0-9 , - , _ and national chars
 */
function strangeStringsProtection(input) {
    var code  = "";
    var out   = "";
    var tSize = input.length;

    var denied = "~`!@#$%^&*()+=[]{};:'\"|\\,./?";
    
    for (var idx = 0; idx < tSize; idx++) {
        code = "" + input.substring(idx, idx + 1);

        if (denied.indexOf(code) == -1) {
            out += code;
        }
    }
    
    return out;
}

/**
 * Strict version of strange strict protection function
 * Allow: a-zA-Z0-9 , - and _ chars
 */
function strangeStringsProtectionStrict(input) {
    var out    = "";
    var dt     = 0;
    var result = "";

    var regExp = /[a-zA-Z0-9_-]+/;
    result = regExp.exec(input);

    if (result !== null) {
        dt = result.length;
        
        for (var i = 0; i < dt; i++) {
            out += result[i];
        }
    }

    return out;
}

/**
 * Simple client-side validation for file upload input
 */
function checkForValidFileExtension(elemVal) {
    var filePath = elemVal;

    if (filePath.indexOf('.') == -1)
        return false;

    var allowedExts = new Array("jpg", "jpeg", "pjpeg", "png");
    var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();

    for (var i = 0; i < allowedExts.length; i++) {
        if (ext == allowedExts[i])
            return true;
    }
    
    // not allowed
    return false;
}

/**
 * Email address - quick check
 */
function emailValidatorQuickTest(fieldVal) {
    // pattern
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(fieldVal)) {
        return false;
	}

    return true;
}

/**
 * Allow: 0-9 digits only
 */
function onlyDigitsUtil(input) {
    var out    = "";
    var dt     = 0;
    var result = "";

    var regExp = /[0-9]+/;
    result = regExp.exec(input);
    
    if (result !== null) {
        dt = result.length;
        
        for (var i = 0; i < dt; i++) {
            out += result[i];
        }
    }

    return out;
}

/**
 * Allow: 0-9, space and - chars
 */
function onlyForZipUtil(input) {
    var out    = "";
    var dt     = 0;
    var result = "";

    var regExp = /[0-9 -]+/;
    result = regExp.exec(input);

    if (result !== null) {
        dt = result.length;
        
        for (var i = 0; i < dt; i++) {
            out += result[i];
        }
    }

    return out;
}
