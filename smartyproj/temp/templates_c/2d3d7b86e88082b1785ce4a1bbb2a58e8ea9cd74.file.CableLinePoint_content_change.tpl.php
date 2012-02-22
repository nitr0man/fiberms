<?php /* Smarty version Smarty-3.1.7, created on 2012-02-11 18:54:47
         compiled from ".\templates\CableLinePoint_content_change.tpl" */ ?>
<?php /*%%SmartyHeaderCode:126034f369d57e4ffe5-33416108%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d3d7b86e88082b1785ce4a1bbb2a58e8ea9cd74' => 
    array (
      0 => '.\\templates\\CableLinePoint_content_change.tpl',
      1 => 1328802999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126034f369d57e4ffe5-33416108',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
    'OpenGIS' => 0,
    'combobox_cableline_values' => 0,
    'combobox_cableline_selected' => 0,
    'combobox_cableline_text' => 0,
    'meterSign' => 0,
    'combobox_networknode_values' => 0,
    'combobox_networknode_selected' => 0,
    'combobox_networknode_text' => 0,
    'note' => 0,
    'Apartment' => 0,
    'Building' => 0,
    'SettlementGeoSpatial' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f369d57f0e94',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f369d57f0e94')) {function content_4f369d57f0e94($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
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
		<td><label class="events_anonce">CableLine</label></td><td> <select name="cablelines">
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
		<td><label class="events_anonce">note</label></td><td> <textarea name="note"><?php echo $_smarty_tpl->tpl_vars['note']->value;?>
</textarea></td>
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
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</div>
</form><?php }} ?>