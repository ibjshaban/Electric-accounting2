<?php
if(!function_exists('ShekelFormat')){
    function ShekelFormat($amount){
        return '₪'.number_format($amount, 1);
    }
}
?>
