<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'SJeplhEIhGCBfx2tbmWeosrT0l_9i8Ep',
        ],
        'urlManager' => [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        /*
        ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'game'],
        */
        'POST login' =>'login/index',
        'games' => 'game/index', 
        'create' => 'game/create-game', 
        'POST signup' => 'login/sign-up',
        'POST delete/game' => 'game/delete-game',
        'POST game/data' =>'game/game-data',
        'edit' => 'game/edit-game',
        'POST find-user' => 'messaging/find-user',
        'POST send-message' => 'messaging/send-message',
        'POST load-game-for-message' => 'game/game-data-from-user-name',
        'POST get-messages' => 'messaging/get-messages',
        'POST load-game-for-received-messaging' => 'messaging/game-data-from-user-name',
        'POST games-filter' => 'game/games-filter',
        'POST message/delete'=>'messaging/delete',
        'POST message/Specific' => 'messaging/get-specific-message',
        'POST message/reply' => 'messaging/set-message-reply',
        'POST message/Specific/not-token' => 'messaging/get-specific-message-not-token',
    ],
],
'response' => [
    'format' => \yii\web\Response::FORMAT_JSON,
    'charset' => 'UTF-8',
],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
