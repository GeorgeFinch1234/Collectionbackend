<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\databaseConnetion;

class SettingsController extends Controller
{

public $db;


public function __construct($id, $module, $config = []){
     parent::__construct($id, $module, $config);
$this->db = new databaseConnetion();


}




    public function actionDeleteAccount(){
$this->db->deleteAcount();
    }
    public function actionClearCollection(){
$this->db->clearCollection();
    }
    public function actionClearMessages(){
       $this->db-> clearMessages();
    }


    public function actionDeleteAccountNoToken(){
return $this->db->deleteAcountNoToken();
    }
    public function actionClearCollectionNoToken(){
$this->db->clearCollectionNoToken();
    }
    public function actionClearMessagesNoToken(){
       $this->db-> clearMessagesNoToken();
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