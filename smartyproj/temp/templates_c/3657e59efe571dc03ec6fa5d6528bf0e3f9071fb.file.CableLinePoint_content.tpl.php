<?php /* Smarty version Smarty-3.1.7, created on 2012-02-15 16:48:04
         compiled from ".\templates\CableLinePoint_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:43124f369ceb76aec9-29014706%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3657e59efe571dc03ec6fa5d6528bf0e3f9071fb' => 
    array (
      0 => '.\\templates\\CableLinePoint_content.tpl',
      1 => 1329317246,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '43124f369ceb76aec9-29014706',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f369ceb7bd5e',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f369ceb7bd5e')) {function content_4f369ceb7bd5e($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_table.php';
?><form name="cabletype" onsubmit="return false">
<div>
	<table>
		<tr>
			<td>
			<?php echo smarty_function_html_table(array('loop'=>$_smarty_tpl->tpl_vars['data']->value,'cols'=>"<a href=\"#\">ID</a>,OpenGIS,CableLine,meterSign,NetworkNode,note,Apartment,Building,SettlementGeoSpatial,Change,Delete"),$_smarty_tpl);?>

			</td>
		<br />
		</tr>
</div>
</form><?php }} ?>