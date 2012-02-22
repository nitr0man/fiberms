<?php /* Smarty version Smarty-3.1.7, created on 2012-02-04 13:21:32
         compiled from ".\templates\CableLine_content_change.tpl" */ ?>
<?php /*%%SmartyHeaderCode:255284f2d146216c7a6-31997136%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ddee91af8cf901cea982b51adafbb463b611aef' => 
    array (
      0 => '.\\templates\\CableLine_content_change.tpl',
      1 => 1328354490,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '255284f2d146216c7a6-31997136',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2d14621efa2',
  'variables' => 
  array (
    'id' => 0,
    'OpenGIS' => 0,
    'combobox_cabletype_values' => 0,
    'combobox_cabletype_selected' => 0,
    'combobox_cabletype_text' => 0,
    'length' => 0,
    'comment' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2d14621efa2')) {function content_4f2d14621efa2($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
?><form name="cablelineinfo" action="CableLine.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
		<td> <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="id"></td>
		<br />
		</tr>		
		<tr>
		<td><label class="events_anonce">OpenGIS</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['OpenGIS']->value;?>
" name="OpenGIS"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">CableType</label></td><td> <select name="cabletypes">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_cabletype_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_cabletype_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_cabletype_text']->value),$_smarty_tpl);?>

			</select></td>
		<br />
		</tr>
		<td><label class="events_anonce">length</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['length']->value;?>
" name="length"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">comment</label></td><td> <textarea name="comment"><?php echo $_smarty_tpl->tpl_vars['comment']->value;?>
</textarea></td>
		</tr>
		<tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</div>
</form><?php }} ?>