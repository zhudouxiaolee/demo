<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/8/15
 * Time: 14:41
 * Description:信息提示界面布局
 */
use app\assets\MessageAsset;
use yii\helpers\Html;

/* @var $this \yii\web\view */

MessageAsset::register($this);
?>

<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>
<div class="wrap">
    <div class="container">
        <?= $content ?>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; OA办公系统 <?= date('Y') ?></p>
        <p class="pull-right"><a id="clock" href="javascript:void(0)"></a><?php //echo Yii::powered(); ?></p>
    </div>
</footer>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>