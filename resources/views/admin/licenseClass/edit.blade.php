@extends('admin.master')
@section('pageTitle','Edit License Class')
@section('content')
@section('pageCss')
<style></style>
@stop
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Edit LicenseClass : {{ (isset($user) && !empty($user->license_class)) ? $user->license_class : '' }} </h4>
			</div>
			<div class="card-body">
				@if(Session::has('status'))
				<div class="alert alert-{{ Session::get('status') }}">
					<i class="ti-user"></i> {{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				</div>
				@endif
				<form class="edit-form" method="POST" action="{{ url('/admin/license-class-management/'.Crypt::encrypt($user->id).'/update') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="row p-t-20">
						   <div class="col-md-6">
								<div class="form-group @error('country_id') has-danger @enderror">
									<label>Driver License Country</label>
									<select class="form-control @error('country_id') form-control-danger @enderror" id="country_id" placeholder="country_id" name="country_id">
										<option value="">Select Driver License Country</option>
										@foreach($country as $cont)
										<option value="{{$cont->id}}" {{ ( $cont->id == $user->country_id) ? 'selected' : '' }}>{{$cont->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('license_class') has-danger @enderror ">
									<label class="control-label">Driver License Class</label>
									<input type="text" class="form-control @error('license_class') form-control-danger @enderror " id="license_class" name="license_class" placeholder="license_class" value="{{ old('license_class',(isset($user) && !empty($user->license_class)) ? $user->license_class : '' ) }}" />
									@error('license_class')
									<small class="form-control-feedback">{{ $errors->first('license_class') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('description') has-danger @enderror ">
									<label class="control-label">Driver License Class Description</label>
									<input type="text" class="form-control @error('description') form-control-danger @enderror " id="description" name="description" placeholder="Driver License Class Description" value="{{ old('description',(isset($user) && !empty($user->description)) ? $user->description : '' ) }}" />
									@error('description')
									<small class="form-control-feedback">{{ $errors->first('description') }}</small>
									@enderror
								</div>
							</div>
							
							

							
							<!-- <div class="col-md-6">
								<div class="form-group @error('insurance_company') has-danger @enderror">
									<label>Insurance Company</label>
									<select class="form-control @error('insurance_company') form-control-danger @enderror" id="insurance_company" placeholder="insurance_company" name="insurance_company">
										<option value="A" {{ ( 'A' == $user->insurance_company) ? 'selected' : '' }}>A</option>
										<option value="B" {{ ( 'B' == $user->insurance_company) ? 'selected' : '' }}>B</option>
										<option value="C" {{ ( 'C' == $user->insurance_company) ? 'selected' : '' }}>C</option>
										<option value="D" {{ ( 'D' == $user->insurance_company) ? 'selected' : '' }}>D</option>
									</select>
								</div>
							</div> -->
							

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