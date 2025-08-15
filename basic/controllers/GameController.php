<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\Game;
use yii\filters\auth\HttpBasicAuth;
use Kreait\Firebase\Factory;


class GameController extends Controller
{
    public function actionIndex()
    {
      
        $factory = (new Factory)->withServiceAccount("../config/firebase_credentials.json");
        $factory = $factory->withDatabaseUri((new \app\models\DBURL)->URL);
        $database = $factory->createDatabase();


         $snapshot = $database->getReference('/BoardGame/ticketToRide');

         return $snapshot->getValue();
        
      
       
        
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