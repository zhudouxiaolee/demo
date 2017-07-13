<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/7/12
 * Time: 11:28
 * Description:笔记管理
 */

namespace app\modules\back\controllers;


use yii\web\Controller;

class NotesController extends Controller
{
    /**
     * actionIndex.
     * @access
     * @return string
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-12
     * Time: 11:30:19
     * Description:笔记管理界面
     */
    public function actionIndex() {
        return $this->render('index');
    }
}