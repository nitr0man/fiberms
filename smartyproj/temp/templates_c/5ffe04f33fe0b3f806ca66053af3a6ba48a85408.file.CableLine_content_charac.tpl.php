<?php /* Smarty version Smarty-3.1.7, created on 2012-02-12 11:15:29
         compiled from ".\templates\CableLine_content_charac.tpl" */ ?>
<?php /*%%SmartyHeaderCode:145334f3690751a5f77-00061227%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ffe04f33fe0b3f806ca66053af3a6ba48a85408' => 
    array (
      0 => '.\\templates\\CableLine_content_charac.tpl',
      1 => 1329038128,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145334f3690751a5f77-00061227',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f369075336c4',
  'variables' => 
  array (
    'id' => 0,
    'OpenGIS' => 0,
    'combobox_cabletype_values' => 0,
    'combobox_cabletype_selected' => 0,
    'combobox_cabletype_text' => 0,
    'length' => 0,
    'comment' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f369075336c4')) {function content_4f369075336c4($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
if (!is_callable('smarty_function_html_table')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_table.php';
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
		<td><label class="events_anonce">OpenGIS</label></td><td> <label><?php echo $_smarty_tpl->tpl_vars['OpenGIS']->value;?>
</label></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">CableType</label></td><td> <select name="cabletypes" readonly>
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_cabletype_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_cabletype_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_cabletype_text']->value),$_smarty_tpl);?>

			</select></td>
		<br />
		</tr>
		<td><label class="events_anonce">length</label></td><td> <label><?php echo $_smarty_tpl->tpl_vars['length']->value;?>
</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">comment</label></td><td> <textarea name="comment"><?php echo $_smarty_tpl->tpl_vars['comment']->value;?>
</textarea></td>
		</tr>
		<!--tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr-->
	</table>

	<table>
		<tr>
			<td>
			<?php echo smarty_function_html_table(array('loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"ID,OpenGIS,CableLine,meterSign,NetworkNode,note,Apartment,Building,SettlementGeoSpatial,Change,Delete"),$_smarty_tpl);?>

			</td>			
		<br />
		</tr>
		<tr>
		<td>
			<a href="CableLinePoint.php?mode=add">Добавить точку</a>
		</td>
		<br />
		</tr>
	</table>

</div>
</form><?php }} ?>