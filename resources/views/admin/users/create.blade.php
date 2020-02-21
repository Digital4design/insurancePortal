@extends('admin.master')
@section('pageTitle','Create New User')
@section('content')
@section('pageCss')
<style>
</style>
@stop
<div class="row">
<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Add New User</h4>
			</div>
			<div class="card-body">
				@if(Session::has('status'))
				<div class="alert alert-{{ Session::get('status') }}">
					<i class="ti-user"></i> {{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				</div>
				@endif
				<form class="edit-form" method="POST" action="{{ url('/admin/user-management/save-user') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="row p-t-20">
							<div class="col-md-6">
								<div class="form-group  @error('name') has-danger @enderror ">
									<label class="control-label">First Name</label>
									<input type="text" class="form-control @error('firstName') form-control-danger @enderror " id="firstName" name="firstName" placeholder="First Name" value="{{ old('firstName') }}" />
									@error('firstName')
									<small class="form-control-feedback">{{ $errors->first('firstName') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('name') has-danger @enderror ">
									<label class="control-label">Last Name</label>
									<input type="text" class="form-control @error('lastName') form-control-danger @enderror " id="lastName" name="lastName" placeholder="last Name" value="{{ old('lastName') }}" />
									@error('lastName')
									<small class="form-control-feedback">{{ $errors->first('lastName') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('name') has-danger @enderror ">
									<label class="control-label">User Name</label>
									<input type="text" class="form-control @error('name') form-control-danger @enderror " id="name" name="name" placeholder="User Name" value="{{ old('name') }}" />
									@error('name')
									<small class="form-control-feedback">{{ $errors->first('name') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('email') has-danger @enderror ">
									<label class="control-label">Email </label>
									<input type="email" class="form-control @error('email') form-control-danger @enderror " id="email" name="email" placeholder="User Email" value="{{ old('email') }}" />
									@error('email')
									<small class="form-control-feedback">{{ $errors->first('email') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('phone') has-danger @enderror ">
									<label class="control-label">Phone </label>
									<input type="text" class="form-control @error('phone') form-control-danger @enderror " id="phone" name="phone" placeholder="phone" value="{{ old('phone') }}" />
									@error('phone')
									<small class="form-control-feedback">{{ $errors->first('phone') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('is_active') has-danger @enderror ">
									<label class="control-label">Status</label>
									<div class="m-b-30">
										<input type="checkbox" class="js-switch" data-color="#0ca302" data-secondary-color="#f62d51" data-size="large" name="is_active" checked />
									</div>
									@error('is_active')
									<small class="form-control-feedback">{{ $errors->first('is_active') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('addressLine') has-danger @enderror ">
									<label class="control-label">Address</label>
									<textarea class="form-control   @error('addressLine') form-control-danger @enderror  " id="addressLine" placeholder="Address" name="addressLine">{{ old('addressLine') }}</textarea>
									@error('addressLine')
									<small class="form-control-feedback">{{ $errors->first('addressLine') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('addressCountry') has-danger @enderror">
									<label>Driver License Country</label>
									<select class="form-control @error('addressCountry') form-control-danger @enderror" id="addressCountry" placeholder="addressCountry" name="addressCountry" onChange="getCountyLicenseClass(this);">
										<option value="">Select Driver License Country</option>
										@foreach($country as $cont)
											<option value="{{$cont->id}}">{{$cont->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('driver_license_id') has-danger @enderror ">
									<label class="control-label">Driver License ID</label>
									<input type="text" class="form-control @error('driver_license_id') form-control-danger @enderror " id="driver_license_id" name="driver_license_id" placeholder="Driver License ID" value="{{ old('driver_license_id') }}" />
									@error('driver_license_id')
									<small class="form-control-feedback">{{ $errors->first('driver_license_id') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('driver_license_class') has-danger @enderror">
									<label>Driver License Country</label>
									<select multiple class="form-control @error('driver_license_class') form-control-danger @enderror" id="driver_license_class" placeholder="driver_license_class" name="driver_license_class[]">
									<option value=""> --Select Class-- </option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('driver_license_expiry') has-danger @enderror">
									<label class="control-label">Driver License Expiry</label>
									<input type="date" class="form-control @error('driver_license_expiry') form-control-danger @enderror " id="driver_license_expiry" name="driver_license_expiry" placeholder="dd/mm/yyyy" value="{{ old('driver_license_expiry') }}" data-dtp="dtp_MHyIp" />
									@error('driver_license_expiry')
									<small class="form-control-feedback">{{ $errors->first('driver_license_expiry') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('national_id') has-danger @enderror ">
									<label class="control-label">National ID</label>
									<input type="text" class="form-control @error('national_id') form-control-danger @enderror " id="national_id" name="national_id" placeholder="National ID" value="{{ old('national_id') }}" />
									@error('national_id')
									<small class="form-control-feedback">{{ $errors->first('national_id') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('insurance_company') has-danger @enderror">
									<label>Insurance Company</label>
									<select class="form-control @error('insurance_company') form-control-danger @enderror" id="insurance_company" placeholder="insurance_company" name="insurance_company">
										<option value="">Select Insurance Company</option>
										@foreach($company as $comp)
										<option value="{{$comp->id}}">{{$comp->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('ontrac_username') has-danger @enderror ">
									<label class="control-label">Ontrac Username</label>
									<input type="text" class="form-control @error('ontrac_username') form-control-danger @enderror " id="ontrac_username" name="ontrac_username" placeholder="Ontrac Username" value="{{ old('ontrac_username') }}" />
									@error('ontrac_username')
									<small class="form-control-feedback">{{ $errors->first('ontrac_username') }}</small>
									@enderror
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-info waves-effect waves-light  cus-submit save-btn"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
@stop
@section('pagejs')
<script type="text/javascript">
	function getCountyLicenseClass(obj){
		let countryId = $(obj).val();
		$.ajax({
			url:'{{ url("/request/get-country-license-class") }}'+'/'+countryId,
			type: 'GET',
			success:function(rtnData){
				 console.log(rtnData);
				 if(rtnData.status == 'success'){
					 var classList	=	rtnData.list;
					 let options = "<option value=''> --Select Options-- </option>";
					 $.each(classList,function(key, value){
						 options +='<option value=' + value.id + '>' + value.license_class + '</option>';
					});
					$('#driver_license_class').html(options);
					}else{
						console.log(rtnData.msg);
					}
				}
		}); 
	}
</script>
@stop