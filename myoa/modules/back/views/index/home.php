<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/16
 * Time: 16:36
 * Description:
 */
use yii\helpers\Html;

/* @var $this \yii\web\view */
$this->title = '主页';
//$this->params['breadcrumbs'][] = null;
?>
<div class="index-index">
    <div class="jumbotron">
<!--        <h1>Welcome to OA systems!</h1>-->
        <p class="lead">开始我的办公日程.</p>
        <?= Html::a('Started to the office', ['/back/official/index'], ['class' => 'btn btn-success radius', 'style' => 'font-weight:bold;'])?>
    </div>
</div>