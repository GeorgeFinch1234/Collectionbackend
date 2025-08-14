<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\Game;
use yii\filters\auth\HttpBasicAuth;

class GameController extends Controller
{
    public function actionIndex()
    {
        return $output = new Game();
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