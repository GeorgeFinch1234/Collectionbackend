<?php

namespace app\controllers;
use yii\rest\Controller;
use app\models\signIn;
use app\models\basicValidaiton;
use app\models\databaseConnetion;
use yii\filters\auth\HttpBasicAuth;

class LoginController extends Controller
{
    public function actionIndex()
   {
   
    $error="";
    $loginCheck = new signIn();
    $validator = new basicValidaiton();
    $token = new databaseConnetion();
    $errorFrom="";
   $error = $validator->stringManditory($_POST['username']);
   if($error != ""){
    $errorFrom = "username";
   }else{
    /*
so only runs if pass initial test, as no need to run multiple test if cant past first
    */

    $error = $validator->stringManditory($_POST['password']);
   
    if($error != ""){
    $errorFrom = "password";
   }
   }


   
   
   if($error==""){
    /* should make access token here and try to store it
    or make it in another database somwhere
    */

    $error= $loginCheck->login($_POST['username'], hash('sha256', $_POST['password']));
if($error=="") {

    return ["error"=>$error, "token"=>$token -> setAccessToken($_POST['username']),"isAdmin"=>$token->getAdminStatus()];
}  else{
    return ["error"=>$error];
}

}else{
      return   ["error"=>$error,  "errorFrom"=>$errorFrom];
    }
    
    
    return "";
    }



public function actionSignUp(){

    
$signUp = new databaseConnetion();
$outputTest = $signUp -> createUser($_POST['username'], $_POST['password']);
return ["error"=>$outputTest, "token"=>$signUp -> setAccessToken($_POST['username'])];
}
public function behaviors()
{
    $behaviors = parent::behaviors();

    // remove authentication filter
    $auth = $behaviors['authenticator'];
    unset($behaviors['authenticator']);
    
    // add CORS filter
    $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::class,
        
    ];
    
    // re-add authentication filter
    $behaviors['authenticator'] = $auth;
    // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
    $behaviors['authenticator']['except'] = ['options'];

    return $behaviors;
} 



}


