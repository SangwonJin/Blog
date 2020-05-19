<?php
    function redirect_to($location = Null){
        if($location!=NULL){
            header("Location: {$location}");
            exit;
        }
    }
?>