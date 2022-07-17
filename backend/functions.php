<?php

    function hasInvalidCharacters($text){

        return(bool) preg_match('/[®♀0£{}:"!/\|=+-;<>/u', $text);

    }
    
?>