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

<div class="page-container text-center">
    <?= LinkPager::widget([
        'pagination' => $pages,
        'maxButtonCount' => 5,
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
        //'prevPageLabel' => true,
        //'nextPageLabel' => true,
        'options' => [
            'class' => 'pagination',
            'prevPageCssClass' => 'previous',
            'nextPageCssClass' => 'next',
        ]
    ])?>
</div>