
<form method="post" action="{$basePath}/main/users/form{if $row}/iduser/{$row['iduser']|escape}{/if}">

	{* page header *}
	<div class="page-header d-print-none">
		<div class="container-xl">
			<div class="row g-2 align-items-center">

				<div class="col">
					<div class="page-pretitle">Users</div>
					{if $row}
						<h2 class="page-title">Edit user {$user['email']|escape}</h2>
					{else}
						<h2 class="page-title">Add new user</h2>
					{/if}
				</div>

				<div class="col-auto ms-auto d-print-none">
					<div class="btn-list">

						{if $row}
						<a href="{$basePath}/main/users/delete/iduser/{$row['iduser']|escape}" class="btn btn-red btn-icon px-0 px-sm-3 me-0 me-sm-3 pmp-delete-confirm">
							<i class="fa-solid fa-trash"></i>
							<span class="d-none d-sm-inline-block ps-1">Remove</span>
						</a>
						{/if}

						<a href="{$basePath}/main/users" class="btn btn-secondary btn-icon px-0 px-sm-3">
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
						<div class="col-12 col-md-6 mb-3">
							<label class="form-label"> Email </label>
							<input type="email" name="email" value="{$row['email']|default:""|escape}" placeholder="Enter email address" class="form-control">
						</div>
						<div class="col-12 col-md-6 mb-3">
							<label class="form-label"> Password </label>
							<input type="password" name="password" placeholder="{if $row}Leave blank to not change{else}Enter the user password{/if}" class="form-control">
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>











