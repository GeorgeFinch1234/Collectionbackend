<?php
namespace app\models;


class basicValidaiton 
{
    
    public function stringManditory($data){
        $output ="";

        if(!is_string($data)){
            $output="must be a string";
        }else if($data==""){
            $output="must be present";
        }else if(strlen($data)>50){
            $output="max length is 50 characters";
        }
        //# just a delimiter required to not get an error
        else if(!preg_match("/^[a-zA-Z0-9]+$/",$data) ){
           $output = "only a-Z and 0-9 allowed";
        }

           return $output;
    }
    
}