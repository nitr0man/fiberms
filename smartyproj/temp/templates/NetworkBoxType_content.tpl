<form name="boxtypevalue" onsubmit="return false">
<div id="ololo">
	<table>
		<tr>
		<td><label class="events_anonce">Тип ящика</label></td><td id="newboxform">
		<select name="networkboxtypes" onChange="javascript: GetTypeBoxInfo(document.boxtypevalue.networkboxtypes.value,1);">
		{html_options values=$combobox_boxtype_values selected=$combobox_boxtype_selected output=$combobox_boxtype_text}
		</select>
		
		</td>

<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Кол-во:</label></td><td id="inventorynumber"> <a href="#" class="events_anonce">{$count}</a></td><!--<td><input type="text" name="invmun" size="30" /></td>-->
<br />
		</tr>
		<tr>
		<td><!--<label class="events_anonce">deprecated</label>--></td><td><input type="hidden" name="whichadded" value="networkbox" size="30" /></td>
		</tr>
		<tr>
		<td><label class="events_anonce"><input type="radio" name="group1" id="rb1" checked="checked" onClick="javascript: GetTypeBoxInfo(0,1); document.boxtype.addchangebutton.value = 'Изменить';"> Изменить</label><br />   
		<label class="events_anonce"><input type="radio" name="group1" id="rb2" onClick="javascript: ClearInput(); document.boxtype.addchangebutton.value = 'Добавить';"> Добавить новый тип</label></td>
		</tr>
	</table>
</div>
</form>

<form name="boxtype" onSubmit="return false">
<!--	<div id="addnewboxtype">-->
		<table>
		<tr>
		<td><label class="events_anonce">ID</label></td><td> <input type="text" value="{$id}" name="id"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <input type="text" value="{$marking}" name="marking"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <input type="text" value="{$manufacturer}" name="manufacturer"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Units</label></td><td> <input type="text" value="{$units}" name="units"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Width</label></td><td> <input type="text" value="{$width}" name="width"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Height</label></td><td> <input type="text" value="{$height}" name="height"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Length</label></td><td> <input type="text" value="{$length}" name="length"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Diameter</label></td><td> <input type="text" value="{$diameter}" name="diameter"></td>
		</tr><td><input type="hidden" name="whichadded" id="whichadded" value="networkboxtype" /></td><td><input value="Изменить" type="submit" name="addchangebutton" onclick="javascript: AddNewOrChangeBoxType(2,document.getElementById('rb1').checked,document.boxtype.id.value,document.boxtype.marking.value,document.boxtype.manufacturer.value,document.boxtype.units.value,document.boxtype.width.value,document.boxtype.height.value,document.boxtype.length.value,document.boxtype.diameter.value)" /></td></form>
		</tr>
		</table>
<!--	</div>-->
</form>