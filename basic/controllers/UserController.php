<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\User;
use app\models\databaseConnetion;

class UserController extends Controller
{

public $db;


public function __construct($id, $module, $config = []){
     parent::__construct($id, $module, $config);
$this->db = new databaseConnetion();


}


    public function actionIndex()
    {
        return $output = new User;
    }


    public function actionGetAllUsers(){


return $this->db->getAllUsers();

    }
public function actionSetAdminStatus(){




return $this->db->setAdminStatus();

}



public function actionGetUserNameFromAccessToken(){

return $this->db->getUserNameFromToken($_POST["token"]);


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