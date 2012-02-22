<?php /* Smarty version Smarty-3.1.7, created on 2012-02-02 19:53:06
         compiled from ".\templates\NetworkNodes_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:78694f2acd823a2f53-71753879%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e88e4623ac5bedb9e24b209a7884aa30a912a49' => 
    array (
      0 => '.\\templates\\NetworkNodes_content.tpl',
      1 => 1328204820,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78694f2acd823a2f53-71753879',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2acd823c9d4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2acd823c9d4')) {function content_4f2acd823c9d4($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_table.php';
?><form name="NetworkNode" id="NetworkNode" onsubmit="return false">
		<table>
		<tr>
			<td>
			<?php echo smarty_function_html_table(array('loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"<a href=\"#\">ID</a>,Name,NetworkBox,Note,OpenGIS,SettlementGeoSpatial,Building,Apartment,Change,Delete"),$_smarty_tpl);?>

			</td>
		<br />
		</tr>
</form>
<?php }} ?>