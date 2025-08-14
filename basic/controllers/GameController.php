<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\Game;

class GameController extends Controller
{
    public function actionIndex()
    {
        return $output = new Game;
    }
}