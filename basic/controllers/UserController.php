<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionIndex()
    {
        return $output = new User;
    }
}