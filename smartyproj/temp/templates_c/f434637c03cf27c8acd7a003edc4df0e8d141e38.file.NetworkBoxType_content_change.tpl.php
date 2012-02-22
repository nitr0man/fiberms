<?php /* Smarty version Smarty-3.1.7, created on 2012-02-04 11:39:11
         compiled from ".\templates\NetworkBoxType_content_change.tpl" */ ?>
<?php /*%%SmartyHeaderCode:130974f2cfc9cb66523-00067780%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f434637c03cf27c8acd7a003edc4df0e8d141e38' => 
    array (
      0 => '.\\templates\\NetworkBoxType_content_change.tpl',
      1 => 1328348349,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '130974f2cfc9cb66523-00067780',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2cfc9cc5ae3',
  'variables' => 
  array (
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
<?php if ($_valid && !is_callable('content_4f2cfc9cc5ae3')) {function content_4f2cfc9cc5ae3($_smarty_tpl) {?><form name="boxtypeinfo" action="NetworkBoxType.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
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
</div>
</form><?php }} ?>