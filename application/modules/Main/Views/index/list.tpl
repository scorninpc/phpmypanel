{* page header *}
<div class="page-header d-print-none">
	<div class="container-xl">
		<div class="row g-2 align-items-center">

			<div class="col">
				<div class="page-pretitle">Examples</div>
				<h2 class="page-title">Admin Panel List</h2>
			</div>

			<div class="col-auto ms-auto d-print-none">
				<div class="btn-list">

					<a href="{$basePath}/main/index/form" class="btn btn-primary btn btn-primary btn-icon px-0 px-sm-3">
						<i class="fa-solid fa-plus"></i>
						<span class="d-none d-sm-inline-block ps-1">Create new data</span>
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
								<th>Name</th>
								<th>Title</th>
								<th>Email</th>
								<th>Role</th>
								<th class="w-1"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Maryjo Lebarree</td>
								<td class="text-secondary">Civil Engineer, Product Management</td>
								<td class="text-secondary"><a href="#" class="text-reset">mlebarree5@unc.edu</a></td>
								<td class="text-secondary">User</td>
								<td>
									<a href="{$basePath}/main/index/form">Edit</a>
								</td>
							</tr>
							<tr>
								<td>Egan Poetz</td>
								<td class="text-secondary">Research Nurse, Engineering</td>
								<td class="text-secondary"><a href="#" class="text-reset">epoetz6@free.fr</a></td>
								<td class="text-secondary">User</td>
								<td>
									<a href="{$basePath}/main/index/form">Edit</a>
								</td>
							</tr>
							<tr>
								<td>Kellie Skingley</td>
								<td class="text-secondary">Teacher, Services</td>
								<td class="text-secondary"><a href="#" class="text-reset">kskingley7@columbia.edu</a></td>
								<td class="text-secondary">User</td>
								<td>
									<a href="{$basePath}/main/index/form">Edit</a>
								</td>
							</tr>
							<tr>
								<td>Christabel Charlwood</td>
								<td class="text-secondary">Tax Accountant, Engineering</td>
								<td class="text-secondary"><a href="#" class="text-reset">ccharlwood8@nifty.com</a></td>
								<td class="text-secondary">Owner</td>
								<td>
									<a href="{$basePath}/main/index/form">Edit</a>
								</td>
							</tr>
							<tr>
								<td>Haskel Shelper</td>
								<td class="text-secondary">Staff Scientist, Legal</td>
								<td class="text-secondary"><a href="#" class="text-reset">hshelper9@woothemes.com</a></td>
								<td class="text-secondary">User</td>
								<td>
									<a href="{$basePath}/main/index/form">Edit</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>


			</div>
		</div>
	</div>
</div>











