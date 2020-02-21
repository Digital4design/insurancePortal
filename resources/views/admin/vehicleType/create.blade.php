@extends('admin.master')
@section('pageTitle','Create New Vehicle')
@section('content')
@section('pageCss')
<style>
</style>
@stop
<div class="row">
<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Add New Vehicle</h4>
			</div>
			<div class="card-body">
				@if(Session::has('status'))
				<div class="alert alert-{{ Session::get('status') }}">
					<i class="ti-user"></i> {{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				</div>
				@endif
				<form class="edit-form" method="POST" action="{{ url('/admin/vehicle-type-management/save-vehicle') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="row p-t-20">
							<div class="col-md-12">
								<div class="form-group  @error('vehicles_type') has-danger @enderror ">
									<label class="control-label">Vehicles</label>
									<input 
                                    type="text" 
                                    class="form-control @error('vehicles_type') form-control-danger @enderror" 
                                    id="vehicles_type" 
                                    name="vehicles_type" 
                                    placeholder="Vehicles Type" 
                                    value="{{ old('vehicles_type') }}" />
									@error('vehicles_type')
									<small class="form-control-feedback">{{ $errors->first('vehicles_type') }}</small>
									@enderror
								</div>
							</div>
							
							<div class="col-md-12">
								<div class="form-group  @error('vehicles_description') has-danger @enderror ">
									<label class="control-label">Vehicles Description</label>
									<textarea 
                                    class="form-control @error('vehicles_description') form-control-danger @enderror" 
                                    id="vehicles_description"
                                    rows="4"
                                    cols="50"  
                                    placeholder="Vehicles Description" 
                                    name="vehicles_description">{{ old('vehicles_description') }}</textarea>
									@error('vehicles_description')
									<small class="form-control-feedback">{{ $errors->first('vehicles_description') }}</small>
									@enderror
								</div>
							</div>							
						</div>
					</div>
					<div class="form-actions">
						<button 
							type="submit" 
							class="btn btn-info waves-effect waves-light cus-submit save-btn">
							<i class="fa fa-save" aria-hidden="true"></i> 
							Save
						</button>
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