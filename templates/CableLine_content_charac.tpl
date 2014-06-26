<form name="cablelineinfo" action="CableLine.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<center><table id="contable">
		<tr>
		<td><label class="events_anonce">Имя</label></td><td> <label class="events_anonce">{$name}</label></td>
		</tr>		
		<tr>
		<td><label class="events_anonce">Тип кабеля</label></td><td> <label class="events_anonce">{$CableType}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <label class="events_anonce">{$manufacturer}</label></td>
		</tr>
		<td><label class="events_anonce">Длина</label></td><td> <label class="events_anonce">{$length}</label></td>
		</tr>
		<tr>
		<tr>
		<td><label class="events_anonce">Примечание</label></td><td> <label class="events_anonce">{$comment}</label></td>
		</tr>
		<!--tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr-->		
	</table>	

	<div>
			{html_table loop=$data table_attr='id="contable"' cols="ID,Узел,Отметка (м),Координаты,Примечание,Изм.,Удал." caption="Список точек на линии"}
			<p style="margin: 20px;">{$AddPoint}</a>
			<td>{$ChangeDelete}</td>
	</div>
	</center>

</div>
</form>