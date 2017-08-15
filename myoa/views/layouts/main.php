<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'OA办公系统',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-inverse navbar-fixed-top',
            'id' => 'main_navbar'
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '主页', 'url' => ['/back/index/index']],
            //同上url(模块访问)
            //['label' => '主页', 'url' => ['index/index']],
            //['label' => '日报管理', 'url' => ['/site/about']],
            Yii::$app->user->isGuest ? (
                ['label' => '登录', 'url' => ['manage/login']]
            ) : (
                '<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">功能菜单
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-left">
                        <li><a href="'. Url::to(['official/index']).'">日程管理</a></li>
                        <li><a href="'.Url::to(['notes/index']).'">笔记管理</a></li>
                        <li><a onclick="add_cate(\''.Url::to(['notes/cate-add']).'\')" href="javascript:void(0)">添加分类</a></li>
                        <li><a onclick="alter_passwd(\''.Url::to(['manage/user-info']).'\')" href="javascript:void(0)">修改密码</a></li>
                    </ul>
                 </li>'.
                '<li>'
                . Html::beginForm(['/back/manage/logout'], 'post')
                . Html::submitButton(
                    '退出 (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'itemTemplate' => '<li>{link}</li>',
            'homeLink' => [
                'label' => '主页',
                'url' => Yii::$app->homeUrl,
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
        ]) ?>

        <?= $content ?>
    </div>
    <a class="back-to-top btn btn-default" title="返回顶部" style="position: fixed;bottom: 15%;right: 2%;padding: 3px 8px;font-size: 24px;color: #666;display: none;" href="javascript:void(0)">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </a>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; OA办公系统 <?= date('Y') ?></p>
        <p class="pull-right"><a id="clock" href="javascript:void(0)"></a><?php //echo Yii::powered(); ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
