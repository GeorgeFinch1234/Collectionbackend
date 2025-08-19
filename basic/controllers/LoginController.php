<?php

namespace app\controllers;
use yii\rest\Controller;


class LoginController extends Controller
{
    public function actionIndex()
   {
    /*
    'POST login/<userName>/<password>' =>'login/index',
    */
return $_GET['userName'] . " " . $_GET['password'] ;


    }


    public function behaviors()
{
    return [
        'verbs' => [
            'class' => \yii\filters\VerbFilter::class,
            'actions' => [
                'index'  => ['post'],
                
            ],
        ],
    ];
}
}


