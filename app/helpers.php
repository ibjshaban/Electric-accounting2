<?php
if(!function_exists('ShekelFormat')){
    function ShekelFormat($amount){
        return '₪'.number_format($amount, 2);
    }
}

if(!function_exists('InsertLargeNumber')){
    function InsertLargeNumber($number){
        return  str_replace(',', '',number_format($number,2));
    }
}
?>
