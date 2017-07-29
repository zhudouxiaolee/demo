/*markdowm编译方法*/
var converter  = new showdown.Converter();
function compile() {
    var text = $('#mark_content').val();
    var html = converter.makeHtml(text);
    $('#mark_id').html(html);
}
/*提交笔记*/
function notes_submit() {
    var str = $('#mark_id').text();
    var text = $('#mark_content').val();
    if(!str) {
        layer.alert('请填写内容后再提交!', {icon:5});
        return false;
    }
    layer.prompt({title:'请务必加上摘要内容，以便将来进行筛选搜索',formType:2},function (summary,index) {
        $.ajax({
            url: NOTES_ADD_URL,
            type:'post',
            data:{title:summary,content:text},
            success:function (msg) {
                if(msg.status) {
                    layer.close(index);
                    window.location.href = msg.url;
                }else {
                    layer.msg(msg.msg, {anim: 6});
                }
            }
        });
    });
}
/*置空笔记内容*/
function notes_reset() {
    $('#mark_content').val('');
    $('#mark_id').text('');
}
/*修改某条笔记的分类*/
function notest_cate_list(obj) {
    //某条笔记的ID
    var id = $(obj).attr('data-id');
    //分类ID
    var cate_id = $(obj).attr('data-cate-id');
    $.ajax({
        url:NOTES_CATE_LIST_URL,
        type:'post',
        success:function (msg) {
            if(msg.data) {
                var str = '<select id="notes_category_alter" class="form-control" name="notes_category"><option value="0">未分类</option>';
                $.each(msg.data, function (index, item) {
                    if(item.id == cate_id) {
                        str += '<option value="'+item.id+'" selected>'+item.name+'</option>';
                    }else {
                        str += '<option value="'+item.id+'">'+item.name+'</option>';
                    }
                });
                str += '</select>';
                layer.open({
                    type:1,
                    title:'修改分类',
                    area:['220px', '100px'],
                    content:'<div class="col-lg-12 text-center form-inline">'+str+'<button type="button" class="btn btn-success" data-id="'+id+'" data-cate-id="'+cate_id+'" onclick="notes_cate_alter(this)">提交</button></div>'
                });
            }else {
                layer.msg('目前您还没有分类信息，最好去添加新的分类以便更好的管理笔记',{time:3000});
            }
        }
    });
}
/*编辑笔记内容*/
function notes_edit(obj) {
    var id = $(obj).attr('data-id');
    var text = $(obj).parents('.notes_edit').next().attr('data-text');
    //页面层
    layer.open({
        type: 1,
        skin: 'layui-layer-demo', //加上边框
        area: ['70%', '90%'], //宽高
        maxmin:true,//开启最大化
        content: '<div class="col-lg-12"><div class="col-lg-6 text-center"><textarea id="mark_content_alter" class="form-control" data-text="'+text+'" rows="23" style="resize: none;margin-bottom: 4px;" onkeyup="compile_alter()" title="markdown" >'+text+'</textarea><button type="button" onclick="notes_content_alter_submit('+id+')" class="btn btn-success">确认修改</button></div><div class="col-lg-6 layui-layer-border"><div class="text-center"><h3><em>编译版块</em></h3></div><div id="mark_id_alter"></div></div></div>'
    });
    //open后直接编译内容
    compile_alter();
}
/*编译修改的笔记*/
function compile_alter() {
    var text = $('#mark_content_alter').val();
    var html = converter.makeHtml(text);
    $('#mark_id_alter').html(html);
}
/*提交修改后的笔记*/
function notes_content_alter_submit(id) {
    var mark_content_alter = $('#mark_content_alter');
    var content_old = mark_content_alter.attr('data-text');
    var content_alter = mark_content_alter.val();
    if(content_old == content_alter) {
        layer.msg('未修改');
        return false;
    }
    $.ajax({
        url:NOTES_ALTER_URL,
        type:'post',
        data:{id:id,content:content_alter},
        success:function (msg) {
            if(msg.status) {
                layer.msg(msg.msg);
                window.location.reload();
            }else {
                layer.msg(msg.msg, {anim:6});
            }
        }
    });
}
/*删除笔记*/
function notes_delete(obj) {
    var id = $(obj).attr('data-id');
    layer.confirm('确认删除？', {icon:3,title:'小提示'}, function () {
        $.ajax({
            url:NOTES_DEL_URL,
            type:'post',
            data:{id:id},
            success:function(msg) {
                if(msg.status) {
                    layer.msg(msg.msg);
                    //置空该笔记内容的DOM结构
                    $(obj).parents('.notes_edit').next().remove();//内容置空
                    $(obj).parents('.notes_edit').remove();//操作栏置空
                }else {
                    layer.msg(msg.msg, {anim:6});
                }
            }
        });
    });
}
/*修改笔记的所属分类*/
function notes_cate_alter(obj) {
    //该条笔记ID
    var notes_id = $(obj).attr('data-id');
    //旧分类ID
    var cate_old_id = $(obj).attr('data-cate-id');
    //新分类ID
    var cate_new_id = $('#notes_category_alter').val();
    if(cate_new_id == cate_old_id) {
        layer.msg('未修改', {anim:6});
        return false;
    }else {
        $.ajax({
            url:NOTES_CATE_ALTER_URL,
            type:'post',
            data:{notesid:notes_id,cateid:cate_new_id},
            success:function (msg) {
                if(msg.status) {
                    layer.msg(msg.msg);
                }else {
                    layer.msg(msg.msg, {anim:6});
                    //window.location.reload();
                }
            }
        });
    }
}
/*分类管理*/
function cate_alter(data,event) {
    //分类ID
    var id = data.cateid;
    //分类名称
    var text = data.text;
    //需要清除DOM的nodeId
    //var node_id = data.nodeId;
    layer.confirm('该分类下共有'+data.tags[0]+'条笔记', {title:'小提示', icon: 0, btn:['删除', '修改', '取消']}, function () {
        layer.confirm('确定删除该条分类信息？', {title:'小提示',icon:3},function () {
            $.ajax({
                url:CATE_DELETE_URL,
                type:'post',
                data:{cateid:id},
                success:function (msg) {
                    if(msg.status) {
                        layer.msg(msg.msg+'！该分类下的笔记将归类到未分类信息中');
                        //$(event.currentTarget).find("li[data-nodeid="+node_id+"]").remove();
                        window.location.reload();
                    }else {
                        layer.msg(msg.msg, {anim:6});
                    }
                }
            });
        });
    }, function () {
        layer.open({
            type: 1,
            title:'修改分类名称',
            skin: 'layui-layer-demo', //样式类名
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            area:['220px', '130px'],
            shadeClose: false, //开启遮罩关闭
            content: '<div class="col-lg-12 text-center"><input class="form-control" type="text" name="cate" value="'+text+'" style="margin: 4px 0"><button onclick="cate_alter_name(this)" type="button" data-cate-id="'+id+'" data-cate-old="'+text+'" class="btn btn-success">提交</button></div>'
        });
    });
}
/*提交修改后的分类名称*/
function cate_alter_name(obj) {
    var cate_id = $(obj).attr('data-cate-id');
    var cate_name_old = $(obj).attr('data-cate-old');
    var cate_name_new = $(obj).prev().val();
    if(cate_name_old == cate_name_new) {
        layer.msg('未修改', {anim:6});
        return false;
    }
    $.ajax({
        url:CATE_NAME_ALTER,
        type:'post',
        data:{id:cate_id, name:cate_name_new},
        success:function (msg) {
            if(msg.status) {
                layer.msg(msg.msg);
                window.location.reload();
            }else {
                layer.msg(msg.msg, {anim:6});
            }
        }
    });
}
/*DOM加载完毕markdown编译笔记内容*/
$('.notes').each(function (index,item) {
    var text = $(item).attr('data-text');
    var html = converter.makeHtml(text);
    $(item).append(html);
});