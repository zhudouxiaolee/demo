<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/7/11
 * Time: 11:16
 * Description:错误界面
 */
use yii\helpers\Html;

/* @var $this \yii\web\view */
$this->title = $title;
?>
<div class="laouts-error">
    <div class="alert alert-danger">
        <?= Html::encode($msg)?>
    </div>
</div>
