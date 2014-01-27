<?php /* Smarty version 2.6.22, created on 2013-07-16 10:08:11
         compiled from admin/column/content4_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'admin/column/content4_list.tpl', 143, false),array('modifier', 'date_format', 'admin/column/content4_list.tpl', 149, false),)), $this); ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LD-List</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo @URL; ?>
/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="<?php echo @URL; ?>
/scripts/formValidator/jquery_last.js"></script>
<script src="<?php echo @URL; ?>
/scripts/admin.js"></script>
<script src="<?php echo @URL; ?>
/scripts/showDiv.js" type="text/javascript" language="javascript"></script>
</head>
<?php echo '
<style>
div#qTip {
 padding: 3px;
 border: 1px solid #8394a5;
 border-right-width: 2px;
 border-bottom-width: 2px;
 display: none;
 background: #f0f4f8;
 color: #8394a5;
 font: 12px Verdana, Arial, Helvetica, sans-serif;
 line-height:22px;
 text-align: left;
 position: absolute;
 z-index: 1000;
}
</style>
<script>
var okimg = \'/admin/images/star_ok.gif\';
var noimg = \'/admin/images/star_no.gif\';
var cid = \''; ?>
<?php echo $this->_tpl_vars['cid']; ?>
<?php echo '\';
var mid = \'1\';
//var url = \'/admin.php?adminjob=content\';
var current_key;
var current_tid;
var current_num;
//var tagsname = \'装饰,别墅,\';
var digestMsg = new Array(4);
digestMsg[0] = \'您确认要取消此内容的精华推荐吗？\';
digestMsg[1] = \'您确认要将此内容设置为 栏目推荐 吗？\';
digestMsg[2] = \'您确认要将此内容设置为 站点推荐 吗？\';
digestMsg[3] = \'您确认要将此内容作为 头条内容 吗？\';
function showStar(key,i){
	for(var s=1;s<=3;s++){
		var imgid = \'img\'+key+\'_\'+s;
		if(s<=i){
		document.getElementById(imgid).src = okimg;
		}else{
		document.getElementById(imgid).src = noimg;
		}
	}
}

function reSet(key,num){
	for(var s=1;s<=3;s++){
		var imgid = \'img\'+key+\'_\'+s;
		if(s<=num){
			document.getElementById(imgid).src = okimg;
		}else{
			document.getElementById(imgid).src = noimg;
		}
	}
}

function digest(id,key,num){
	var msg = confirm(digestMsg[num]);
	if(msg){
		current_num = num;
		current_tid = id;
		current_key = key;
		$.get(
			 "'; ?>
<?php echo @URL; ?>
/admin/column/content.php<?php echo '",
			 { id: id, cid: cid, digest: num, action: \'ajaxDigest\'},
			 function(data){
			   //window.location="'; ?>
<?php echo @URL; ?>
/admin/column/content1.php?cid="+cid+"&mid"+mid+"<?php echo '";
			   reSet(key,num);
			   $(\'#digest_\'+key).mouseout( function() {reSet(key,num);} );
			 }
		); 
	}else{
		return false;
	}
}

function digestOk(res){
	if(res==\'100\'){
		var divname = \'d_\'+current_key;
		var divname2 = \'ss_\'+current_key;
		document.getElementById(divname).innerHTML = "<div id=\'"+divname2+"\' onmouseout=\\"reSet(\'"+current_key+"\',\'"+current_num+"\')\\"></div>";
		for(var i=1;i<=3;i++){
		if(i<=current_num){
			theimg = okimg;
		}else{
			theimg = noimg;
		}
		document.getElementById(divname2).innerHTML += "<img id=\'img"+current_key+"_"+i+"\' class=\'st\' src=\'"+theimg+"\' onmouseover=\\"showStar(\'"+current_key+"\',\'"+i+"\');\\" onclick=\\"digest(\'"+current_tid+"\',\'"+current_key+"\',\'"+i+"\');\\" />";
		}
	}
}
</script>
'; ?>


<base target="mainFrame">
<body>
<div class="t" style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
	<form name="frm_search2" method="GET" action="content.php" id="frm_search2">
		标题关键字搜索: <input type="text" name="title" value="<?php echo $this->_tpl_vars['title']; ?>
" id="title" />&nbsp;&nbsp;
		<input type="hidden" value="<?php echo $this->_tpl_vars['cid']; ?>
" name="cid"  />
		<input type="hidden" value="<?php echo $this->_tpl_vars['mid']; ?>
" name="mid"  />
	    <input type="submit" name="Submit" value="显示" class="btn" />
	</form>
	<input type="button" value="添加新内容" class="btn" onclick="self.location='content.php?action=add&cid=<?php echo $this->_tpl_vars['cid']; ?>
&mid=<?php echo $this->_tpl_vars['mid']; ?>
'" />
	<input type="button" name="Submit5" value="设置本栏目" class="btn" onclick="window.location='/admin/category.php?action=edit&cid=<?php echo $this->_tpl_vars['cid']; ?>
&mid=<?php echo $this->_tpl_vars['mid']; ?>
';"/>
	</td>
  </tr>
</table>
</div>

<form name="form1" id="form1" method="post" action="/admin/column/content.php?action=option&cid=<?php echo $this->_tpl_vars['cid']; ?>
&mid=<?php echo $this->_tpl_vars['mid']; ?>
">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="14">
	<div style="float:right">&nbsp;</div>
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;<?php echo $this->_tpl_vars['className']; ?>
</td>
   </tr>
<tr class="tr2">
    <td><span id="ordertid" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=tid&orderby=ASC&'">序号</span></td>
    <td><span id="ordertitle" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=title&orderby=ASC&'">标题</span></td>
    <td><span id="orderpublisher" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=publisher&orderby=ASC&'">发布者</span></td>
    <td><span id="orderhits" class="st">Order</span></td>
    <td>审核</td>
	<td><span id="orderpostdate" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=postdate&orderby=ASC&'">添加时间<img src="/admin/images/order_DESC.gif" /></span></td>
    <td>操作</td>
  </tr>

<?php unset($this->_sections['s']);
$this->_sections['s']['name'] = 's';
$this->_sections['s']['loop'] = is_array($_loop=$this->_tpl_vars['contentindexList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s']['show'] = true;
$this->_sections['s']['max'] = $this->_sections['s']['loop'];
$this->_sections['s']['step'] = 1;
$this->_sections['s']['start'] = $this->_sections['s']['step'] > 0 ? 0 : $this->_sections['s']['loop']-1;
if ($this->_sections['s']['show']) {
    $this->_sections['s']['total'] = $this->_sections['s']['loop'];
    if ($this->_sections['s']['total'] == 0)
        $this->_sections['s']['show'] = false;
} else
    $this->_sections['s']['total'] = 0;
if ($this->_sections['s']['show']):

            for ($this->_sections['s']['index'] = $this->_sections['s']['start'], $this->_sections['s']['iteration'] = 1;
                 $this->_sections['s']['iteration'] <= $this->_sections['s']['total'];
                 $this->_sections['s']['index'] += $this->_sections['s']['step'], $this->_sections['s']['iteration']++):
$this->_sections['s']['rownum'] = $this->_sections['s']['iteration'];
$this->_sections['s']['index_prev'] = $this->_sections['s']['index'] - $this->_sections['s']['step'];
$this->_sections['s']['index_next'] = $this->_sections['s']['index'] + $this->_sections['s']['step'];
$this->_sections['s']['first']      = ($this->_sections['s']['iteration'] == 1);
$this->_sections['s']['last']       = ($this->_sections['s']['iteration'] == $this->_sections['s']['total']);
?>
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['id']; ?>
" value="<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['id']; ?>
">
      <?php echo ((is_array($_tmp=@$this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['id'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
    <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['title'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>

	<?php if ($this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['photo'] != ''): ?><a href="javascript:void(0);" img="<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['photo']; ?>
"><img src="/admin/images/img.gif" /></a><?php endif; ?></td>
  <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['publisher'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
  <td><input name="taxis[<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['id']; ?>
]" type="text" class="input" id="taxis[<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['id']; ?>
]" value="<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['comnum']; ?>
" size="3" maxlength="3"></td>
  <td><?php if ($this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['ifpub'] == 1): ?>已审核<?php else: ?><font color="#FF0000">未审核</font><?php endif; ?></td>
  <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['postdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")))) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
  <td>
<a href="content.php?action=edit&id=<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['id']; ?>
&cid=<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['cid']; ?>
&mid=<?php echo $this->_tpl_vars['mid']; ?>
"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
<a href="content.php?action=delete&id=<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['id']; ?>
&cid=<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['cid']; ?>
&mid=<?php echo $this->_tpl_vars['mid']; ?>
" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a>
<a href="/admin/column/content.php?action=pubcancel&id=<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['id']; ?>
&cid=<?php echo $this->_tpl_vars['cid']; ?>
&mid=<?php echo $this->_tpl_vars['mid']; ?>
"><img src="/admin/images/cancel.gif" align="absmiddle" alt="取消发布" /></a>
<a href="/admin/column/content.php?action=pubview&id=<?php echo $this->_tpl_vars['contentindexList'][$this->_sections['s']['index']]['id']; ?>
&cid=<?php echo $this->_tpl_vars['cid']; ?>
&mid=<?php echo $this->_tpl_vars['mid']; ?>
"><img src="/admin/images/pub.gif" align="absmiddle" alt="发布内容" /></td>
  </tr>
<?php endfor; endif; ?>
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>
    操作:
      <select name="job" id="action">
      <option value="pubview" selected="selected">审核内容</option>
	  <option value="order">更新排序</option>
	  <option value="delete">删除内容</option>
	  <option value="destroy">永久删除</option>
      <option value="pubcancel">取消审核</option>
    </select>
    <input type="button" name="Submit3" value="全选" class="btn" onclick="CheckAll(document.form1);" />
    <input type="submit" name="Submit4" value="提交" class="btn" />
    <!--
	<input type="button" name="Submit3" value="全选" class="btn" onclick="CheckAll(document.form1);" />
	<input type="submit" name="btn_del" value="全部删除" class="btn" onclick='return window.confirm("您确认要删除!");'>
	-->
	</td>
    <td style="text-align:right"><?php echo ((is_array($_tmp=@$this->_tpl_vars['splitPageStr'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
  </tr>
</table>
</div>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../tpl/admin/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
<?php echo '
<script>
var top=parent.topFrame;
if(typeof(top)==\'object\'){
	var loadMsg=top.document.getElementById(\'loadMsg\');
	if(loadMsg!=undefined){
		loadMsg.style.display=\'none\';
	}
}
</script>
'; ?>
