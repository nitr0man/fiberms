<?php /* Smarty version Smarty-3.1.7, created on 2012-02-01 16:39:37
         compiled from ".\templates\NetworkBox_content_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19954f294c08afe5b3-58914139%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '742d1c2d7b673388aa0985ad0558a4b1b1eec993' => 
    array (
      0 => '.\\templates\\NetworkBox_content_add.tpl',
      1 => 1328106904,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19954f294c08afe5b3-58914139',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f294c08bcc2e',
  'variables' => 
  array (
    'combobox_boxtype_values' => 0,
    'combobox_boxtype_selected' => 0,
    'combobox_boxtype_text' => 0,
    'invNum' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f294c08bcc2e')) {function content_4f294c08bcc2e($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
?><form name="boxinfo" action="NetworkBox.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table>
		<tr>
			<td>
			<label class="events_anonce">Type:</label></td><td> <select name="networkboxtypes" onChange="javascript: GetTypeBoxInfo(document.boxtypevalue.networkboxtypes.value,1);">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_boxtype_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_boxtype_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_boxtype_text']->value),$_smarty_tpl);?>

			</select>
			</td>
			<br />
		</tr>
		<tr>
			<td>
			<label class="events_anonce">InvNum:</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['invNum']->value;?>
" name="invnum" />
			</td>
			<br />
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
			<br />
		</tr>
</div>
</form><?php }} ?>