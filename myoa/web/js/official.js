/**
 * Created by Sunyuheng on 2017/7/12.
 */

/*判断提交内容是否为空(标题与内容)*/
function is_empty_form() {
    var title = $('#title').val();
    var content = $('#content').val();
    if(title && content){
        return true;
    }else {
        layer.msg('标题或内容不能为空',{anim:6});
        return false;
    }
}
/*修改日报内容*/
function alter_daily(obj) {
    //要修改内容的ID
    var id = $(obj).data('id');
    //td中的内容
    var content = $(obj).text();
    //模态框
    var modal_alter_daily = $('#alter-daily-modal');
    //模态框中的textarea元素
    modal_alter_daily.find('textarea').val(content);
    //对于属性值或者自定义data属性值需要配套使用(此处要是用attr去设置属性，则alter_daily_submit方法中的获取属性方法需要使用attr获取)
    //给该textarea赋值
    modal_alter_daily.find('textarea').attr('data-oldv', content);
    modal_alter_daily.find('textarea').attr('data-id', id);
    //modal_alter_daily.find('textarea').data('oldv', content);
    //modal_alter_daily.find('textarea').data('id', id);
    //显示模态框
    modal_alter_daily.modal('show');
}
/*提交修改日程*/
function alter_daily_submit(obj) {
    //模态框
    var modal_alter_daily = $('#alter-daily-modal');
    //内容区域
    var textarea = $(obj).parent().prev().find('textarea');
    //对应记录的ID
    var id = textarea.attr('data-id');
    //td中的内容
    var content = $('td[data-id][data-id="'+id+'"]');
    //修改后的日程内容
    var v = textarea.val();
    //修改前的日程内容
    var oldv = textarea.attr('data-oldv');
    //var oldv = textarea.data('oldv');
    //判断是否修改了日程内容
    if(v == oldv) {
        //layer.alert('未修改', {skin:'layui-layer-molv', anim:4});
        layer.msg('未修改',{anim:1});
        return false;
    }else {
        $.ajax({
            url:ALTERDAILYURL,
            type:'post',
            data:{id:id,content:v},
            success:function (msg) {
                //将该td中的内容替换为新的值
                content.text(v);
                layer.msg(msg.msg, {anim:6});
                //隐藏模态框
                modal_alter_daily.modal('hide');
            }
        })
    }
}
/*删除单条日程记录*/
function delete_daily_official(obj) {
    var id = $(obj).attr('data-id');
    layer.confirm('确认删除？', {icon:3,title:'小提示',skin:'layui-layer-molv'}, function(i) {
        var mark = $('#mark-count');
        var count = mark.text();
        var newCount = parseInt(count) - 1;
        mark.text(newCount);
        $(obj).parent().parent().remove();
        // $.ajax({
        //     url:DELETEDAILYURL,
        //     type:'post',
        //     data:{id:id},
        //     success:function (msg) {
        //         layer.msg(msg.msg);
        //     }
        // });

        layer.close(i);
    });
}