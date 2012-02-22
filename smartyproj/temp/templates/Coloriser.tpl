{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
{include file="menu.tpl"}
<script type="text/javascript" src="js/coloriser.js" ></script>
<script type="text/javascript" src="http://simonwillison.net/static/2003/getElementsBySelector.js"></script>
<script type="text/javascript">
function setstyle() {
document.colors.bodycolor.value = getstyle(document.getElementsByTagName('body')[0], 'color');
document.colors.bodybackground.value = getstyle(document.getElementsBySelector('body')[0], 'background');
document.colors.libackground.value = getstyle(document.getElementsBySelector('li')[0], 'background');
document.colors.contentbackground.value = getstyle(document.getElementsBySelector('#content')[0], 'background');
document.colors.contentth.value = getstyle(document.getElementsBySelector('#content th')[0], 'background');
document.colors.contenttd.value = getstyle(document.getElementsBySelector('#content td')[0], 'background');
//document.colors.alinkcolor.value = getstyle(document.getElementsBySelector('a:link')[0], 'color');
//document.colors.avisitedcolor.value = getstyle(document.getElementsBySelector('a:visited')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
//document.colors.aactivecolor.value = getstyle(document.getElementsBySelector('a:active')[0], 'color');
document.colors.leftcolmenu.value = getstyle(document.getElementsBySelector('.left_col .menu')[0], 'background');
//document.colors.leftcolmenuh3.value = getstyle(document.getElementsBySelector('.left_col .menu h3')[0], 'background');
document.colors.leftcolmenuulli.value = getstyle(document.getElementsBySelector('.left_col .menu ul li')[0], 'background');
document.colors.leftcolmenuullili.value = getstyle(document.getElementsBySelector('.left_col .menu ul li li')[0], 'border');
//document.colors.leftcolmenuullihover.value = getstyle(document.getElementsBySelector('.left_col .menu ul li:hover')[0], 'background');
document.colors.contable.value = getstyle(document.getElementsBySelector('#contable')[0], 'border');
}
</script>
<div id="content">
	<form name="colors" method="POST" action="coloriser.php">
		<table id="contable">
		<th>Заголовок</th><th>Значение</th><th>Заголовок</th><th>Значение</th>
			<tr>
				<td>
					<label>Цвет текста страницы</label>
				</td>
				<td>
					<input size="35" type="text" value="" name="bodycolor"></td>
				</td>
				<td>
					<label>Фон страницы</label>
				</td>
				<td>
					<input size="35" type="text" value="{$bodybackground}" name="bodybackground"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Элемент списка</label>
				</td>
				<td>
					<input size="35" type="text" value="{$libackground}" name="libackground"></td>
				</td>
				<td>
					<label>Фон блока #content</label>
				</td>
				<td>
					<input size="35" type="text" value="{$contentbackground}" name="contentbackground"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет заголовка таблицы</label>
				</td>
				<td>
					<input size="35" type="text" value="{$contentth}" name="contentth"></td>
				</td>
				<td>
					<label>Цвет ячейки таблицы</label>
				</td>
				<td>
					<input size="35" type="text" value="{$contenttd}" name="contenttd"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет ссылки</label>
				</td>
				<td>
					<input size="35" type="text" value="{$alinkcolor}" name="alinkcolor"></td>
				</td>
				<td>
					<label>Цвет посещенной ссылки</label>
				</td>
				<td>
					<input size="35" type="text" value="{$avisitedcolor}" name="avisitedcolor"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет активной ссылки</label>
				</td>
				<td>
					<input size="35" type="text" value="{$aavtivecolor}" name="aactivecolor"></td>
				</td>
				<td>
					<label>Фон меню</label>
				</td>
				<td>
					<input size="35" type="text" value="{$leftcolmenu}" name="leftcolmenu"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет заголовка меню</label>
				</td>
				<td>
					<input size="35" type="text" value="{$leftcolmenuh3}" name="leftcolmenuh3"></td>
				</td>
				<td>
					<label>Фон элементов списка в меню</label>
				</td>
				<td>
					<input size="35" type="text" value="{$leftcolmenuulli}" name="leftcolmenuulli"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Цвет рамки меню</label>
				</td>
				<td>
					<input size="35" type="text" value="{$leftcolmenuullili}" name="leftcolmenuullili"></td>
				</td>
				<td>
					<label>Выбранный элемент меню</label>
				</td>
				<td>
					<input size="35" type="text" value="{$leftcolmenuullihover}" name="leftcolmenuullihover"></td>
				</td>
			</tr>
			<tr>
				<td>
					<label>Рамка центральной таблицы</label>
				</td>
				<td>
					<input size="35" type="text" value="{$contable}" name="contable"></td>
				</td>
				<td></td><td><input type="submit" value="Применить" /></td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
setstyle();
</script>
{include file="footer.tpl"}
