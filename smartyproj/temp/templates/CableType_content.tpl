<form name="cabletype" onsubmit="return false">
			{if ($smarty.get.sort == 1)}
			{$sort = 0}
			{else}
			{$sort = 1}
			{/if}
			{html_table table_attr='id="contable"' loop=$data cols="ID,<a href=\"CableType.php?sort=$sort\">marking</a>,manufacturer,tubeQuanity,fiberPerTube,tensileStrength,diameter,comment,CableCount,Delete" caption="Список типов кабелей"}
</form>
