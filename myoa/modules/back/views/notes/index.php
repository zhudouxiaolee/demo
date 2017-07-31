<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/7/12
 * Time: 11:31
 * Description:笔记管理界面
 */
use app\assets\AppAsset;
use dosamigos\datepicker\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\view */
$this->title = '笔记管理';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::addJsFile($this, '@web/js/markdown.js');
AppAsset::addJsFile($this, '@web/js/notes.js');
?>
<div class="notes-index">
    <div class="col-lg-12">
        <div class="col-lg-2 list-group">
            <!--笔记管理标签切换-->
            <ul id="notes_tab" class="nav nav-pills nav-stacked">
                <li><a href="#notes_list" data-toggle="tab">笔记列表</a></li>
                <li><a href="#notes_add" data-toggle="tab">添加笔记</a></li>
                <li><a href="#cate_list" data-toggle="tab">分类管理</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div id="notes_list" class="tab-pane">
                <div class="notes_list_content col-lg-10">
                    <!--搜索域-->
                    <?= Html::beginForm(Url::to(['notes/index']), 'get', ['class' => 'form-inline', 'role' => 'form'])?>
                            <!--时间插件-->
                            <div class="form-group">
                                <?= DateRangePicker::widget([
                                    'name' => 'start_date',
                                    'value' => $search['start_date'],
                                    'options' => ['placeholder' => '开始时间'],
                                    'nameTo' => 'end_date',
                                    'valueTo' => $search['end_date'],
                                    'optionsTo' => ['placeholder' => '结束时间'],
                                    'labelTo' => '-',
                                    'language' => 'zh-CN',
                                    'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                            'todayHighlight' => true,
                                            'startDate' => '2017-06-01',
                                            'endDate' => '',
                                            'todayBtn' => 'linked',
                                            'clearBtn' => true,
                                    ]
                                ])?>
                            </div>
                            <div class="form-group">
                                <label for="notes_title">关键词：</label>
                                <?= Html::textInput('notes_title', $search['notes_title'], ['class' => 'form-control', 'id' => 'notes_title', 'placeholder' => '摘要中的关键词'])?>
                            </div>
                            <div class="form-group">
                                <label for="notes_category">分类：</label>
                                <?= Html::dropDownList('notes_category',$search['notes_category'], ArrayHelper::merge([-1 => '全部', 0 => '未分类'], $cateList), ['class' => 'form-control', 'id' => 'notes_category'])?>
                            </div>
                            <button type="submit" class="btn btn-success">搜索</button>
                    <?= Html::endForm()?>
                    <!--笔记列表内容-->
                    <?php foreach ($notesList as $k => $v):?>
                        <div class="notes_edit">
                            <nav class="navbar " style="padding-right: 10px;">
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="javascript:void(0)" onclick="notes_key_words(this)"  data-id="<?= $v['id']?>" title="关键词" class="glyphicon glyphicon-exclamation-sign"></a></li>
                                    <li><a href="javascript:void(0)" onclick="notest_cate_list(this)" data-id="<?= $v['id']?>" data-cate-id="<?= $v['cateid']?>" title="分类" class="glyphicon glyphicon-tags"></a></li>
                                    <li><a href="javascript:void(0)" onclick="notes_edit(this)" data-id="<?= $v['id']?>" title="编辑" class="glyphicon glyphicon-edit"></a></li>
                                    <li><a href="javascript:void(0)" onclick="notes_delete(this)" data-id="<?= $v['id']?>" title="删除" class="glyphicon glyphicon-trash"></a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="notes table" data-text="<?= $v['content']?>"></div>
                    <?php endforeach;?>
                    <!--分页-->
                    <?= $this->render('@app/views/layouts/page.php', ['pages' => $pages, 'count' => $count])?>
                </div>
            </div>
            <div id="notes_add" class="tab-pane">
                <div class="col-lg-5">
                    <div class="alert alert-success">
                        <a href="javascript:void(0)" class="close" data-dismiss="alert">&times;</a>
                        <em>本编辑器支持markdown语法解析!!!详情请点击<a href="http://www.appinn.com/markdown/" target="_blank">markdown语法</a></em>
                    </div>
                    <textarea id="mark_content" class="form-control" onkeyup="compile()" title="markdown" rows="20" style="resize: none"></textarea>
                    <div class="text-center" style="margin-top: 5px">
                        <button class="btn btn-success radius" type="button" onclick="notes_submit()">确认添加</button>
                        <button class="btn btn-default radius" type="button" onclick="notes_reset()">重置</button>
                    </div>
                </div>
                <div class="col-lg-5 layui-layer-border">
                    <div class="text-center"><h3><em>编译版块</em></h3></div>
                    <div id="mark_id"></div>
                </div>
            </div>
            <div id="cate_list" class="tab-pane">
                <div class="col-lg-4 col-lg-offset-1">
                    <?php
                    $item = [];
                    foreach ($cateResult as $k => $v) {
                        $item[] = [
                            'text' => $v['name'],
                            'href' => false,
                            'visible' => true,
                            'selectable' => true,
                            'cateid' => $v['id'],
                            'tags' => [$v['notestotal']]
//                            'nodes' => [
//                                    ['text' => '二级'.$v['name'], 'href' => false]
//                            ]
                        ];
                    }
                    ?>

                    <?= \yongtiger\bootstraptree\widgets\BootstrapTree::widget([
                        'options' => [
                            'data' => $item,
                            'multiSelect' => false,
                            'showTags' => true
                        ],
                        'htmlOptions' => [
                            'id' => 'treeview-tabs',
                        ],
                        'textTemplate' => '{text}',
                        'events' => [
                                'onNodeSelected' => 'function(event, data){
                                    cate_alter(data,event);
                                }'
                        ]
                    ])?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $this->beginBlock('script')?>
    //添加笔记路径
    var NOTES_ADD_URL = '<?= Url::to(['notes/notes-add'])?>';
    //修改笔记路径
    var NOTES_ALTER_URL = '<?= Url::to(['notes/notes-alter'])?>';
    //删除笔记路径
    var NOTES_DEL_URL = '<?= Url::to(['notes/notes-delete'])?>';
    //显示笔记分类路径
    var NOTES_CATE_LIST_URL = '<?= Url::to(['notes/notes-cate-list'])?>';
    //修改笔记所属分类路径
    var NOTES_CATE_ALTER_URL = '<?= Url::to(['notes/notes-cate-alter'])?>';
    //删除某条分类路径
    var CATE_DELETE_URL = '<?= Url::to(['notes/cate-delete'])?>';
    //修改某条分类的名称
    var CATE_NAME_ALTER = '<?= Url::to(['notes/cate-alter'])?>';
    //查看关键词的路径
    var NOTES_KEY_WORDS_URL = '<?= Url::to(['notes/notes-key-words'])?>';
    //标签切换
    $('#notes_tab li:eq(0) a').tab('show');

<?php $this->endBlock()?>
<?php $this->registerJs($this->blocks['script'], \yii\web\view::POS_END)?>
