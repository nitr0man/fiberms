<?php /* Smarty version Smarty-3.1.7, created on 2012-02-13 16:12:49
         compiled from ".\templates\FSOT_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:152834f391a6167b365-78004100%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c98db9f45f4089980b819eea9ddc09a753d90cda' => 
    array (
      0 => '.\\templates\\FSOT_content.tpl',
      1 => 1329142144,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152834f391a6167b365-78004100',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f391a6181d8f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f391a6181d8f')) {function content_4f391a6181d8f($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_table.php';
?><form name="cabletype" onsubmit="return false">
<div>
	<table>
		<tr>
			<td>
			<?php echo smarty_function_html_table(array('loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"ID,<a href=\"#\">marking</a>,manufacturer,note,Change,Delete"),$_smarty_tpl);?>

			</td>
		<br />
		</tr>
	</table>
</div>
</form><?php }} ?>