/**
 * @name tools.js
 * @description Javascript tools library
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl>
 * @version 0.3
 */

// debugger flag
var _global_jsdebug_mode = false;

/**
 * XML processing - getting a value from XML
 * @version 2.0
 */
function getXmlValue(input, xmlMarkup) {
    var beg    = "";
    var end    = "";
    var dt     = 0;
    var xmlVal = "";
    
    var start = "<" + xmlMarkup + ">";
    var stop  = "</" + xmlMarkup + ">";

    beg = input.indexOf(start);
    end = input.indexOf(stop);
    
    dt = start.length;

    if ( (beg !== false) && (end !== false) ) {
        xmlVal = input.substr(beg + dt, end - beg - dt);
	}
    
    return xmlVal;
}

