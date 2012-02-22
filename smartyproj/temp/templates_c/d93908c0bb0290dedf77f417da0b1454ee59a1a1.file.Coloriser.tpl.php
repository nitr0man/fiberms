<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 19:51:42
         compiled from "./templates/Coloriser.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7911580404f422052f2fc42-02402044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd93908c0bb0290dedf77f417da0b1454ee59a1a1' => 
    array (
      0 => './templates/Coloriser.tpl',
      1 => 1329753036,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7911580404f422052f2fc42-02402044',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f4220531cb42',
  'variables' => 
  array (
    'bodybackground' => 0,
    'libackground' => 0,
    'contentbackground' => 0,
    'contentth' => 0,
    'contenttd' => 0,
    'alinkcolor' => 0,
    'avisitedcolor' => 0,
    'aavtivecolor' => 0,
    'leftcolmenu' => 0,
    'leftcolmenuh3' => 0,
    'leftcolmenuulli' => 0,
    'leftcolmenuullili' => 0,
    'leftcolmenuullihover' => 0,
    'contable' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f4220531cb42')) {function content_4f4220531cb42($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="js/coloriser.js" ></script>
<script type="text/javascript" src="http://simonwillison.net/static/2003/getElementsBySelector.js"></script>
<script type="text/javascript">
function setstyle() {
document.colors.bodycolor.value = getstyle(document.getElementsByTagName('body')[0], 'color');
document.colors.bodybackground.value = getstyle(document.getElementsBySelector('body')[0], 'background');
document.colors.libackground.value = getstyle(document.getElementsBySelector('li')[0], 'background');
document.colors.contentbackground.value = getstyle(document.getElementsBySelector('#content')[0], 'background');
document.colors.contentth.value = getstyle(document.getElementsBySelector('#content th')[0], 'background');
document.colors.contenttd.value = getstyle(document.getElementsBySelector('#content td')[0], 'background');
//document.colors.alinkcolor.value = getstyle(document.getElementsBySelector('a:link')[0], 'color');
//document.colors.avisitedcolor.value = getstyle(document.getElementsBySelector('a:visited')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
document.colors.leftcolmenu.value = getstyle(document.getElementsBySelector('.left_col .menu')[0], 'background');
//document.colors.leftcolmenuh3.value = getstyle(document.getElementsBySelector('.left_col .menu h3')[0], 'background');
document.colors.leftcolmenuulli.value = getstyle(document.getElementsBySelector('.left_col .menu ul li')[0], 'background');
document.colors.leftcolmenuullili.value = getstyle(document.getElementsBySelector('.left_col .menu ul li li')[0], 'border');
//document.colors.leftcolmenuullihover.value = getstyle(document.getElementsBySelector('.left_col .menu ul li:hover')[0], 'background');
document.colors.contable.value = getstyle(document.getElementsBySelector('#contable')[0], 'border');
}
</script>
<div id="content">
	<form name="colors" method="POST" action="coloriser.php">
		<table id="contable">
		<th>Заголовок</th><th>Значение</th><th>Заголовок</th><th>Значение</th>
			<tr>
				<td>
					<label>Цвет текста страницы</label>
				</td>
				<td>
					<input size="35" type="text" value="" name="bodycolor"></td>
				</td>
				<td>
					<label>Фон страницы</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['bodybackground']->value;?>
" name="bodybackground"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Элемент списка</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['libackground']->value;?>
" name="libackground"></td>
				</td>
				<td>
					<label>Фон блока #content</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['contentbackground']->value;?>
" name="contentbackground"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет заголовка таблицы</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['contentth']->value;?>
" name="contentth"></td>
				</td>
				<td>
					<label>Цвет ячейки таблицы</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['contenttd']->value;?>
" name="contenttd"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет ссылки</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['alinkcolor']->value;?>
" name="alinkcolor"></td>
				</td>
				<td>
					<label>Цвет посещенной ссылки</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['avisitedcolor']->value;?>
" name="avisitedcolor"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет активной ссылки</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['aavtivecolor']->value;?>
" name="aactivecolor"></td>
				</td>
				<td>
					<label>Фон меню</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['leftcolmenu']->value;?>
" name="leftcolmenu"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет заголовка меню</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['leftcolmenuh3']->value;?>
" name="leftcolmenuh3"></td>
				</td>
				<td>
					<label>Фон элементов списка в меню</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['leftcolmenuulli']->value;?>
" name="leftcolmenuulli"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет рамки меню</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['leftcolmenuullili']->value;?>
" name="leftcolmenuullili"></td>
				</td>
				<td>
					<label>Выбранный элемент меню</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['leftcolmenuullihover']->value;?>
" name="leftcolmenuullihover"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Рамка центральной таблицы</label>
				</td>
				<td>
					<input size="35" type="text" value="<?php echo $_smarty_tpl->tpl_vars['contable']->value;?>
" name="contable"></td>
				</td>
				<td></td><td><input type="submit" value="Применить" /></td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
setstyle();
</script>
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>