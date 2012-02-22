<?php /* Smarty version Smarty-3.1.7, created on 2012-02-02 13:50:32
         compiled from "./templates/NetworkNodes_content_change.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9546994014f2a6c4951d0c5-91577693%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac00fbcba7c896305dc740d209f978710c33b797' => 
    array (
      0 => './templates/NetworkNodes_content_change.tpl',
      1 => 1328183427,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9546994014f2a6c4951d0c5-91577693',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a6c4959715',
  'variables' => 
  array (
    'combobox_netnode_values' => 0,
    'combobox_netnode_selected' => 0,
    'combobox_netnode_name' => 0,
    'id' => 0,
    'name' => 0,
    'NetworkBox' => 0,
    'note' => 0,
    'OpenGIS' => 0,
    'SettlementGeoSpatial' => 0,
    'Building' => 0,
    'Apartment' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a6c4959715')) {function content_4f2a6c4959715($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/neverloved/fiberms/smartyproj/libs/plugins/function.html_options.php';
?><form name="NetworkNode" id="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
		<select name="nodeid">
		<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_netnode_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_netnode_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_netnode_name']->value),$_smarty_tpl);?>

		</select>

			<!--td><label></label>Идентификатор:</td><td><?php echo $_smarty_tpl->tpl_vars['id']->value;?>
</td-->
		</tr>
		<!--tr>
			<td><label class="events_anonce"><input type="radio" name="group1" id="rb1" checked="checked" onClick="javascript: GetNodeInfo(0,1); document.NetworkNode.addchangebutton.value = 'Изменить';"> Изменить</label><br />   
			<label class="events_anonce"><input type="radio" name="group1" id="rb2" onClick="javascript: document.NetworkNode.addchangebutton.value = 'Добавить';"> Добавить новый тип</label></td>
		</tr-->
		<tr>
			<td><label>Имя</label></td><td><input name="name" type="text" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"/></td>
		</tr>
		<tr>
			<td><label>Тип ящика:</label></td><td><input name="NetworkBox" type="text" value="<?php echo $_smarty_tpl->tpl_vars['NetworkBox']->value;?>
" /></td>
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
			<td><label>GeoSpartical:</label></td><td> <input name="SettlementGeoSpatial" type="text" value="<?php echo $_smarty_tpl->tpl_vars['SettlementGeoSpatial']->value;?>
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
			<input value="Изменить" type="submit" name="ChangeButton" /><br /><!--td><input type="submit" -->
			</tr>	</table>
</form>
<?php }} ?>