<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/22
 * Time: 9:41
 * Description:登录视图
 */
/* @var $this \yii\web\view */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manage-login">
    <div class="col-lg-8 col-lg-offset-2">
        <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => Url::to(['/back/manage/login']),
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
                'validationUrl' => Url::to(['/back/manage/ajax']),
                'options' => [
                    'class' => 'form-horizontal',
                    ],
                'fieldConfig' => [
                    'labelOptions' => [
                        'class' => 'col-sm-2 control-label'
                    ],
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'template' => '{label}<div class="col-sm-6">{input}</div>{hint}{error}'
                ],
        ])?>
            <?= $form->field($loginForm, 'username')->textInput()->label('用户名')?>
            <?= $form->field($loginForm, 'password')->passwordInput()->label('密&nbsp;&nbsp;码')?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <?= Html::submitButton('登录', ['class' => 'btn btn-success radius'])?>
                <?= Html::resetButton('重置', ['class' => 'btn btn-default radius'])?>
            </div>
        </div>
        <?php ActiveForm::end()?>
    </div>
</div>