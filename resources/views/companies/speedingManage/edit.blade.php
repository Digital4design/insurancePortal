@extends('companies.master')
@section('pageTitle','Edit Violations')
@section('content')
@section('pageCss')
<style></style>
@stop
<?php 
 // dd($speedData);
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Edit Violation</h4>
			</div>
			<div class="card-body">
					@if(Session::has('status'))
						<div class="alert alert-{{ Session::get('status') }}"> 
							<i class="ti-user"></i> {{ Session::get('message') }}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
						</div>
					@endif
					<form class="edit-form" method="POST" action="{{ url('/company/speed-management/'.Crypt::encrypt($speedData->id).'/update') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-body"> 
							<div class="row p-t-20">
								<div class="col-md-6">
									<div class="form-group  @error('speeding_start') has-danger @enderror ">
										<label class="control-label">Speeding start</label>
										<input 
											type="text" 
											class="form-control @error('speeding_start') form-control-danger @enderror " 
											id="speeding_start" 
											name="speeding_start"
											placeholder="speeding_start"
											value="{{ old('speeding_start',(isset($speedData) && !empty($speedData->speeding_start)) ? $speedData->speeding_start : '' ) }}"
										/>
                                @error('speeding_start')
                                 <small class="form-control-feedback">{{ $errors->first('speeding_start') }}</small>
                                @enderror
										
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group  @error('speeding_end') has-danger @enderror ">
										<label class="control-label">Speeding End</label>
										<input 
											type="text" 
											class="form-control @error('speeding_end') form-control-danger @enderror " 
											id="speeding_end" 
											name="speeding_end"
											placeholder="speeding_end"
											value="{{ old('speeding_end',(isset($speedData) && !empty($speedData->speeding_end)) ? $speedData->speeding_end : '' ) }}"
										/>
                                @error('speeding_end')
                                 <small class="form-control-feedback">{{ $errors->first('speeding_end') }}</small>
                                @enderror
										
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group  @error('rating') has-danger @enderror ">
										<label class="control-label">Rating</label>
										<input 
											type="text" 
											class="form-control @error('rating') form-control-danger @enderror " 
											id="rating" 
											name="rating"
											placeholder="rating"
											value="{{ old('rating',(isset($speedData) && !empty($speedData->rating)) ? $speedData->rating : '' ) }}"
										/>
										@error('rating')
											<small class="form-control-feedback">{{ $errors->first('rating') }}</small>
										@enderror
									</div>
								</div>

                                <div class="col-md-6">
									<div class="form-group  @error('speedType') has-danger @enderror ">
										<label class="control-label">Violation Type</label>
										<select id="tracker_id" class="form-control @error('speedType') form-control-danger @enderror"  name="speedType">
                                            <option value="">Select Violation Type</option>
                                            <option value="speed" {{ ( $speedData->speedType == 'speed') ? 'selected' : '' }}>speed</option>
                                            <option value="harsh" {{ ( $speedData->speedType == 'harsh') ? 'selected' : '' }}>harsh</option>
                                        </select>
										@error('speedType')
											<small class="form-control-feedback">{{ $errors->first('speedType') }}</small>
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

