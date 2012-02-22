<?php /* Smarty version Smarty-3.1.7, created on 2012-02-04 12:10:09
         compiled from ".\templates\CableType_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:88994f2d0401b4aeb8-01290179%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '509ab58166e24ac8f53730454008396d9123013f' => 
    array (
      0 => '.\\templates\\CableType_content.tpl',
      1 => 1328349370,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '88994f2d0401b4aeb8-01290179',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2d0401b59a8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2d0401b59a8')) {function content_4f2d0401b59a8($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_table.php';
?><form name="cabletype" onsubmit="return false">
<div>
	<table>
		<tr>
			<td>
			<?php echo smarty_function_html_table(array('loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"<a href=\"#\">ID</a>,marking,manufacturer,tubeQuanity,fiberPerTube,tensileStrength,diameter,comment,CableCount,Delete"),$_smarty_tpl);?>

			</td>
		<br />
		</tr>
</div>
</form><?php }} ?>