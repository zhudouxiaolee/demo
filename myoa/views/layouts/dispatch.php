<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/8/15
 * Time: 11:44
 * Description:调度提示界面
 */
/* @var $this \yii\web\view */
$this->title = '提示信息';
?>
<div class="layouts-dispatch">
    <div class="col-lg-12">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="alert alert-danger text-center second"></div>
        </div>
    </div>
</div>
<!--判断是成功操作还是失败操作：status:1,success;2,error-->
<?php $this->beginBlock('script')?>
    function count_down(s) {
        var str = '<?= $msg?>,'+s+'秒之后跳转';
        $('.second').text(str);
        s--;
        if(s) {
            var t = setTimeout('count_down('+s+')', 1000);
        }else {
            clearTimeout(t);
            <?php if($status):?>
                window.location.href = '<?= $url?>';
            <?php else:?>
                window.history.go(-1);
            <?php endif;?>
        }
    }
    count_down(<?= $seconds?>);
<?php $this->endBlock()?>
<?php $this->registerJs($this->blocks['script'], \yii\web\view::POS_END)?>