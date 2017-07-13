<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/20
 * Time: 20:12
 * Description:
 */
use yii\widgets\LinkPager;
?>

<div class="page-container">
    <div class="col-md-4 text-success">
        <small class="text-muted">共<?= $count?>条记录</small>
    </div>
    <div class="col-md-8">
    <?= LinkPager::widget([
        'pagination' => $pages,
        'maxButtonCount' => 5,
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
        'prevPageLabel' => false,
        'nextPageLabel' => false,
//        'options' => [
//            'class' => 'pagination',
//            'prevPageCssClass' => 'previous',
//            'nextPageCssClass' => 'next',
//        ]
    ])?>
    </div>
</div>