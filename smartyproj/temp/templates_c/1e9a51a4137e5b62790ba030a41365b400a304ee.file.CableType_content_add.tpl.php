<?php /* Smarty version Smarty-3.1.7, created on 2012-02-04 12:26:31
         compiled from ".\templates\CableType_content_add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:150114f2d0407423b78-63104982%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1e9a51a4137e5b62790ba030a41365b400a304ee' => 
    array (
      0 => '.\\templates\\CableType_content_add.tpl',
      1 => 1328351184,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150114f2d0407423b78-63104982',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2d04074578b',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2d04074578b')) {function content_4f2d04074578b($_smarty_tpl) {?><form name="cabletypeinfo" action="CableType.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table>
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <input type="text" name="marking"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <input type="text" name="manufacturer"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">tubeQuantity</label></td><td> <input type="text" name="tubeQuantity"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">fiberPerTube</label></td><td> <input type="text" name="fiberPerTube"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">tensileStrength</label></td><td> <input type="text" name="tensileStrength"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">diameter</label></td><td> <input type="text" name="diameter"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">comment</label></td><td> <textarea name="comment"></textarea></td>
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
			<br />
		</tr>
</div>
</form><?php }} ?>