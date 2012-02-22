<?php /* Smarty version Smarty-3.1.7, created on 2012-02-12 18:31:11
         compiled from ".\templates\FSOT_content_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:71154f37e9142ef278-50121354%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0da7728a2549958a611af23ff99d0632e7600db5' => 
    array (
      0 => '.\\templates\\FSOT_content_add.tpl',
      1 => 1329064268,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '71154f37e9142ef278-50121354',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f37e91438f70',
  'variables' => 
  array (
    'marking' => 0,
    'manufacturer' => 0,
    'note' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f37e91438f70')) {function content_4f37e91438f70($_smarty_tpl) {?><form name="cablelineinfo" action="FSOT.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table>
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
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
			<br />
		</tr>
</div>
</form><?php }} ?>