<?php /* Smarty version Smarty-3.1.7, created on 2012-01-29 12:47:41
         compiled from ".\templates\NetworkBoxType.tpl" */ ?>
<?php /*%%SmartyHeaderCode:135244f251f8f8044d4-48958935%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '760c36eb95a98cd2ec51099002f1be78d9cf3e35' => 
    array (
      0 => '.\\templates\\NetworkBoxType.tpl',
      1 => 1327834052,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '135244f251f8f8044d4-48958935',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f251f8f8a951',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f251f8f8a951')) {function content_4f251f8f8a951($_smarty_tpl) {?>﻿<?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div id="boxinv">
<body onload="javascript: GetBoxTypeList(1);">
<div id="backscript">&nbsp;</div>
<script type="text/javascript">

function initscript(block)
{
	lol = block;
	lol = lol.replace(/\#/g,"");
	$(block).replaceWith( "<input id=\""+block+"\" type=\"text\" name=\""+lol+"\" size=\"30\" />" );
}
function setvalues(first,second,third,fourth,fifth,sixs,seventh) {
	$('#marking').replaceWith("<label id=\"marking\" onclick=\"initscript('#marking')\">"+first+"</label>");
	$('#manufacturer').replaceWith("<label id=\"manufacturer\" onclick=\"initscript('#manufacturer')\">"+second+"</label>");
	$('#units').replaceWith("<label id=\"units\" onclick=\"initscript('#units')\">"+third+"</label>");
	$('#width').replaceWith("<label id=\"width\" onclick=\"initscript('#width')\">"+fourth+"</label>");
	$('#height').replaceWith("<label id=\"height\" onclick=\"initscript('#height')\">"+fifth+"</label>");
	$('#length').replaceWith("<label id=\"length\" onclick=\"initscript('#length')\">"+sixs+"</label>");
	$('#diameter').replaceWith("<label id=\"diameter\" onclick=\"initscript('#diameter')\">"+seventh+"</label>");
}
	</script>
<div id="content">
<?php echo $_smarty_tpl->getSubTemplate ("NetworkBoxType_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
<br />

</body>
</div><?php }} ?>