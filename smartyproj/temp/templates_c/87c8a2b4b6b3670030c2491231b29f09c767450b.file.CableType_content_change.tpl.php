<?php /* Smarty version Smarty-3.1.7, created on 2012-02-04 12:29:34
         compiled from ".\templates\CableType_content_change.tpl" */ ?>
<?php /*%%SmartyHeaderCode:316714f2d082f4071f3-62195445%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87c8a2b4b6b3670030c2491231b29f09c767450b' => 
    array (
      0 => '.\\templates\\CableType_content_change.tpl',
      1 => 1328351372,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '316714f2d082f4071f3-62195445',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2d082f52560',
  'variables' => 
  array (
    'id' => 0,
    'marking' => 0,
    'manufacturer' => 0,
    'tubeQuantity' => 0,
    'fiberPerTube' => 0,
    'tensileStrength' => 0,
    'diameter' => 0,
    'comment' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2d082f52560')) {function content_4f2d082f52560($_smarty_tpl) {?><form name="boxtypeinfo" action="CableType.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
		<td><label class="events_anonce">ID</label></td><td> <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
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
		<td><label class="events_anonce">tubeQuantity</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['tubeQuantity']->value;?>
" name="tubeQuantity"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">fiberPerTube</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['fiberPerTube']->value;?>
" name="fiberPerTube"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">tensileStrength</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['tensileStrength']->value;?>
" name="tensileStrength"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">diameter</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['diameter']->value;?>
" name="diameter"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">comment</label></td><td> <textarea name="comment"><?php echo $_smarty_tpl->tpl_vars['comment']->value;?>
</textarea></td>
		</tr>
		<tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</div>
</form><?php }} ?>