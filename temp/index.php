<?php include 'header.php' ?>
<body>
 <div class="leftcolumn">
 <div class="left_col">
 <div class="menu">
 <h3>Menu header</h3>
 <ul>
	<li id="li4">NetworkBox</li>
	<li id="li4">element2</li>
	<li id="li4">element3</li>
	<li id="li4">element4</li>
	<li id="li4">element5</li>
	<li id="li4">element6</li>
 </ul>
 </div>
 </div>
 </div>
<script type="text/javascript">
function initscript(block) 
{
	$(block).replaceWith( "<td id=\""+block+"\"> <input type=\"text\" name=\""+block+"\" size=\"30\" /></td>" ); 
}

	</script>
<div id="content">
<form method="post" action="index.html">
<table><tr><td>
<table>
<tr>
<td><label class="events_anonce">Тип ящика</label></td><td id="boxtype"> <label onclick="initscript('#boxtype')">\получить из базы\</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
<br />
</tr>
<tr>
<td><label class="events_anonce">Инв. номер</label></td><td id="invnum"> <label onclick="initscript('#invnum')">\получить из базы\</label></td><!--<td><input type="text" name="invmun" size="30" /></td>-->
<br />
</tr>
<tr>
<td><label class="events_anonce">deprecated</label></td><td><input type="text" name="" size="30" /></td>
</table>
</td></tr>
<tr><td>
<table>
<tr>
<td><label class="events_anonce">Маркировка</label></td><td id="marking"> <label onclick="initscript('#marking')">\получить из базы\</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
<br />
</tr>
<tr>
<td><label class="events_anonce">Производитель</label></td><td id="manufacterer"> <label onclick="initscript('#manufacterer')">\получить из базы\</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
<br />
</tr>
<tr>
<td><label class="events_anonce">Унитс</label></td><td id="units"> <label onclick="initscript('#units')">\получить из базы\</label></td>
</tr>
<tr>
<td><label class="events_anonce">Видтх</label></td><td id="width"> <label onclick="initscript('#width')">\получить из базы\</label></td>
</tr>
<tr>
<td><label class="events_anonce">Хеигхт</label></td><td id="marking"> <label onclick="initscript('#height')">\получить из базы\</label></td>
</tr>
<tr>
<td><label class="events_anonce">Ленгтх</label></td><td id="length"> <label onclick="initscript('#length')">\получить из базы\</label></td>
</tr>
<tr>
<td><label class="events_anonce">Диаметыр</label></td><td id="diameter"> <label onclick="initscript('#diameter')">\получить из базы\</label></td>
</tr>

</table>
<br />

</form>
</body>
</html>
