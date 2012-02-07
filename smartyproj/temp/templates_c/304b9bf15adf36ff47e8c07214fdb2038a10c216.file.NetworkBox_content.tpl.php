<?php /* Smarty version Smarty-3.1.7, created on 2012-02-01 16:56:09
         compiled from ".\templates\NetworkBox_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:294374f27e706170d46-06763463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '304b9bf15adf36ff47e8c07214fdb2038a10c216' => 
    array (
      0 => '.\\templates\\NetworkBox_content.tpl',
      1 => 1328107650,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '294374f27e706170d46-06763463',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f27e7061b8ad',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f27e7061b8ad')) {function content_4f27e7061b8ad($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_table.php';
?><form name="boxtypevalue" onsubmit="return false">
<div>
	<table>
		<tr>
			<td>
			<?php echo smarty_function_html_table(array('loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"<a href=\"#\">ID</a>,BoxType,InvNum,Change,Delete"),$_smarty_tpl);?>

			</td>
		<br />
		</tr>
</div>
</form><?php }} ?>