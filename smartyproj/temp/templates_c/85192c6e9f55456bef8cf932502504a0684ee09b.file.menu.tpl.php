<?php /* Smarty version Smarty-3.1.7, created on 2012-02-03 14:14:27
         compiled from ".\templates\menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:191734f27bf43b8e1d0-80190760%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85192c6e9f55456bef8cf932502504a0684ee09b' => 
    array (
      0 => '.\\templates\\menu.tpl',
      1 => 1328270858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '191734f27bf43b8e1d0-80190760',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f27bf43b90e5',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f27bf43b90e5')) {function content_4f27bf43b90e5($_smarty_tpl) {?><body>
<div class="leftcolumn">
 <div class="left_col">
 <div class="menu">
 <h3>Menu header</h3>
 <ul>
	<li id="li4"><a href="#">Ящики</a>
		<ul>
			<li id="li4"><a href="NetworkBox.php">Список ящиков</a></li>
			<li id="li4"><a href="NetworkBox.php?mode=add">Добавить ящик</a></li>
			<li id="li4"><a href="NetworkBoxType.php">Типы ящиков</a></li>			
			<li id="li4"><a href="#">Добавить\изменить тип</a></li>
		</ul>
	</li>
	<li id="li4"><a href="#">Узлы</a>
		<ul>
			<li id="li4"><a href="NetworkNodes.php">Список узлов</a></li>
			<li id="li4"><a href="NetworkNodes.php?mode=add">Добавить узел</a></li>
		</ul>
	</li>
	<li id="li4"><a href="Users.php">Пользователи</a></li>
	<li id="li4">element3</li>
	<li id="li4">element4</li>
	<li id="li4">element5</li>
	<li id="li4"><a href="logout.php">Выход</a></li>
 </ul>
 </div>
 </div>
 </div>
</body>
<?php }} ?>