<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\User;
use app\models\databaseConnetion;


class MessagingController extends Controller
{
    
public $db;


public function __construct($id, $module, $config = []){
     parent::__construct($id, $module, $config);
$this->db = new databaseConnetion();


}




public function actionFindUser(){

return $this->db->getUserGames();


}

public function actionSendMessage(){
return $this->db->setMessage();





}

public function actionLoadGame(){
return $this->db->setMessage();

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