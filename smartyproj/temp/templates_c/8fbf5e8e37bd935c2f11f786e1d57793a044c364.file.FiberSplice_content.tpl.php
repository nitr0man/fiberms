<?php /* Smarty version Smarty-3.1.7, created on 2012-02-22 15:22:01
         compiled from ".\templates\FiberSplice_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:75794f3bc96d191650-28776127%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8fbf5e8e37bd935c2f11f786e1d57793a044c364' => 
    array (
      0 => '.\\templates\\FiberSplice_content.tpl',
      1 => 1329916873,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '75794f3bc96d191650-28776127',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f3bc96d1f9f7',
  'variables' => 
  array (
    'data' => 0,
    'cols' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f3bc96d1f9f7')) {function content_4f3bc96d1f9f7($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_table.php';
?><form name="cabletype" onsubmit="return false">
<div>
	<table>
		<tr>
			<td>
			<?php echo smarty_function_html_table(array('loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>$_smarty_tpl->tpl_vars['cols']->value),$_smarty_tpl);?>

			</td>
		<br />
		</tr>
	</table>
</div>
</form><?php }} ?>