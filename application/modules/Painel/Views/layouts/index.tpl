{* page header *}
<div class="page-header d-print-none">
	<div class="container-xl">
		<div class="row g-2 align-items-center">

			{* titulo *}
			<div class="col-auto col-md-9">
				<div class="page-pretitle">{$core_funcionalidade['nome']|escape}</div>
				<h2 class="page-title">Listagem de {$core_funcionalidade['nome']|escape}</h2>
			</div>

			{* botoes *}
			<div class="col-auto ms-auto d-print-none">
				<div class="btn-list">

					{* busca *}
					<div class="col-auto ms-auto d-print-none">
						<form action="{$this->url(['controller'=>$core_funcionalidade['controlador'], 'action'=>"index"], "painel")}" method="post">
							<div class="input-group input-group-flat">
								<input type="text" name="query" value="{$core_query|default:""|escape}" class="form-control" placeholder="Procurar...">
								<span class="input-group-text p-0">
									<button class="btn btn-action">
										<i class="fa-solid fa-magnifying-glass"></i>
									</button>
								</span>
							</div>
						</form>
					</div>

					<a href="{$this->url(['controller'=>$core_funcionalidade['controlador'], 'action'=>"form"], "painel")}" class="btn btn-primary btn btn-primary btn-icon px-0 px-sm-3">
						<i class="fa-solid fa-plus"></i>
						<span class="d-none d-sm-inline-block ps-1">Novo</span>
					</a>

				</div>
			</div>

		</div>
	</div>
</div>


{* page body *}
<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="card-body p-1">
				{* real content *}
				<div class="table-responsive">
					<table class="table table-vcenter table-striped sin-table">
						<thead>
							<tr>
								{* percorre as colunas do model *}
								{foreach from=$core_model->getColumns() item=column}
									{* verifica a visilibidade do campo *}
									{if $core_model->getVisibility($column['name'], 'list')}
									<th>{$column['description']|escape}</th>
									{/if}
								{/foreach}
							</tr>
						</thead>
						<tbody>
							{* {if $rows->count() == 0}
								<tr>
									<td class="text-center">No record to list</td>
								</tr>
							{/if} *}

							{* percorre os registros *}
							{foreach from=$core_rows item=row}
							<tr>

								{* percorre as colunas do model *}
								{foreach from=$core_model->getColumns() item=column}
									{* verifica a visilibidade do campo *}
									{if $core_model->getVisibility($column['name'], 'list')}
									<td>
										<a href="{$this->url(['controller'=>$core_funcionalidade['controlador'], 'action'=>"form", $core_model->getPrimaryKey()=>$row[$core_model->getPrimaryKey()]], "painel")}">
											{$this->getFormatedValue($core_model, $column['name'], $row)|default:"&nbsp;"}
										</a>
									</td>
									{/if}
								{/foreach}
								
							</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>

			{* card footer *}
			<div class="card-footer">


				<div class="row g-2 justify-content-center justify-content-sm-between">
					<div class="col-auto d-flex align-items-center">
						<p class="m-0 text-secondary">Exibindo de <strong>{$core_rows->firstItem()}</strong> á <strong>{$core_rows->lastItem()}</strong> do total de <strong>{$core_rows->total()}</strong> registros em <strong>{$core_rows->lastPage()}</strong> páginas.</p>
					</div>
					<div class="col-auto">
						<ul class="pagination m-0 ms-auto">

							{* primeira pagina *}
							{if $core_rows->currentPage() > 4}
								
								<li class="page-item">
									<a class="page-link" href="{$basePath}/painel/{$core_current_controller}/{$core_current_action}/pagina/1" >
										<i class="fa-solid fa-angles-left"></i>
									</a>
								</li>
							{/if}

							{* 4 paginas anterior *}
							{for $i=-3 to -1}
								{if ($core_rows->currentPage() + $i) >= 1}
									<li class="page-item">
										<a class="page-link" href="{$basePath}/painel/{$core_current_controller}/{$core_current_action}/pagina/{$core_rows->currentPage()+$i}" >
											{sprintf("%01d", $core_rows->currentPage()+$i)}
										</a>
									</li>
								{/if}
							{/for}

							{* pagina atual *}
							<li class="page-item active">
								<a class="page-link" href="{$basePath}/painel/{$core_current_controller}/{$core_current_action}/pagina/{$core_rows->currentPage()}" >
									{sprintf("%01d", $core_rows->currentPage())}
								</a>
							</li>
							
							{* proximas 4 paginas *}
							{for $i=1 to 3}
								{if ($core_rows->currentPage() + $i) <= $core_rows->lastPage()}
									<li class="page-item">
										<a class="page-link" href="{$basePath}/painel/{$core_current_controller}/{$core_current_action}/pagina/{$core_rows->currentPage()+$i}" >
											{sprintf("%01d", $core_rows->currentPage()+$i)}
										</a>
									</li>
								{/if}
							{/for}

							{* ultima pagina *}
							{if $core_rows->currentPage() <= ($core_rows->lastPage() - 4)}
								<li class="page-item">
									<a class="page-link" href="{$basePath}/painel/{$core_current_controller}/{$core_current_action}/pagina/{$core_rows->lastPage()}" >
										<i class="fa-solid fa-angles-right"></i>
									</a>
								</li>
							{/if}
							
						</ul>
					</div>
				</div>
			</div> {* footer *}


		</div>
	</div>
</div>
