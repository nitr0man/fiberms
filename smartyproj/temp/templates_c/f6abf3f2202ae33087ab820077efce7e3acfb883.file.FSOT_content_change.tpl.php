<?php /* Smarty version Smarty-3.1.7, created on 2012-02-12 18:32:31
         compiled from ".\templates\FSOT_content_change.tpl" */ ?>
<?php /*%%SmartyHeaderCode:251364f37e99f42fa58-23169649%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f6abf3f2202ae33087ab820077efce7e3acfb883' => 
    array (
      0 => '.\\templates\\FSOT_content_change.tpl',
      1 => 1329064265,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '251364f37e99f42fa58-23169649',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
    'marking' => 0,
    'manufacturer' => 0,
    'note' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f37e99f49679',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f37e99f49679')) {function content_4f37e99f49679($_smarty_tpl) {?><form name="cablelineinfo" action="FSOT.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
		<td> <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="id"></td>
		<br />
		</tr>		
		<tr>
		<td><label class="events_anonce">marking</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['marking']->value;?>
" name="marking"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">manufacturer</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['manufacturer']->value;?>
" name="manufacturer"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">note</label></td><td> <textarea name="note"><?php echo $_smarty_tpl->tpl_vars['note']->value;?>
</textarea></td>
		</tr>
		<tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</div>
</form><?php }} ?>