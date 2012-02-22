<?php /* Smarty version Smarty-3.1.7, created on 2012-02-02 11:38:30
         compiled from "./templates/NetworkBox_content_change.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1391810904f2a5996b3f483-26951271%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebcf472aa6caf4a0d0fbbbd9d106fd9ed472428b' => 
    array (
      0 => './templates/NetworkBox_content_change.tpl',
      1 => 1328172198,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1391810904f2a5996b3f483-26951271',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
    'combobox_boxtype_values' => 0,
    'combobox_boxtype_selected' => 0,
    'combobox_boxtype_text' => 0,
    'invNum' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a5996b9cac',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a5996b9cac')) {function content_4f2a5996b9cac($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/neverloved/fiberms/smartyproj/libs/plugins/function.html_options.php';
?><form name="boxinfo" action="NetworkBox.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
			<td>
			<label class="events_anonce">ID:</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="boxid" readonly>
			</td>
			<br />
		</tr>
		<tr>
			<td>
			<label class="events_anonce">Type:</label></td><td> <select name="networkboxtypes">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_boxtype_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_boxtype_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_boxtype_text']->value),$_smarty_tpl);?>

			</select>
			</td>
			<br />
		</tr>
		<tr>
			<td>
			<label class="events_anonce">InvNum:</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['invNum']->value;?>
" name="invnum">
			</td>
			<br />
		</tr>
		<tr>
			<td>
			<input value="Изменить" type="submit" name="ChangeButton" /><br />
			<!--<input value="Удалить" type="submit" name="DeleteButton" /> -->
			</td>
			<br />
		</tr>
</div>
</form><?php }} ?>