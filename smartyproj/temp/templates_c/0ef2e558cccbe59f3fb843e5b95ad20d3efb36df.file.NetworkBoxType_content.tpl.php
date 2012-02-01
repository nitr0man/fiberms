<?php /* Smarty version Smarty-3.1.7, created on 2012-01-31 12:15:53
         compiled from ".\templates\NetworkBoxType_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:229704f27bf43b9bb52-13655112%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ef2e558cccbe59f3fb843e5b95ad20d3efb36df' => 
    array (
      0 => '.\\templates\\NetworkBoxType_content.tpl',
      1 => 1328004933,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '229704f27bf43b9bb52-13655112',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f27bf43ddd55',
  'variables' => 
  array (
    'combobox_boxtype_values' => 0,
    'combobox_boxtype_selected' => 0,
    'combobox_boxtype_text' => 0,
    'count' => 0,
    'id' => 0,
    'marking' => 0,
    'manufacturer' => 0,
    'units' => 0,
    'width' => 0,
    'height' => 0,
    'length' => 0,
    'diameter' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f27bf43ddd55')) {function content_4f27bf43ddd55($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
?><form name="boxtypevalue" onsubmit="return false">
<div id="ololo">
	<table>
		<tr>
		<td><label class="events_anonce">Тип ящика</label></td><td id="newboxform">
		<select name="networkboxtypes" onChange="javascript: GetTypeBoxInfo(document.boxtypevalue.networkboxtypes.value,1);">
		<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_boxtype_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_boxtype_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_boxtype_text']->value),$_smarty_tpl);?>

		</select>
		
		</td>

<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Кол-во:</label></td><td id="inventorynumber"> <a href="#" class="events_anonce"><?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</a></td><!--<td><input type="text" name="invmun" size="30" /></td>-->
<br />
		</tr>
		<tr>
		<td><!--<label class="events_anonce">deprecated</label>--></td><td><input type="hidden" name="whichadded" value="networkbox" size="30" /></td>
		</tr>
		<tr>
		<td><label class="events_anonce"><input type="radio" name="group1" id="rb1" checked="checked" onClick="javascript: GetTypeBoxInfo(0,1); document.boxtype.addchangebutton.value = 'Изменить';"> Изменить</label><br />   
		<label class="events_anonce"><input type="radio" name="group1" id="rb2" onClick="javascript: ClearInput(); document.boxtype.addchangebutton.value = 'Добавить';"> Добавить новый тип</label></td>
		</tr>
	</table>
</div>
</form>

<form name="boxtype" onSubmit="return false">
<!--	<div id="addnewboxtype">-->
		<table>
		<tr>
		<td><label class="events_anonce">ID</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="id"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['marking']->value;?>
" name="marking"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['manufacturer']->value;?>
" name="manufacturer"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Units</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['units']->value;?>
" name="units"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Width</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['width']->value;?>
" name="width"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Height</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['height']->value;?>
" name="height"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Length</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['length']->value;?>
" name="length"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Diameter</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['diameter']->value;?>
" name="diameter"></td>
		</tr><td><input type="hidden" name="whichadded" id="whichadded" value="networkboxtype" /></td><td><input value="Изменить" type="submit" name="addchangebutton" onclick="javascript: AddNewOrChangeBoxType(2,document.getElementById('rb1').checked,document.boxtype.id.value,document.boxtype.marking.value,document.boxtype.manufacturer.value,document.boxtype.units.value,document.boxtype.width.value,document.boxtype.height.value,document.boxtype.length.value,document.boxtype.diameter.value)" /></td></form>
		</tr>
		</table>
<!--	</div>-->
</form><?php }} ?>