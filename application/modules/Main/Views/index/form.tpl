
<form method="get" action="#">

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

						<a href="{$basePath}/main/index/list" class="btn btn-red btn-icon px-0 px-sm-3 me-0 me-sm-3">
							<i class="fa-solid fa-trash"></i>
							<span class="d-none d-sm-inline-block ps-1">Remove</span>
						</a>

						<a href="{$basePath}/main/index/list" class="btn btn-secondary btn-icon px-0 px-sm-3">
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
							<label class="form-label"> First Name </label>
							<input type="text" placeholder="Enter first name" class="form-control">
						</div>
						<div class="col-12 col-md-6 mb-3">
							<label class="form-label"> Last Name </label>
							<input type="text" placeholder="Enter last name" class="form-control">
						</div>
						<div class="col-12 col-md-6 mb-3">
							<label class="form-label"> Email </label>
							<input type="email" placeholder="Enter email address" class="form-control">
						</div>
						<div class="col-12 col-md-6 mb-3">
							<label class="form-label"> Select Subject </label>
							<select class="form-select">
								<option>Option 1</option>
								<option>Option 2</option>
								<option>Option 3</option>
								<option>Option 4</option>
							</select>
						</div>
						<div class="col-12 col-md-6 mb-3">
							<label class="form-label"> Message </label>
							<textarea placeholder="Enter your message" rows="6" class="form-control"></textarea>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>











