<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/7/12
 * Time: 11:28
 * Description:笔记管理
 */

namespace app\modules\back\controllers;


use app\models\Category;
use app\models\Notes;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
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
        $request = Yii::$app->request;
        //初始化查询
        $search = [
            'start_date' => date('Y-m-d', strtotime('last week')),
            'end_date' => '',
            'notes_title' => '',//关键词
            'notes_category' => -1//分类(-1:全部；0:未分类；其他:各分类ID)
        ];
        if($request->isGet && $getData = $request->get()) {
            $search = ArrayHelper::merge($search, $getData);
        }
        //初始化查询条件
        $where = ['and'];
        if($search['start_date']) {
            $where[] = ['>', 'addtime', strtotime($search['start_date'])];
        }
        if($search['end_date']) {
            $where[] = ['<', 'addtime', strtotime('next day', strtotime($search['end_date']))];
        }
        //条件分类：如果是-1，则取全部记录；否则，未分类的是cateid=0；特殊分类的是分类ID(cateid)
        if($search['notes_category'] >= 0) {
            $where[] = ['cateid' => $search['notes_category']];
        }
        if($search['notes_title']) {
            $where[] = ['like', 'title', $search['notes_title']];
        }
        //查询用户
        $id = Yii::$app->user->id;
        $user = User::findOne($id);
        //获取该用户下的所有笔记
        $notes = $user->getNotesList()->where($where);
        $count = $notes->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $notesList = $notes->orderBy(['id' => SORT_DESC])->offset($pages->offset)->limit($pages->limit)->all();

        //获取该用户下的所有笔记分类
        $cateResult = $user->getCategory()->alias('c')->leftJoin(['n' => Notes::tableName()], 'n.cateid = c.id')->select(['c.id', 'c.name', 'count(ifnull(`n`.`id`,null)) as notestotal'])->groupBy('c.id')->orderBy('convert(`c`.`name` using gbk)')->asArray()->all();
        //笔记列表select框需要的数组
        if($cateResult) {
            $cateList = array_reduce($cateResult,function ($result, $item) {
                $result[$item['id']] = $item['name'];
                return $result;
            });
        }else {
            $cateList = [];
        }
        return $this->render('index', compact('notesList', 'search', 'cateList', 'cateResult', 'pages', 'count'));
    }

    /**
     * actionNotesAdd.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-26
     * Time: 15:52:14
     * Description:添加笔记
     */
    public function actionNotesAdd() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $postData = $request->post();
            $notesModel = new Notes();
            if($notesModel->notesAdd($postData)) {
                $result = $this->restFulResult('添加成功', 1, Url::to(['notes/index']));
            }else {
                $result = $this->restFulResult('添加失败', 0);
            }
        }else {
            $result = $this->restFulResult('非法访问', 0);
        }
        return $result;
    }

    /**
     * actionNotesAlter.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-27
     * Time: 18:03:11
     * Description:修改笔记内容
     */
    public function actionNotesAlter() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $postData = $request->post();
            //判断是否有数据获取到
            if(!empty($postData)) {
                //更新笔记内容
                $rows = Notes::updateAll(['content' => $postData['content']], ['id' => $postData['id']]);
                if($rows) {
                    $result = $this->restFulResult('修改成功', 1, Url::to(['notes/index']));
                }else {
                    $result = $this->restFulResult('未修改', 0);
                }
            }else {
                $result = $this->restFulResult('未获取到修改的数据', 0);
            }
        }else {
            $result = $this->restFulResult('非法访问', 0);
        }
        return $result;
    }

    /**
     * actionNotesDelete.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-27
     * Time: 19:05:01
     * Description:删除笔记
     */
    public function actionNotesDelete() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $postData = $request->post();
            if(!empty($postData)) {
                $rows = Notes::deleteAll(['id' => $postData['id']]);
                if($rows) {
                    $result = $this->restFulResult('删除成功', 1);
                }else {
                    $result = $this->restFulResult('删除失败', 0);
                }
            }else {
                $result = $this->restFulResult('未获取到需要删除的数据', 0);
            }
        }else {
            $result = $this->restFulResult('非法访问', 0);
        }
        return $result;
    }

    /**
     * actionNotesCateList.
     * @access
     * @return mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-28
     * Time: 11:14:19
     * Description:显示用户的所有分类信息
     */
    public function actionNotesCateList() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $id = Yii::$app->user->id;
            $user = User::findOne($id);
            $cateResult = $user->getCategory()->select(['id', 'name'])->orderBy('convert(`name` using gbk)')->asArray()->all();
            if($cateResult) {
                $result = $cateResult;
            }else {
                $result = false;
            }
        }else {
            $result = false;
        }
        return $this->dataFormat($result);
    }

    /**
     * actionCateAdd.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-29
     * Time: 14:12:19
     * Description:添加分类
     */
    public function actionCateAdd() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $postData = $request->post();
            if($postData) {
                $cateModel = new Category();
                $rows = $cateModel->cateAdd($postData['name']);
                if($rows) {
                    $result = $this->restFulResult('添加成功', 1);
                }else {
                    $result = $this->restFulResult('添加失败', 0);
                }
            }else {
                $result = $this->restFulResult('未获取到要添加的数据', 0);
            }
        }else {
            $result = $this->restFulResult('非法访问', 0);
        }
        return $result;
    }

    /**
     * actionNotesCateAlter.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-28
     * Time: 13:59:36
     * Description:修改笔记所属的分类
     */
    public function actionNotesCateAlter() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $postData = $request->post();
            $rows = Notes::updateAll(['cateid' => $postData['cateid']], ['id' => $postData['notesid']]);
            if($rows) {
                $result = $this->restFulResult('修改成功', 1);
            }else {
                $result = $this->restFulResult('未修改', 0);
            }
        }else {
            $result = $this->restFulResult('非法访问', 0);
        }
        return $result;
    }

    /**
     * actionCateAlter.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-29
     * Time: 11:16:32
     * Description:删除分类信息
     */
    public function actionCateDelete() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $postData = $request->post();
            if($postData) {
                $uid = Yii::$app->user->id;
                $rows = Category::deleteAll(['id' => $postData['cateid']]);
                if($rows) {
                    Notes::updateAll(['cateid' => 0], ['uid' => $uid, 'cateid' => $postData['cateid']]);
                    $result = $this->restFulResult('删除成功', 1);
                }else {
                    $result = $this->restFulResult('未找到删除数据', 0);
                }
            }else {
                $result = $this->restFulResult('未获取到要删除的数据', 0);
            }
        }else {
            $result = $this->restFulResult('非法访问', 0);
        }
        return $result;
    }

    /**
     * actionCateAlter.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-29
     * Time: 12:46:28
     * Description:修改分类的名称
     */
    public function actionCateAlter() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $postData = $request->post();
            if($postData) {
                $rows = Category::updateAll(['name' => $postData['name']], ['id' => $postData['id']]);
                if($rows) {
                    $result = $this->restFulResult('修改成功', 1);
                }else {
                    $result = $this->restFulResult('修改失败', 0);
                }
            }else {
                $result = $this->restFulResult('未获取到要修改的数据', 9);
            }
        }else {
            $result = $this->restFulResult('非法访问', 0);
        }
        return $result;
    }
}