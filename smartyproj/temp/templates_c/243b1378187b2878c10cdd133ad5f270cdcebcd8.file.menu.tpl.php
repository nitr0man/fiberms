<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 13:22:09
         compiled from "./templates/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1761087674f2a4d6ca8e950-80896190%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '243b1378187b2878c10cdd133ad5f270cdcebcd8' => 
    array (
      0 => './templates/menu.tpl',
      1 => 1329729727,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1761087674f2a4d6ca8e950-80896190',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a4d6ca9182',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a4d6ca9182')) {function content_4f2a4d6ca9182($_smarty_tpl) {?><div class="leftcolumn">
  <div class="left_col">
    <div class="menu">
      <div id="smoothmenu1" class="ddsmoothmenu">
        <ul>
          <li><a href="index.php">Главная</a></li>
		  <li><a href="#">Ящики</a>
			<ul>
			  <li><a href="NetworkBox.php">Все ящики</a></li>
			  <li><a href="NetworkBox.php?mode=add">Добавить ящик</a></li>
			  <li><a href="NetworkBoxType.php">Типы ящиков</a></li>
			</ul>
		  </li>
		  <li><a href="#">Узлы</a>
			<ul>
			  <li><a href="NetworkNodes.php">Все узлы</a></li>
			  <li><a href="NetworkNodes.php?mode=add">Добавить узел</a></li>
		    </ul>
		  </li>
		  <li><a href="Users.php">Пользователи</a></li>
		  <li><a href="logout.php">Выйти</a></li>
		</ul>
	  <br style="clear: left" />
	  </div>
	</div>
  </div>
</div>
<table align="center">
<tr>
	<td>
<?php }} ?>