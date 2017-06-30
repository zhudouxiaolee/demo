<?php
/* @var $this \yii\web\view */
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/19
 * Time: 9:59
 * Description:
 */
use yii\helpers\Html;


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
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-md-1 text-center">标题</th>
                        <th class="col-md-2 text-center">时间</th>
                        <th class="col-md-1 text-center">星期</th>
                        <th class="col-md-7 text-center">内容</th>
                        <th class="col-md-1 text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($recordList as $v):?>
                    <tr>
                        <td class="text-center"><?= $v['title']?></td>
                        <td class="text-center"><?= date('Y-m-d H:i:s', $v['time'])?></td>
                        <td class="text-center"><?= Yii::$app->params['week'][date('w', $v['time'])]?></td>
                        <td><?= $v['content']?></td>
                        <td class="text-center">
                            <span class="glyphicon glyphicon-edit" title="编辑" style="cursor:pointer;"></span>
                            <span class="glyphicon glyphicon-trash" title="删除" style="cursor:pointer;"></span>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>

            <!--分页-->
            <?= $this->render('@app/views/layouts/page.php', ['pages' => $pages])?>
        </div>
        <!--添加日程-->
        <div id="add" class="tab-pane col-lg-10">
        <?= Html::beginForm(['/back/official/manage'], 'post')?>
            <div class="form-group">
                <?= Html::label('标题：', 'title')?>
                <?= Html::textInput('title', null, ['class' => 'form-control', 'id' => 'title'])?>
            </div>
            <div class="form-group">
                <?= Html::label('内容：', 'content')?>
                <?= Html::textarea('content', null, ['class' => 'form-control', 'id' => 'content'])?>
            </div>
            <?= Html::submitButton('提交', ['class' => 'btn btn-success radius'])?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default radius'])?>
        <?= Html::endForm()?>
        </div>
    </div>
</div>
<?php $this->beginBlock('js')?>
    //tab标签切换调用（默认显示第一个）
    $('#nav_tab li:eq(0) a').tab('show');
<?php $this->endBlock()?>
<?php $this->registerJs($this->blocks['js'], \yii\web\view::POS_END)?>