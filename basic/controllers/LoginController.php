<?php

namespace app\controllers;
use yii\rest\Controller;
use app\models\signIn;
use yii\filters\auth\HttpBasicAuth;

class LoginController extends Controller
{
    public function actionIndex()
   {
   
    $loginCheck = new signIn();
    return $loginCheck->login($_POST['username'], hash('sha256', $_POST['password']));
   
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


