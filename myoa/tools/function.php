<?php
/**
 * vp.
 * @access
 * @param $data
 * @return void
 * Created by User: SunYuHeng
 * Last Modify User: SunYuHeng
 * Date: 2017-06-16
 * Time: 15:54:27
 * Description:公共方法
 */

function vp($data)
{
    header('Content-type:text/html;charset=utf-8');
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit();
}

function pp($data)
{
    header('Content-type:text/html;charset=utf-8');
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    exit();
}