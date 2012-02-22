<?php /* Smarty version Smarty-3.1.7, created on 2012-02-03 14:35:40
         compiled from ".\templates\NetworkNodes_content_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:267774f2bd0e573bdb1-21463977%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2422f05b3f61536fa79f49a4306bf04e2d3bbed6' => 
    array (
      0 => '.\\templates\\NetworkNodes_content_add.tpl',
      1 => 1328272538,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '267774f2bd0e573bdb1-21463977',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2bd0e58c842',
  'variables' => 
  array (
    'combobox_boxtype_values' => 0,
    'combobox_boxtype_selected' => 0,
    'combobox_boxtype_text' => 0,
    'invNum' => 0,
    'combobox_box_values' => 0,
    'combobox_box_selected' => 0,
    'combobox_box_text' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2bd0e58c842')) {function content_4f2bd0e58c842($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
?><form id="NetworkNode" name="NetworkNode" action="NetworkNodes.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table>
		<!--tr>
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
		</tr-->
		<tr>
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
			<br />
		</tr>
	</table>
</div>
</form>
<?php }} ?>