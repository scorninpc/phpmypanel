<form action="{$basePath}/painel/bancodedados" method="post">
	<div class="row">

		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="row">

						<div class="col-12 mb-3">
							<label class="form-label">Query SQL</label>
							<textarea name="query" id="query" class="form-control">{$query}</textarea>
						</div>

						<div class="col-12 mb-3">
							{if $error}
								<div class="alert alert-danger small px-2 py-1">{$error->getCode()}: {$error->getMessage()}</div>
							{elseif $execution}
								<div class="alert alert-success small px-2 py-1">{$execution->rowCount()} linhas afetadas</div>
								{if isset($result)}
									<div class="table-responsive">
										<table class="table table-sm table-vcenter table-nowrap">
											<thead class="sticky-top bg-body">
												<tr>
													{foreach from=$result[0] item=row key=name}
													<th class="">{$name|escape}</th>
													{/foreach}
												</tr>
											</thead>
											<tbody>
												{foreach from=$result item=row}
												<tr>
													{foreach from=$row item=col}
													<td class="">
														{if $col === NULL}
															<i class="badge">NULL</i>
														{else if $col === TRUE}
															<i class="badge">TRUE</i>
														{else if $col === FALSE}
															<i class="badge">FALSE</i>
														{else if strlen($col) === 0}
															<i class="badge">EMPTY</i>
														{else}
															{$col|escape|default:"&nbsp;"}
														{/if}
													</td>
													{/foreach}
												</tr>
												{/foreach}
											</tbody>
										</table>
									</div>
								{/if}
							{/if}
						</div>

					</div>
				</div>

				<div class="card-footer">
					<div class="row g-2 justify-content-center justify-content-sm-between">
						<div class="col-auto d-flex align-items-center">
							<a href="{$basePath}/painel/bancodedados" class="btn btn-azure btn-sm nw-exportar">Exportar CSV</a>
							<input type="hidden" name="exportar" value="0">
						</div>
						<div class="col-auto">
							<input type="submit" value="Executar" class="btn btn-primary">
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</form>
