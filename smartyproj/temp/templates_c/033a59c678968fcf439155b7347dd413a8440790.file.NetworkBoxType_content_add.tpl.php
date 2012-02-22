<?php /* Smarty version Smarty-3.1.7, created on 2012-02-04 11:43:43
         compiled from ".\templates\NetworkBoxType_content_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:213514f2cfd31e82ce4-52173673%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '033a59c678968fcf439155b7347dd413a8440790' => 
    array (
      0 => '.\\templates\\NetworkBoxType_content_add.tpl',
      1 => 1328348622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '213514f2cfd31e82ce4-52173673',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2cfd31efeb9',
  'variables' => 
  array (
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
<?php if ($_valid && !is_callable('content_4f2cfd31efeb9')) {function content_4f2cfd31efeb9($_smarty_tpl) {?><form name="boxtypeinfo" action="NetworkBoxType.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table>
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
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
			<br />
		</tr>
</div>
</form><?php }} ?>