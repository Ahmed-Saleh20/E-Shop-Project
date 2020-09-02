<?php

    /*
	* 	
	* This File Include lang Function That Change The language Of Website To Arabic
	*
	*/

    function lang( $phrase ){
        
        static $lang = array(
        
            'MESSAGE'=>'اهلا',
            'TYPE'=>'المدير'
            
        );
        
        return $lang[$phrase]
        
    }

?> 