/**
 * Created by Sunyuheng on 2017/7/12.
 */
/*修改日报内容*/
function alter_daily(obj) {
    var id = $(obj).data('id');
    var content = $(obj).text();
    var modal_alter_daily = $('#alter-daily-modal');
    modal_alter_daily.find('textarea').val(content);
    // modal_alter_daily.find('textarea').attr('data-oldv', content);
    modal_alter_daily.find('textarea').data('oldv', content);
    modal_alter_daily.find('textarea').data('id', id);
    modal_alter_daily.modal({show:true});
}
/*提交修改日程*/
function alter_daily_submit(obj) {
    var textarea = $(obj).parent().prev().find('textarea');
    var v = textarea.val();
    // var oldv = textarea.attr('data-oldv');
    var oldv = textarea.data('oldv');
    // console.log(v);
    // console.log(oldv);
    if(v == oldv) {
        //layer.alert('未修改', {skin:'layui-layer-molv', anim:4});
        layer.msg('未修改');
        return false;
    }else {
        layer.msg('已修改');
    }

}