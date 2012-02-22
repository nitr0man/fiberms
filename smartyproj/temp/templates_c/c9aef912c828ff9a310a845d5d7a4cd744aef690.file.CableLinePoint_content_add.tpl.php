<?php /* Smarty version Smarty-3.1.7, created on 2012-02-11 18:48:10
         compiled from ".\templates\CableLinePoint_content_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20594f36992a563d55-50699914%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9aef912c828ff9a310a845d5d7a4cd744aef690' => 
    array (
      0 => '.\\templates\\CableLinePoint_content_add.tpl',
      1 => 1328978836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20594f36992a563d55-50699914',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f36992a5a31e',
  'variables' => 
  array (
    'OpenGIS' => 0,
    'combobox_cableline_values' => 0,
    'combobox_cableline_selected' => 0,
    'combobox_cableline_text' => 0,
    'meterSign' => 0,
    'combobox_networknode_values' => 0,
    'combobox_networknode_selected' => 0,
    'combobox_networknode_text' => 0,
    'Apartment' => 0,
    'Building' => 0,
    'SettlementGeoSpatial' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f36992a5a31e')) {function content_4f36992a5a31e($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
?><form name="cablelineinfo" action="CableLinePoint.php" method="post">
<input type="hidden" value="2" name="mode" />
	<table>
		<tr>
		<td><label class="events_anonce">OpenGIS</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['OpenGIS']->value;?>
" name="OpenGIS"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">CableLine</label></td><td> <select name="cabletypes">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_cableline_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_cableline_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_cableline_text']->value),$_smarty_tpl);?>

			</select></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">meterSign</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['meterSign']->value;?>
" name="meterSign"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">NetworkNode</label></td><td> <select name="networknodes">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_networknode_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_networknode_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_networknode_text']->value),$_smarty_tpl);?>

			</select></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">note</label></td><td> <textarea name="note"></textarea></td></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Apartment</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['Apartment']->value;?>
" name="Apartment"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Building</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['Building']->value;?>
" name="Building"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">SettlementGeoSpatial</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['SettlementGeoSpatial']->value;?>
" name="SettlementGeoSpatial"></td>
		<br />
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
			<br />
		</tr>
</form><?php }} ?>