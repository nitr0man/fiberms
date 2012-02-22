<?php /* Smarty version Smarty-3.1.7, created on 2012-02-12 12:10:49
         compiled from ".\templates\NetworkBox_content_charac.tpl" */ ?>
<?php /*%%SmartyHeaderCode:160454f379029f225b5-01202345%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebb328d3c6375b4a3211764534a1fd076f8ac8ef' => 
    array (
      0 => '.\\templates\\NetworkBox_content_charac.tpl',
      1 => 1329041318,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160454f379029f225b5-01202345',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'boxtype' => 0,
    'invNum' => 0,
    'nodename' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f379029f32b8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f379029f32b8')) {function content_4f379029f32b8($_smarty_tpl) {?><form name="boxinfo" action="NetworkBox.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>		
		<tr>
			<td>
			<label class="events_anonce">Type: </label></td><td><label><?php echo $_smarty_tpl->tpl_vars['boxtype']->value;?>
</label>
			</td>
			<br />
		</tr>
		<tr>
			<td>
			<label class="events_anonce">InvNum: </label></td><td> <label><?php echo $_smarty_tpl->tpl_vars['invNum']->value;?>
</label>
			</td>
			<br />
		</tr>
		<tr>
		<td>
			<label>Node name: </label>
		</td>
		<td>
			<label><?php echo $_smarty_tpl->tpl_vars['nodename']->value;?>
</label>
		</td>
		<br />
		</tr>
</div>
</form><?php }} ?>