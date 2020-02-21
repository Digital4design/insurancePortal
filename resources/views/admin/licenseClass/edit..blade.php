@extends('admin.master')
@section('pageTitle','Edit User')
@section('content')
@section('pageCss')
<style></style>
@stop
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Edit User : {{ (isset($user) && !empty($user->name)) ? $user->name : '' }} </h4>
			</div>
			<div class="card-body">
				@if(Session::has('status'))
				<div class="alert alert-{{ Session::get('status') }}">
					<i class="ti-user"></i> {{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				</div>
				@endif
				<form class="edit-form" method="POST" action="{{ url('/admin/user-management/'.Crypt::encrypt($user->id).'/update') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="row p-t-20">
							

							

							

							
							<div class="col-md-6">
								<div class="form-group  @error('is_active') has-danger @enderror ">
									<label class="control-label">Status</label>
									<div class="m-b-30">
										<input type="checkbox" class="js-switch" data-color="#0ca302" data-secondary-color="#f62d51" data-size="large" <?php echo  $user->is_active == '1'  ? 'checked' : '';  ?> name="is_active" />
									</div>
									@error('is_active')
									<small class="form-control-feedback">{{ $errors->first('is_active') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('addressLine') has-danger @enderror ">
									<label class="control-label">Address</label>
									<textarea class="form-control   @error('addressLine') form-control-danger @enderror  " id="addressLine" name="addressLine">{{ old('addressLine',(isset($user) && !empty($user->addressLine)) ? $user->addressLine : '' ) }}</textarea>
									@error('addressLine')
									<small class="form-control-feedback">{{ $errors->first('addressLine') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('addressCountry') has-danger @enderror">
									<label>Driver License Country</label>
									<select class="form-control @error('addressCountry') form-control-danger @enderror" id="addressCountry" placeholder="addressCountry" name="addressCountry">
										<option value="">Select Driver License Country</option>
										@foreach($country as $cont)
										<option value="{{$cont->name}}" {{ ( $cont->name == $user->addressCountry) ? 'selected' : '' }}>{{$cont->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('driver_license_id') has-danger @enderror ">
									<label class="control-label">Driver License ID</label>
									<input type="text" class="form-control @error('driver_license_id') form-control-danger @enderror " id="driver_license_id" name="driver_license_id" placeholder="Driver License ID" value="{{ old('driver_license_id',(isset($user) && !empty($user->driver_license_id)) ? $user->driver_license_id : '' ) }}" />
									@error('driver_license_id')
									<small class="form-control-feedback">{{ $errors->first('driver_license_id') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('driver_license_class') has-danger @enderror">
									<label>Driver License Country</label>
									<select class="form-control @error('driver_license_class') form-control-danger @enderror" id="driver_license_class" placeholder="driver_license_class" name="driver_license_class">
										<option value="A" {{ ( 'A' == $user->driver_license_class) ? 'selected' : '' }}>A</option>
										<option value="B" {{ ( 'B' == $user->driver_license_class) ? 'selected' : '' }}>B</option>
										<option value="C" {{ ( 'C' == $user->driver_license_class) ? 'selected' : '' }}>C</option>
										<option value="D" {{ ( 'D' == $user->driver_license_class) ? 'selected' : '' }}>D</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('driver_license_expiry') has-danger @enderror ">
									<label class="control-label">Driver License Expiry</label>
									<input type="date" class="form-control @error('driver_license_expiry') form-control-danger @enderror " id="driver_license_expiry" name="driver_license_expiry" placeholder="dd/mm/yyyy" value="{{ old('driver_license_expiry',(isset($user) && !empty($user->driver_license_expiry)) ? $user->driver_license_expiry : '' ) }}" />
									@error('driver_license_expiry')
									<small class="form-control-feedback">{{ $errors->first('driver_license_expiry') }}</small>
									@enderror
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group  @error('national_id') has-danger @enderror ">
									<label class="control-label">National ID</label>
									<input type="text" class="form-control @error('national_id') form-control-danger @enderror " id="national_id" name="national_id" placeholder="National ID" value="{{ old('national_id',(isset($user) && !empty($user->national_id)) ? $user->national_id : '' ) }}" />
									@error('national_id')
									<small class="form-control-feedback">{{ $errors->first('national_id') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('insurance_company') has-danger @enderror">
									<label>Insurance Company</label>
									<select class="form-control @error('insurance_company') form-control-danger @enderror" id="insurance_company" placeholder="insurance_company" name="insurance_company">
										<option value="A" {{ ( 'A' == $user->insurance_company) ? 'selected' : '' }}>A</option>
										<option value="B" {{ ( 'B' == $user->insurance_company) ? 'selected' : '' }}>B</option>
										<option value="C" {{ ( 'C' == $user->insurance_company) ? 'selected' : '' }}>C</option>
										<option value="D" {{ ( 'D' == $user->insurance_company) ? 'selected' : '' }}>D</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('ontrac_username') has-danger @enderror ">
									<label class="control-label">Ontrac Username</label>
									<input type="text" class="form-control @error('ontrac_username') form-control-danger @enderror " id="ontrac_username" name="ontrac_username" placeholder="Ontrac Username" value="{{ old('ontrac_username',(isset($user) && !empty($user->ontrac_username)) ? $user->ontrac_username : '' ) }}" />
									@error('ontrac_username')
									<small class="form-control-feedback">{{ $errors->first('ontrac_username') }}</small>
									@enderror
								</div>
							</div>

						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-info waves-effect waves-light  cus-submit save-btn"><i class="fa fa-upload" aria-hidden="true"></i> Update</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
</div>

@stop