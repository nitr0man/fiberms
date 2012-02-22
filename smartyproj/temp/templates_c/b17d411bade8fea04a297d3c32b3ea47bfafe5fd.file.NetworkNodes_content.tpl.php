<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 13:19:01
         compiled from "./templates/NetworkNodes_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16688698164f2a4db40f9375-66151317%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b17d411bade8fea04a297d3c32b3ea47bfafe5fd' => 
    array (
      0 => './templates/NetworkNodes_content.tpl',
      1 => 1329729431,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16688698164f2a4db40f9375-66151317',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a4db4147f5',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a4db4147f5')) {function content_4f2a4db4147f5($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/home/neverloved/fiberms/smartyproj/libs/plugins/function.html_table.php';
?>	<form name="NetworkNode" id="NetworkNode" onsubmit="return false">
			<?php echo smarty_function_html_table(array('table_attr'=>'id="contable"','loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"<a href=\"#\">ID</a>,Name,NetworkBox,Note,OpenGIS,SettlementGeoSpatial,Building,Apartment,Change,Delete"),$_smarty_tpl);?>

	</form>
<?php }} ?>