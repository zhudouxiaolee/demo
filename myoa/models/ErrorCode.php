<?php
/**
 * Created by PhpStorm.
 * User: Sun
 * Date: 2018/2/27
 * Time: 11:38
 * Description:
 */

namespace app\models;


use yii\base\Model;

class ErrorCode extends Model
{
    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;
}