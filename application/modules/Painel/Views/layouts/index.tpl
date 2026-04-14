{* page header *}
<div class="page-header d-print-none">
	<div class="container-xl">
		<div class="row g-2 align-items-center">

			<div class="col">
				<div class="page-pretitle">Users</div>
				<h2 class="page-title">List of users</h2>
			</div>

			<div class="col-auto ms-auto d-print-none">
				<div class="btn-list">

					<a href="{$this->url(['controller'=>"users", 'action'=>"form"], "painel")}" class="btn btn-primary btn btn-primary btn-icon px-0 px-sm-3">
						<i class="fa-solid fa-plus"></i>
						<span class="d-none d-sm-inline-block ps-1">Create new user</span>
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
								<th>Email</th>
							</tr>
						</thead>
						<tbody>
							{if $rows->count() == 0}
								<tr>
									<td class="text-center">No record to list</td>
								</tr>
							{/if}

							{foreach from=$rows item=row}
							<tr>
								<td>
									<a href="{$this->url(['controller'=>"users", 'action'=>"form", 'iduser'=>$row['iduser']], "painel")}">{$row['email']|escape}</a>
								</td>
							</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>

			{* card footer *}
			<div class="card-footer d-flex align-items-center">
				<p class="m-0 text-muted"></p>
				<ul class="pagination m-0 ms-auto">																																											
					<li class="page-item active">
						<a class="page-link" href="/sgl.sincore.digital/public_html/painel/parceiros/index/pagina/1">1</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>