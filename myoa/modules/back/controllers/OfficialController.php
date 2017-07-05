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
    /**
     * behaviors.
     * @access
     * @return array
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-05
     * Time: 14:11:23
     * Description:行为层，ACF控制
     */
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
                        'roles' => ['@']//用户角色
                    ],
                    [
                        'allow' => false,
                        'actions' => ['index', 'manage'],
                        'roles' => ['?']//游客
                    ]
                ],
                'denyCallback' => function($rule, $action) {
                    return $this->redirect(['/back/manage/login']);
                }
            ]
        ];
    }

    /**
     * actionIndex.
     * @access
     * @return string
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-05
     * Time: 14:10:12
     * Description:日程列表显示
     */
    public function actionIndex() {
        //日程列表
        $query = Official::find()->orderBy(['time' => SORT_DESC]);
        $count = Official::find()->select('count(*)')->asArray()->scalar();
        //$count = $query->count();
        //分页
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $recordList = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', compact('recordList', 'pages'));
    }

    /**
     * actionManage.
     * @access
     * @return void
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-05
     * Time: 14:10:43
     * Description:管理操作
     */
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