@extends('admin.master')
@section('pageTitle','Edit Vehicle')
@section('content')
@section('pageCss')
<style></style>
@stop
<?php // dd($user); ?>
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Edit Vehicle : {{ (isset($user) && !empty($user->vehicles_type)) ? $user->vehicles_type : '' }} </h4>
			</div>
			<div class="card-body">
				@if(Session::has('status'))
				<div class="alert alert-{{ Session::get('status') }}">
					<i class="ti-user"></i> {{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				</div>
				@endif
				<form class="edit-form" method="POST" action="{{ url('/admin/vehicle-type-management/'.Crypt::encrypt($user->id).'/update') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="row p-t-20">
						   
							<div class="col-md-12">
								<div class="form-group  @error('vehicles_type') has-danger @enderror ">
									<label class="control-label">Vehicles Type</label>
									<input 
                                    type="text" 
                                    class="form-control @error('vehicles_type') form-control-danger @enderror " 
                                    id="vehicles_type" 
                                    name="vehicles_type" 
                                    placeholder="Vehicles Type" 
                                    value="{{ old('vehicles_type',(isset($user) && !empty($user->vehicles_type)) ? $user->vehicles_type : '' ) }}" />
									@error('vehicles_type')
									    <small class="form-control-feedback">{{ $errors->first('vehicles_type') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group  @error('vehicles_description') has-danger @enderror ">
									<label class="control-label">Vehicles Description</label>
                                    <textarea 
                                        class="form-control  @error('vehicles_description') form-control-danger @enderror" 
                                        id="vehicles_description"
                                        rows="4" 
                                        cols="50" 
                                        name="vehicles_description">{{ old('vehicles_description',(isset($user) && !empty($user->vehicles_description)) ? $user->vehicles_description : '' ) }}</textarea>
                                    @error('vehicles_description')
									    <small class="form-control-feedback">{{ $errors->first('vehicles_description') }}</small>
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