<a href="#" class="btn btn-primary">New Record</a>

<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Text</th>
			<th>Varchar</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$tests item=test}
		<tr>
			<td>{$test['idtest']|escape}</td>
			<td>{$test['text_field']|escape|nl2br}</td>
			<td>{$test['varchar_field']|escape}</td>
			<td class="text-end">
				<a href="#" class="btn btn-danger">-</a>
				<a href="#" class="btn btn-warning">+</a>
			</td>
		</tr>
		{/foreach}
	</tbody>
</table>