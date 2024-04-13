@extends('auth.layouts')

@section('content')
    
		<!--=== Start Sidebar Menu Area ===-->		
		@include('auth.sub-files.sidebar_menu')
		<!--=== End Sidebar Menu Area ===-->

		<!--=== Start Main Content Area ===-->
		<div class="main-content-area">
			<div class="container-fluid">
				<!--=== Start Header Area ===-->				
					@include('auth.sub-files.header')
				<!--=== End Header Area ===-->

				<!--=== Start Website Overview Area ===-->
				<div class="website-overview-area">
					<div class="row justify-content-center">
						<div class="col-xxl-12 js-grid">
							<div class="row justify-content-center js-grid">
								<div class="col-lg-4 col-sm-6">
									<div class="card status-card border-0 rounded-3 mb-24 cursor-move">
										<div class="card-body p-25 text-body">
											<div class="d-flex align-items-center">
												<div class="flex-shrink-0">
													<div class="icon rounded-3">
														<i data-feather="users"></i>
													</div>
												</div>
												<div class="flex-grow-1 ms-3">
													  <span class="d-block mb-1">Total Users</span>
													<h3 class="fs-25">15,821</h3>
													<p class="fw-medium fs-13">User <span class="badge bg-success-transparent text-success mx-1"><i data-feather="trending-up" class="me-1"></i> 4.2%</span> this month</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-sm-6">
									<div class="card status-card border-0 rounded-3 mb-24 cursor-move">
										<div class="card-body p-25 text-body">
											<div class="d-flex align-items-center">
												<div class="flex-shrink-0">
													<div class="icon rounded-3">
														<i data-feather="activity"></i>
													</div>
												</div>
												<div class="flex-grow-1 ms-3">
													  <span class="d-block mb-1">Live Visitors</span>
													<h3 class="fs-25"> 30,125.00 </h3>
													<p class="fw-medium fs-13">Visitor <span class="badge bg-success-transparent text-success mx-1"><i data-feather="trending-up" class="me-1"></i> 5.0%</span> this month</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-sm-6">
									<div class="card status-card border-0 rounded-3 mb-24 cursor-move">
										<div class="card-body p-25 text-body">
											<div class="d-flex align-items-center">
												<div class="flex-shrink-0">
													<div class="icon rounded-3">
														<i data-feather="pie-chart"></i>
													</div>
												</div>
												<div class="flex-grow-1 ms-3">
													  <span class="d-block mb-1">Bounce Rate</span>
													<h3 class="fs-25"> 2,11,125 </h3>
													<p class="fw-medium fs-13">User <span class="badge bg-danger-transparent text-danger mx-1"> <i data-feather="trending-down" class="me-1"></i> 7.6%</span> this month</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card rounded-3 border-0 audience-report-card mb-24">
								<div class="card-body p-25">
									<div class="card-title d-flex align-items-center justify-content-between mb-20 pb-20 border-bottom border-color cursor-move">
										<h4 class="mb-0">Audience Report</h4>

										<select class="form-select form-control" aria-label="Default select example">
											<option selected>Today</option>
											<option value="1">This Week</option>
											<option value="2">This Month</option>
											<option value="3">This Year</option>
										</select>
									</div>

									<div id="audience_report"></div>
								</div>
							</div>

						</div>

					</div>
				</div>
				<!--=== End Website Overview Area ===-->
			</div>

			<div class="flex-grow-1"></div>

		
		</div>
        
		
        	<!--=== Start CopyRight Area ===-->		
					@include('auth.sub-files.footer')
			<!--=== End CopyRight Area ===-->
@endsection