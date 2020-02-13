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
				<form class="edit-form" method="POST" action="{{ url('/admin/fuel-type-management/'.Crypt::encrypt($user->id).'/update') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="row p-t-20">
						   
							<div class="col-md-12">
								<div class="form-group  @error('fuels_type') has-danger @enderror ">
									<label class="control-label">Fuel Type</label>
									<input 
                                    type="text" 
                                    class="form-control @error('fuels_type') form-control-danger @enderror " 
                                    id="fuels_type" 
                                    name="fuels_type" 
                                    placeholder="Fuel Type" 
                                    value="{{ old('fuels_type',(isset($user) && !empty($user->fuels_type)) ? $user->fuels_type : '' ) }}" />
									@error('fuels_type')
									    <small class="form-control-feedback">{{ $errors->first('fuels_type') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group  @error('fuels_description') has-danger @enderror ">
									<label class="control-label">Fuel Description</label>
                                    <textarea 
                                        class="form-control  @error('fuels_description') form-control-danger @enderror" 
                                        id="fuels_description"
                                        rows="4" 
                                        cols="50" 
                                        name="fuels_description">{{ old('fuels_description',(isset($user) && !empty($user->fuels_description)) ? $user->fuels_description : '' ) }}</textarea>
                                    @error('fuels_description')
									    <small class="form-control-feedback">{{ $errors->first('fuels_description') }}</small>
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