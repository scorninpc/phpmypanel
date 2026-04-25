{* verifica o modo do form *}
{assign var=core_form_mode value="insert"}
{if $core_row[$core_model->getPrimaryKey()]|default:0 > 0}
	{assign var=core_form_mode value="update"}
{/if}


<form method="post" action="{$this->url(['controller'=>$core_funcionalidade['controlador'], 'action'=>"form", $core_model->getPrimaryKey()=>$core_row[$core_model->getPrimaryKey()]|default:0], "painel")}" enctype="multipart/form-data">

	{* page header *}
	<div class="page-header d-print-none">
		<div class="container-xl">
			<div class="row g-2 align-items-center">

				<div class="col">
					<div class="page-pretitle">{$core_funcionalidade['nome']|escape}</div>
					{if $core_form_mode == "update"}
						<h2 class="page-title">Editar: {$core_row['nome']|escape}</h2>
					{else}
						<h2 class="page-title">Novo cadastro</h2>
					{/if}
				</div>

				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">

						{if $core_form_mode == "update"}
						<a href="{$this->url(['controller'=>$core_funcionalidade['controlador'], 'action'=>"delete", $core_model->getPrimaryKey()=>$core_row[$core_model->getPrimaryKey()]|default:0], "painel")}" class="btn btn-red btn-icon px-0 px-sm-3 me-0 me-sm-3 core-delete-confirm">
							<i class="fa-solid fa-trash"></i>
							<span class="d-none d-sm-inline-block ps-1">Remover</span>
						</a>
						{/if}

						<a href="{$this->url(['controller'=>$core_funcionalidade['controlador'], 'action'=>"index"], "painel")}" class="btn btn-secondary btn-icon px-0 px-sm-3">
							<i class="fa-solid fa-list-ul"></i>
							<span class="d-none d-sm-inline-block ps-1">Voltar</span>
						</a>

						<button type="submit" class="btn btn-primary btn-icon px-0 px-sm-3">
							<i class="fa-regular fa-paper-plane"></i>
							<span class="d-none d-sm-inline-block ps-1">{if $core_form_mode == "update"}Atualizar{else}Inserir{/if}</span>
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

							{* verifica a visilibidade do campo *}
							{if $core_model->getVisibility($column['name'], $core_form_mode)}
								{$this->formField($core_model, $column['name'])}
							{/if}

						{/foreach}

					</div>

				</div>
			</div>
		</div>
	</div>
</form>











