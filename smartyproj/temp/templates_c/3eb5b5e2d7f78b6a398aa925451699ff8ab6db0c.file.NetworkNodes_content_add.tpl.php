<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 18:35:36
         compiled from "./templates/NetworkNodes_content_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14179259624f2a838234a393-01242726%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3eb5b5e2d7f78b6a398aa925451699ff8ab6db0c' => 
    array (
      0 => './templates/NetworkNodes_content_add.tpl',
      1 => 1329731382,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14179259624f2a838234a393-01242726',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a83823c2ac',
  'variables' => 
  array (
    'combobox_box_values' => 0,
    'combobox_box_selected' => 0,
    'combobox_box_text' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a83823c2ac')) {function content_4f2a83823c2ac($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/neverloved/fiberms/smartyproj/libs/plugins/function.html_options.php';
?><form id="NetworkNode" name="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table id="contable">
		<tr>
			<td><label>Имя</label></td><td><input name="name" type="text" value=""/></td>
		</tr>
		<tr>
			<td><label>Ящик:</label></td><td><select name="boxes">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_box_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_box_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_box_text']->value),$_smarty_tpl);?>

			</select>
			</td>
		</tr>
		<tr>
			<td><label>Примечание:</label></td><td><textarea name="note" form="NetworkNode"></textarea></td>
		</tr>
		<tr>
			<td><label>OpenGIS:</label></td><td><input name="OpenGIS" type="text" value="" /></td>
		</tr>
		<tr>
			<td><label>GeoSpartical:</label></td><td> <input name="SettlementGeoSpatial" type="text" value="" /></td>
		</tr>
		<tr>
			<td><label>Дом</label></td><td><input name="Building" type="text" value="" /></td>
		</tr>
		<tr>
			<td><label>Квартира:</label></td><td><input name="Apartment" type="text" value="" /></td>
		</tr>		
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
		</tr>
	</table>
</div>
</form>
<?php }} ?>