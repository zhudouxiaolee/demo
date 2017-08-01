<?php
/* @var $this \yii\web\view */
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/19
 * Time: 9:59
 * Description:
 */
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

//依赖加载js文件
AppAsset::addJsFile($this, '@web/js/official.js');
AppAsset::addCssFile($this, '@web/css/dataTables.css');
AppAsset::addJsFile($this, '@web/js/dataTables.js');
$this->title = '日程管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="official-index">

    <ul id="nav_tab" class="nav nav-tabs">
        <li><a href="#list" data-toggle="tab">日程列表</a></li>
        <li><a href="#add" data-toggle="tab">添加日程</a></li>
    </ul>
    <div class="tab-content">
        <!--日程列表显示-->
        <div id="list" class="tab-pane active">
            <table id="official_list" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-md-1 text-center">序号</th>
                        <th class="col-md-1 text-center">标题</th>
                        <th class="col-md-2 text-center">时间</th>
                        <th class="col-md-1 text-center">星期</th>
                        <th class="col-md-6 text-center">内容</th>
                        <th class="col-md-1 text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($recordList as $k => $v):?>
                    <tr>
                        <td class="text-center"><?= isset($_GET['page'])?($_GET['page']-1)*5+($k+1) : ($k+1)?></td>
                        <td class="text-center"><?= $v['title']?></td>
                        <td class="text-center"><?= date('Y-m-d H:i:s', $v['time'])?></td>
                        <td class="text-center"><?= Yii::$app->params['week'][date('w', $v['time'])]?></td>
                        <td class="content" data-id="<?= $v['id']?>" ondblclick="alter_daily(this)" style="cursor: pointer"><?= $v['content']?></td>
                        <td class="text-center">
                        <span class="glyphicon glyphicon-edit" title="编辑" style="cursor:pointer;"></span>
                            <span class="glyphicon glyphicon-trash" onclick="delete_daily_official(this)" data-id="<?= $v['id']?>" title="删除" style="cursor:pointer;"></span>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <!--分页-->
            <?= $this->render('@app/views/layouts/page.php', ['pages' => $pages, 'count' => $count])?>
        </div>
        <!--添加日程-->
        <div id="add" class="tab-pane col-lg-10 col-lg-offset-1">
        <?= Html::beginForm(['/back/official/manage'], 'post', ['onsubmit' => 'return is_empty_form();'])?>
            <div class="form-group">
                <?= Html::label('标题：', 'title')?>
                <?= Html::textInput('title', null, ['class' => 'form-control', 'id' => 'title'])?>
            </div>
            <div class="form-group">
                <?= Html::label('内容：', 'content')?>
                <?= Html::textarea('content', null, ['class' => 'form-control', 'id' => 'content', 'style' => 'resize:none', 'rows' => 8])?>
            </div>
            <?= Html::submitButton('提交', ['class' => 'btn btn-success radius'])?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default radius'])?>
        <?= Html::endForm()?>
        </div>
    </div>
<!--    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#alter-daily-modal">开启</button>-->
    <!--模态框-->
    <div class="modal fade" id="alter-daily-modal" tabindex="-1" role="dialog" aria-labelledby="测试模态框" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">修改日程内容</h4>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" placeholder="日程内容" rows="8" data-id="" data-oldv="" style="resize: none"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success" onclick="alter_daily_submit(this)">提交修改</button>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $this->beginBlock('js')?>
    //修改日程内容url
    var ALTERDAILYURL = '<?= Url::to(['official/alter-daily-official'])?>';
    //删除单挑日程记录url
    var DELETEDAILYURL = '<?= Url::to(['official/delete-daily-official'])?>';
    //tab标签切换调用（默认显示第一个）
    $('#nav_tab li:eq(0) a').tab('show');
    //dataTables
    $('#official_list').DataTable({
        'info':false,
        'paging':false,
        'searching':false,
        'columnDefs': [
            {'orderable':false, 'targets' : [4,5]}
        ]
    });
<?php $this->endBlock()?>
<?php $this->registerJs($this->blocks['js'], \yii\web\view::POS_END)?>