@extends('admin.master')
@section('pageTitle','Create Driver License Country')
@section('content')
@section('pageCss')
<style>
</style>
@stop
<div class="row">
	<?php
	// dd($country);
	?>
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Add Driver License Country</h4>
			</div>
			<div class="card-body">
				@if(Session::has('status'))
				<div class="alert alert-{{ Session::get('status') }}">
					<i class="ti-user"></i> {{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				</div>
				@endif
				<?php //dd($country);?>
				<form class="edit-form" method="POST" action="{{ url('/admin/license-class-management/save-license') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="row p-t-20">
							<div class="col-md-6">
								<div class="form-group @error('country_id') has-danger @enderror">
									<label>Driver License Country</label>
										<select class="form-control @error('country_id') form-control-danger @enderror" id="country_id"  name="country_id">
											<option value="">Select Driver License Country</option>
												@foreach($country as $cont)
												<option value="{{ $cont['id'] }}">{{$cont['name']}}</option>
												@endforeach
										</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('driver_license_class') has-danger @enderror">
									<label>Driver License Country</label>
									<input type="text" class="form-control @error('license_class') form-control-danger @enderror " id="license_class" name="license_class" placeholder="license class" value="{{ old('license_class') }}" />
									@error('license_class')
									<small class="form-control-feedback">{{ $errors->first('license_class') }}</small>
									@enderror
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group @error('description') has-danger @enderror">
									<label>Driver License Country Description</label>
									<input type="text" class="form-control @error('description') form-control-danger @enderror " id="description" name="description" placeholder="Driver License Class Description" value="{{ old('description') }}" />
									@error('description')
									<small class="form-control-feedback">{{ $errors->first('description') }}</small>
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