<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 002 02.03.17
 * Time: 21:38
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class BehaviorsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'controllers' => ['site'],
                        'actions' => ['reg', 'login'],
                        'verbs' => ['GET', 'POST'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['site'],
                        'actions' => ['logout'],
                        'verbs' => ['POST'],
                        'roles' => ['@']
                    ],
                ]
            ]
        ];
    }

}