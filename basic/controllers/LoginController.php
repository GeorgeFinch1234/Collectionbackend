<?php

namespace app\controllers;
use yii\rest\Controller;
use app\models\signIn;
use app\models\basicValidaiton;
use yii\filters\auth\HttpBasicAuth;

class LoginController extends Controller
{
    public function actionIndex()
   {
   $error="";
    $loginCheck = new signIn();
    $validator = new basicValidaiton();
    
   $error = $validator->stringManditory($_POST['username']);
    $error = $validator->stringManditory($_POST['password']);
   
   if($error==""){
    /* should make access token here and try to store it
    or make it in another database somwhere
    */
    return $loginCheck->login($_POST['username'], hash('sha256', $_POST['password']));
    }else{
        return $error;
    }
    
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


