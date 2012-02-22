<?php /* Smarty version Smarty-3.1.7, created on 2012-02-11 18:36:18
         compiled from ".\templates\CableLine_content_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:98494f2d1258d77315-70604524%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f38c3e5ad6802473f26f671135718e537cf96525' => 
    array (
      0 => '.\\templates\\CableLine_content_add.tpl',
      1 => 1328634591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '98494f2d1258d77315-70604524',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2d1258ea6fe',
  'variables' => 
  array (
    'OpenGIS' => 0,
    'combobox_cabletype_values' => 0,
    'combobox_cabletype_selected' => 0,
    'combobox_cabletype_text' => 0,
    'length' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2d1258ea6fe')) {function content_4f2d1258ea6fe($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
?><form name="cablelineinfo" action="CableLine.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table>
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
		<td><label class="events_anonce">comment</label></td><td> <textarea name="comment"></textarea></td>
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
			<br />
		</tr>
</div>
</form><?php }} ?>