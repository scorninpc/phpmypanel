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
					<table class="table table-vcenter card-table table-striped">
						<thead>
							<tr>
								<th>Email</th>
								<th class="w-1"></th>
							</tr>
						</thead>
						<tbody>
							{if $rows->count() == 0}
								<tr>
									<td colspan="2" class="text-center">No record to list</td>
								</tr>
							{/if}

							{foreach from=$rows item=row}
							<tr>
								<td>{$row['email']|escape}</td>
								<td>
									<a href="{$this->url(['controller'=>"users", 'action'=>"form", 'iduser'=>$row['iduser']], "painel")}">Edit</a>
								</td>
							</tr>
							{/foreach}
						</tbody>
					</table>
				</div>


			</div>
		</div>
	</div>
</div>