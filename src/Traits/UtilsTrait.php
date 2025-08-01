<?php

namespace ArcdevPackages\Core\Traits;

use HTMLPurifier;
use HTMLPurifier_Config;
trait UtilsTrait {

    public function clearChars($input) {
	    if(isset($input)){ //[`~!#\$%\^&\*\(\)\+=\{\}\[\]\,\|\\/@_\<\>\?\';:\"]
	        $input = trim(preg_replace('/[`~#\$%\^\*=\{\}\[\]\<\>\?;]/', '', $input));
	    }

        if($input == 'null'){
            return null;
        }
	    return $input;
    }

    public function santizeHtmlContent($input) {
	    if(isset($input)){
            // Sanitize the HTML content
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $input = $purifier->purify($input);
	    }

	    return $input;
    }
}