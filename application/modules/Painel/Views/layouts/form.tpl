
<form method="post" action="{$this->url(['controller'=>"users", 'action'=>"form", 'iduser'=>$row['iduser']|default:0], "painel")}">

	{* page header *}
	<div class="page-header d-print-none">
		<div class="container-xl">
			<div class="row g-2 align-items-center">

				<div class="col">
					<div class="page-pretitle">{$core_funcionalidade['nome']|escape}</div>
					{if $row}
						<h2 class="page-title">Editando {$core_funcionalidade['nome']|escape}</h2>
					{else}
						<h2 class="page-title">Adicionando {$core_funcionalidade['nome']|escape}</h2>
					{/if}
				</div>

				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">

						{if $row}
						<a href="{$this->url(['controller'=>"users", 'action'=>"delete", 'iduser'=>$row['iduser']|default:0], "painel")}" class="btn btn-red btn-icon px-0 px-sm-3 me-0 me-sm-3 pmp-delete-confirm">
							<i class="fa-solid fa-trash"></i>
							<span class="d-none d-sm-inline-block ps-1">Remove</span>
						</a>
						{/if}

						<a href="{$this->url(['controller'=>"users", 'action'=>"index"], "painel")}" class="btn btn-secondary btn-icon px-0 px-sm-3">
							<i class="fa-solid fa-list-ul"></i>
							<span class="d-none d-sm-inline-block ps-1">Back to list</span>
						</a>

						<button type="submit" class="btn btn-primary btn-icon px-0 px-sm-3">
							<i class="fa-regular fa-paper-plane"></i>
							<span class="d-none d-sm-inline-block ps-1">Submit</span>
						</button>

					</div>
				</div>
			</div>
		</div>
	</div>


	{* page body *}
	<div class="page-body">
		<div class="container-xl">
			<div class="card">
				<div class="card-body">

					{* real content *}
					<div class="row">

						{* percorre as colunas do model *}
						{foreach from=$core_model->getColumns() item=column}
							<div class="col-12 col-md-6 mb-3">
								<label class="form-label"> {$column['description']} </label>
								<input type="email" name="email" value="{$row['email']|default:""|escape}" placeholder="{$column['long_description']}" class="form-control">
							</div>
						{/foreach}

					</div>

				</div>
			</div>
		</div>
	</div>
</form>











