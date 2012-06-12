<form name="boxtypeinfo" action="CableType.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table id="contable">
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <label>{$marking}</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <label>{$manufacturer}</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">tubeQuantity</label></td><td> <label>{$tubeQuantity}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">fiberPerTube</label></td><td> <label>{$fiberPerTube}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">tensileStrength</label></td><td> <label>{$tensileStrength}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">diameter</label></td><td> <label>{$diameter}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">comment</label></td><td> <label>{$comment}</label></td>
		</tr>
	</table>
</div>
</form>