@extends('companies.master')
@section('pageTitle','View User')
@section('content')
@section('pageCss')
<style></style>
@stop
<?php
//     foreach ($employeeData['list'] as $key => $value) {
//         dd($value['first_name']);
//     }
// dd($employeeData['list']);
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">View User : {{ (isset($user) && !empty($user->name)) ? $user->name : '' }} </h4>
			</div>
			<div class="card-body">
					@if(Session::has('status'))
						<div class="alert alert-{{ Session::get('status') }}">
							<i class="ti-user"></i> {{ Session::get('message') }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
						</div>
					@endif
					<div class="form-body">
							<div class="row p-t-20">
                                <div class="col-md-6">
									<div class="form-group  @error('firstName') has-danger @enderror ">
										<label class="control-label">First Name</label>
										<h6>{{$user->firstName}}</h6>
									</div>
								</div>
                                <div class="col-md-6">
									<div class="form-group  @error('lastName') has-danger @enderror ">
										<label class="control-label">Last Name</label>
										<h6>{{$user->lastName}}</h6>
									</div>
								</div>
                                <div class="col-md-6">
									<div class="form-group  @error('name') has-danger @enderror ">
										<label class="control-label">User Name</label>
										<h6>{{$user->name}}</h6>
									</div>
								</div>
                                <div class="col-md-6">
									<div class="form-group  @error('email') has-danger @enderror ">
										<label class="control-label">Email </label>
										<h6>{{$user->email}}</h6>
									</div>
								</div>
                                <div class="col-md-6">
									<div class="form-group  @error('phone') has-danger @enderror ">
										<label class="control-label">Phone </label>
										<h6>{{$user->phone}}</h6>
									</div>
								</div>


								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Address</label>
										<h6>{{$user->addressLine}}</h6>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Driver License Country</label>
										<h6> {{ $country[0]['name'] }} </h6>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Driver License Class</label>
										<h6>{{ $licenseClass[0]['license_class'] }}
										</h6>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Driver License Id</label>
										<h6>{{$user->driver_license_id}}</h6>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Driver License Expiry</label>
										<h6><?php echo $newDate = date("d-m-Y", strtotime($user->driver_license_expiry)); ?></h6>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">National Id</label>
										<h6>{{$user->national_id}}</h6>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Ontrack Username</label>
										<h6>{{$user->ontrac_username}}</h6>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group  @error('info') has-danger @enderror ">
										<label class="control-label">Notes</label>
										<h6>{{$user->info}}</h6>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<h4 class="m-b-0 text-white" style="background: #1976d2;border-color: #1976d2">User : Permission </h4>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
									@foreach($permission as $per)
										<div class="demo-checkbox">
											<input type="checkbox" id="basic_checkbox_{{$per->id}}" class="filled-in" {{ ($per->accept_status==1) ? 'checked':'' }}  disabled>
											<label for="basic_checkbox_{{$per->id}}">{{$per->permissions_name}}</label>
										</div>
									@endforeach
									</div>
								</div>




								<div class="col-md-12">
									<div class="form-group">
										<h4 class="m-b-0 text-white" style="background: #1976d2;border-color: #1976d2">User : Employee List </h4>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
									@forelse($employeeData as $employee)
										<div class="demo-checkbox">
											<label for="basic_checkbox_{{$employee['id']}}">{{ $employee['first_name'] }} {{ $employee['middle_name'] }} {{ $employee['last_name'] }}</label>
										</div>
									@empty
									    No employee data
									@endforelse
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<h4 class="m-b-0 text-white" style="background: #1976d2;border-color: #1976d2">User : Tracker </h4>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
									@forelse($trackerData as $tracker)
										<div class="demo-checkbox">
											<label class="tracker" data-id="{{$tracker['id']}}" for="basic_checkbox_{{$tracker['id']}}">{{ $tracker['label'] }}</label>
										</div>
									@empty
									     No tracker data
									@endforelse
									</div>
								</div>
								<input type="hidden" name="user_id" value="{{$user->id}}">
								<div id="lastTrackerData"></div>
							</div>
						</div>

						
				</div>
	      	</div>
	    </div>

    </div>
</div>
@stop
@section('pagejs')
<script type="text/javascript">
	$(".tracker").click(function(){
		var trackerId = $(this).attr('data-id');
		$.ajax({
			url:'{{ url("/company/user-management/get-tracker-data") }}'+'/'+trackerId,
			type: 'GET',
			success:function(rtnData){
				console.log(rtnData.content);
				$('#lastTrackerData').html(rtnData.content);
			}
		});

	});
</script>
@stop

