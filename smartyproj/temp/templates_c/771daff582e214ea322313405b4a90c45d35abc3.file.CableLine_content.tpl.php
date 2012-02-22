<?php /* Smarty version Smarty-3.1.7, created on 2012-02-11 18:44:44
         compiled from ".\templates\CableLine_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:188514f2d13beb440b7-21221292%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '771daff582e214ea322313405b4a90c45d35abc3' => 
    array (
      0 => '.\\templates\\CableLine_content.tpl',
      1 => 1328977228,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188514f2d13beb440b7-21221292',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2d13bebd86f',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2d13bebd86f')) {function content_4f2d13bebd86f($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_table.php';
?><form name="cabletype" onsubmit="return false">
<div>
	<table>
		<tr>
			<td>
			<?php echo smarty_function_html_table(array('loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"<a href=\"#\">ID</a>,OpenGIS,CableType,length,comment,Change,Delete"),$_smarty_tpl);?>

			</td>
		<br />
		</tr>
	</table>
</div>
</form><?php }} ?>