<?php /* Smarty version Smarty-3.1.7, created on 2012-02-24 17:59:13
         compiled from ".\templates\menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:191734f27bf43b8e1d0-80190760%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85192c6e9f55456bef8cf932502504a0684ee09b' => 
    array (
      0 => '.\\templates\\menu.tpl',
      1 => 1329925580,
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
<?php if ($_valid && !is_callable('content_4f27bf43b90e5')) {function content_4f27bf43b90e5($_smarty_tpl) {?><div class="leftcolumn">
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
		  <li id="li4"><a href="#">Кабеля</a>
			<ul>
			  <li id="li4"><a href="CableType.php">Список типов кабелей</a></li>
			  <li id="li4"><a href="CableType.php?mode=add">Добавить тип кабеля</a></li>
			  <li id="li4"><a href="CableLine.php">Список кабелей</a></li>
			  <li id="li4"><a href="CableLine.php?mode=add">Добавить кабель</a></li>
			</ul>
		  </li>
		  <li id="li4"><a href="#">Волокно</a>
			<ul>
			  <li id="li4"><a href="FSOT.php">Список типов волокон</a></li>
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