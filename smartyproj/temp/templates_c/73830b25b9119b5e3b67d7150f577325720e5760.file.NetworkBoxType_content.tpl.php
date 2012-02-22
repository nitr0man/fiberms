<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 12:59:36
         compiled from "./templates/NetworkBoxType_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8504914604f2a4d6ca95b92-46623030%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73830b25b9119b5e3b67d7150f577325720e5760' => 
    array (
      0 => './templates/NetworkBoxType_content.tpl',
      1 => 1329728363,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8504914604f2a4d6ca95b92-46623030',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a4d6cae0be',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a4d6cae0be')) {function content_4f2a4d6cae0be($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/home/neverloved/fiberms/smartyproj/libs/plugins/function.html_table.php';
?><form name="boxtype" onsubmit="return false">
			<?php echo smarty_function_html_table(array('table_attr'=>'id="contable"','loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"<a href=\"#\">ID</a>,marking,manufacturer,units,width,height,length,diameter,BoxCount,Delete"),$_smarty_tpl);?>

</form>
<?php }} ?>