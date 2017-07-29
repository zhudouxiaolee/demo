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
        <p class="lead">开始我的办公日程.</p>
        <?= Html::a('Let\'s Go!', ['/back/official/index'], ['class' => 'btn btn-success', 'style' => 'font-weight:bold;'])?>
    </div>
</div>