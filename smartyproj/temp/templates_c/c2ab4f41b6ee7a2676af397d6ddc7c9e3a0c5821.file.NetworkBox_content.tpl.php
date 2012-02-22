<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 12:57:16
         compiled from "./templates/NetworkBox_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19539547974f2a4d855a53b0-91110021%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2ab4f41b6ee7a2676af397d6ddc7c9e3a0c5821' => 
    array (
      0 => './templates/NetworkBox_content.tpl',
      1 => 1329728234,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19539547974f2a4d855a53b0-91110021',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a4d855ba63',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a4d855ba63')) {function content_4f2a4d855ba63($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/home/neverloved/fiberms/smartyproj/libs/plugins/function.html_table.php';
?><form name="boxtypevalue" onsubmit="return false">
<div>
			<?php echo smarty_function_html_table(array('table_attr'=>'id="contable"','loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"<a href=\"#\">ID</a>,BoxType,InvNum,Change,Delete"),$_smarty_tpl);?>

</div>
</form>
<?php }} ?>