<?php
error_reporting(-1);
if_vendor_exists();
/**
 * 
 * 
 * */
function env($key='', $optional_val=null){


    $filename   =   get_env_file();


    if(!file_exists($filename)){
        
        return $optional_val;
    }


    $data = file_get_contents($filename);
    $all_vars   =   explode(PHP_EOL,$data);
    //echo "<pre>";
    //die(print_r(array_filter($all_vars)));

    $all_vars   =   array_filter($all_vars);

    foreach($all_vars as $var=>$value){
        if($value==''){
            continue;
        }
        
        
        $single_var     =   explode('=',$value);
        
        /** If current row is not the requested row, skip  */
        if( $single_var[ 0 ] != $key){
            continue;
        }else{
            return $single_var[ 1 ];
        }



        if($single_var[ 1 ]==''){
            die('Value not available for #'.$single_var[ 0 ]);
        }
        
        /** Save requested value in array and return */
        $global_config[ $single_var[ 0 ] ]  =   $single_var[1];
        
    }
    return $global_config[$key];
}



function get_env_file()
{

    return 'config/.ENV';
    

}


/**
 * 
 * Check if vendor folder exists for CI run,
 * if not, composer install needed to be run
 * 
*/
function if_vendor_exists(){
    if(!file_exists('vendor')){
        die('Please run `composer install` command in root directory to continue');
    }
}