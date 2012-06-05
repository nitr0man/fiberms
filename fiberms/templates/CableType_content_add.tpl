<form name="cabletypeinfo" action="CableType.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table id="contable">
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <input type="text" name="marking"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <input type="text" name="manufacturer"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">tubeQuantity</label></td><td> <input type="text" name="tubeQuantity"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">fiberPerTube</label></td><td> <input type="text" name="fiberPerTube"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">tensileStrength</label></td><td> <input type="text" name="tensileStrength"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">diameter</label></td><td> <input type="text" name="diameter"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">comment</label></td><td> <textarea name="comment"></textarea></td>
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
			<br />
		</tr>
</div>
</form>
