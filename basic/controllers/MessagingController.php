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

public function actionGetMessages(){
//$this->db->getUserNameFromToken($_POST["Token"])
return $this->db->getMessages($this->db->getUserNameFromToken($_POST["token"]));

}

public function actionGameDataFromUserName(){
$databaseConnection = new databaseConnetion();
return $databaseConnection->getSelectedGameData($this->db->getUserNameFromToken($_POST["UserName"]), $_POST["Game"]);


}




public function actionDelete(){

return $this->db->deleteMessage();

}




public function actionGetSpecificMessage(){

$data =$this->db->getSpecificMessage();

$data['ID']=$_POST['messageID'];
return $data;


}


public function actionGetSpecificMessageNotToken(){
 
$data =$this->db->getSpecificMessageNotToken();

$data['ID']=$_POST['messageID'];
return $data;


}


public function actionSetMessageReply(){

$this->db->setMessageReply();

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