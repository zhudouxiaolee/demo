<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/19
 * Time: 9:56
 * Description:
 */

namespace app\modules\back\controllers;


use app\models\Official;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class OfficialController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' =>  ['index', 'manage'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'manage'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false,
                        'actions' => ['index', 'manage'],
                        'roles' => ['?']
                    ]
                ],
                'denyCallback' => function($rule, $action) {
                    return $this->redirect(['/back/manage/login']);
                }
            ]
        ];
    }

    public function actionIndex() {
        //日程列表
        $query = Official::find()->orderBy(['time' => SORT_DESC]);
        $count = $query->count();
        //分页
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $recordList = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', compact('recordList', 'pages'));
    }

    public function actionManage() {
        //获取request组件
        $req = Yii::$app->request;
        if($req->isPost) {
            $postData = $req->post();
            if(empty($postData['title']) || empty($postData['content'])) {

            }else {
                $officialModel = new Official();
                $officialModel->saveOfficialRecord($postData['title'], $postData['content']);
            }
            $this->goBack(['back/official/index']);
        }
    }
}