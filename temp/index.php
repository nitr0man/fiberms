<?php include 'header.php' ?>
<body>
 <div class="leftcolumn">
 <div class="left_col">
 <div class="menu">
 <h3>Menu header</h3>
 <ul>
	<li id="li4">element1</li>
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
function initscript() {
	$('#boxtype').replaceWith( "<td id=\"boxtype\"> <input type=\"text\" name=\"boxtype\" size=\"30\" /></td>" ); }
	</script>
<div id="content">
<form method="post" action="index.html">
<table>
<tr>
<td><label class="events_anonce">Тип ящика</label></td><td id="boxtype"> <label onclick="initscript()">\получить из базы\</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
<br />
</tr>
<tr>
<td><label class="events_anonce">Инв. номер</label></td><td><input type="text" name="invmun" size="30" /></td>
<br />
</tr>
<tr>
<td><label class="events_anonce">deprecated</label></td><td><input type="text" name="" size="30" /></td>

<br />

</form>
</body>
</html>
