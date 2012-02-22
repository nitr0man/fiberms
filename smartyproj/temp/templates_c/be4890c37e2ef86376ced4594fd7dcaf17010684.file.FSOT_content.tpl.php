<?php /* Smarty version Smarty-3.1.7, created on 2012-02-22 18:41:18
         compiled from "./templates/FSOT_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5394715774f44fe8e3e49d9-65914521%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be4890c37e2ef86376ced4594fd7dcaf17010684' => 
    array (
      0 => './templates/FSOT_content.tpl',
      1 => 1329920548,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5394715774f44fe8e3e49d9-65914521',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f44fe8e3f50d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f44fe8e3f50d')) {function content_4f44fe8e3f50d($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/home/neverloved/fiberms/smartyproj/libs/plugins/function.html_table.php';
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