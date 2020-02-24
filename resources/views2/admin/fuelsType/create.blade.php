@extends('admin.master')
@section('pageTitle','Create New Fuel')
@section('content')
@section('pageCss')
<style>
</style>
@stop
<div class="row">
<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Add New Fuels</h4>
			</div>
			<div class="card-body">
				@if(Session::has('status'))
				<div class="alert alert-{{ Session::get('status') }}">
					<i class="ti-user"></i> {{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				</div>
				@endif
				<form class="edit-form" method="POST" action="{{ url('/admin/fuel-type-management/save-fuel') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="row p-t-20">
							<div class="col-md-12">
								<div class="form-group  @error('fuels_type') has-danger @enderror ">
									<label class="control-label">Fuel</label>
									<input 
                                    type="text" 
                                    class="form-control @error('fuels_type') form-control-danger @enderror" 
                                    id="fuels_type" 
                                    name="fuels_type" 
                                    placeholder="Fuel Type" 
                                    value="{{ old('fuels_type') }}" />
									@error('fuels_type')
									<small class="form-control-feedback">{{ $errors->first('fuels_type') }}</small>
									@enderror
								</div>
							</div>
							
							<div class="col-md-12">
								<div class="form-group  @error('fuels_description') has-danger @enderror ">
									<label class="control-label">Fuel Description</label>
									<textarea 
                                    class="form-control @error('fuels_description') form-control-danger @enderror" 
                                    id="fuels_description"
                                    rows="4"
                                    cols="50"  
                                    placeholder="Fuel Description" 
                                    name="fuels_description">{{ old('fuels_description') }}</textarea>
									@error('fuels_description')
									<small class="form-control-feedback">{{ $errors->first('fuels_description') }}</small>
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