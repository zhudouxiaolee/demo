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
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Response;

/** @noinspection PhpInconsistentReturnPointsInspection */
class OfficialController extends Controller
{
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
        $where = ['id' => Yii::$app->user->id];
        $userModel = User::findOne($where);
        $count = $userModel->getOfficialList()->count();
        //分页
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $recordList = $userModel->getOfficialList()->orderBy(['id' => SORT_DESC])->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', compact('recordList', 'pages', 'count'));
    }

    /**
     * actionManage.
     * @access
     * @return string|Response
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-05
     * Time: 14:10:43
     * Description:日报管理操作
     */
    public function actionManage() {
        //获取request组件
        $req = Yii::$app->request;
        if($req->isPost) {
            $postData = $req->post();
            if(empty($postData['title']) || empty($postData['content'])) {
                return $this->error('标题或内容不能为空', '日程管理');
            }else {
                $officialModel = new Official();
                $officialModel->saveOfficialRecord($postData['title'], $postData['content']);
                return $this->goBack(['back/official/index']);
            }
        }else {
            return $this->error('非法访问', '403');
        }
    }

    /**
     * actionAlterDailyOfficial.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-13
     * Time: 12:02:26
     * Description:修改日程内容
     */
    public function actionAlterDailyOfficial() {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        if($request->isAjax) {
            $postData = $request->post();
            $rows = Official::updateAll(['content' => $postData['content']], ['id' => $postData['id']]);
            if($rows) {
                $response->data = ['status' => 1, 'msg' => '修改成功'];
            }else {
                $response->data = ['status' => 0, 'msg' => '修改失败'];
            }
        }else {
            $response->data = ['status' => 0, 'msg' => '修改失败'];
        }
        return $response->data;
    }

    /**
     * actionDeleteDailyOfficial.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-13
     * Time: 15:19:30
     * Description:删除单条日程记录
     */
    public function actionDeleteDailyOfficial() {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        if($request->isAjax) {
            $postData = $request->post();
            $rows = Official::deleteAll(['id' => $postData['id']]);
            if($rows) {
                $response->data = ['status' => 1, 'msg' => '已删除!'];
            }else {
                $response->data = ['status' => 0, 'msg' => '删除失败!'];
            }
        }else {
            $response->data = ['status' => 0, 'msg' => '非法访问'];
        }
        return $response->data;
    }
}