<?php

    /*
    *   
    * This File Include lang Function That Change The language Of Website To English
    *
    */

    /* WELCOME && ADMIN appear when you serf FOUCES HE USE KEY phrase to call array */
    function lang( $phrase ){
        
        static $lang = array(
        
        	// Admin Dashboard

            'Home_Admin'		=>	'Home' ,
            'Categories_Admin'	=>	'Categories' ,
            'Items_Admin'		=>	'Items' ,
            'Members_Admin'		=>	'Members' ,
            'Statistics_Admin'	=>	'Statistics' ,
            'Comments_Admin'    =>  'Comments' ,
            'Logs_Admin'		=>	'Logs' ,
            'EditProfile_Admin'	=>	'EditProfile' ,
            'Setting_Admin'		=>	'Setting' ,
            'Logout_Admin'		=>	'Logout' ,
            'Shop_Admin'        =>  'Shop' ,

            '' =>' '
            
        );
        
        return $lang[$phrase];
        
    }

?> 
<?php

/* saleh appear when you serf */
//    $lang = array(
//    
//        'name'=>'saleh'
//    );
//    each $lang['name'];

?>