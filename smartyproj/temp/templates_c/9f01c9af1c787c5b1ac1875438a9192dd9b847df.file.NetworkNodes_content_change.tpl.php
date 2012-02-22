<?php /* Smarty version Smarty-3.1.7, created on 2012-02-03 14:27:59
         compiled from ".\templates\NetworkNodes_content_change.tpl" */ ?>
<?php /*%%SmartyHeaderCode:309784f2acd90a73233-90099728%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f01c9af1c787c5b1ac1875438a9192dd9b847df' => 
    array (
      0 => '.\\templates\\NetworkNodes_content_change.tpl',
      1 => 1328271813,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '309784f2acd90a73233-90099728',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2acd90b2ac4',
  'variables' => 
  array (
    'id' => 0,
    'name' => 0,
    'combobox_box_values' => 0,
    'combobox_box_selected' => 0,
    'combobox_box_text' => 0,
    'note' => 0,
    'OpenGIS' => 0,
    'SettlementGeoSpatial' => 0,
    'Building' => 0,
    'Apartment' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2acd90b2ac4')) {function content_4f2acd90b2ac4($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
?><form name="NetworkNode" id="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
			<td><label></label>Идентификатор:</td><td><input name="id" type="text" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"/></td>
		</tr>
		<tr>
			<td><label>Имя</label></td><td><input name="name" type="text" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"/></td>
		</tr>
		<tr>
			<td><label>Ящик:</label></td><td> <select name="boxes">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_box_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_box_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_box_text']->value),$_smarty_tpl);?>

			</select>
			</td>
		</tr>
		<tr>
			<td><label>Примечание:</label></td><td><textarea name="note" form="NetworkNode"><?php echo $_smarty_tpl->tpl_vars['note']->value;?>
</textarea></td>
		</tr>
		<tr>
			<td><label>OpenGIS:</label></td><td><input name="OpenGIS" type="text" value="<?php echo $_smarty_tpl->tpl_vars['OpenGIS']->value;?>
" /></td>
		</tr>
		<tr>
			<td><label>GeoSpartical:</label></td><td><input name="SettlementGeoSpatial" type="text" value="<?php echo $_smarty_tpl->tpl_vars['SettlementGeoSpatial']->value;?>
" /></td>
		</tr>
		<tr>
			<td><label>Дом</label></td><td><input name="Building" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Building']->value;?>
" /></td>
		</tr>
		<tr>
			<td><label>Квартира:</label></td><td><input name="Apartment" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Apartment']->value;?>
" /></td>
		</tr>
		<tr>
			<td>
			<input value="Изменить" type="submit" name="ChangeButton" /><br />
			</td>
		</tr>	</table>
</form>
<?php }} ?>