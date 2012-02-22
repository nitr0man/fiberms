<?php /* Smarty version Smarty-3.1.7, created on 2012-02-12 11:54:55
         compiled from ".\templates\NetworkBoxType_content_charac.tpl" */ ?>
<?php /*%%SmartyHeaderCode:78164f378b592c9742-41445751%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '748774ef4febe233099a8b14389ff72f183507f8' => 
    array (
      0 => '.\\templates\\NetworkBoxType_content_charac.tpl',
      1 => 1329040494,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78164f378b592c9742-41445751',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f378b5932733',
  'variables' => 
  array (
    'count' => 0,
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
<?php if ($_valid && !is_callable('content_4f378b5932733')) {function content_4f378b5932733($_smarty_tpl) {?><form name="boxtypeinfo" action="NetworkBoxType.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
		<td><label>NetworkBox: </label></td><td><label><?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</label></td>
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
		</tr><td><input type="hidden" name="whichadded" id="whichadded" value="networkboxtype" /></td>
		</tr>
	</table>
</div>
</form><?php }} ?>