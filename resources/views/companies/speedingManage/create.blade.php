@extends('companies.master')
@section('pageTitle','Create New Speed')
@section('content')
@section('pageCss')
<style>
</style>
@stop
<div class="row">
<div class="col-lg-12">
		<div class="card card-outline-info">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Add New Speed</h4>
			</div>
			<div class="card-body">
				@if(Session::has('status'))
				<div class="alert alert-{{ Session::get('status') }}">
					<i class="ti-user"></i> {{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
				</div>
				@endif
				<form class="edit-form" method="POST" action="{{ url('/company/speed-management/save-speed') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
                    
					<div class="form-body">
						<div class="row p-t-20">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
							<div class="col-md-6">
								<div class="form-group  @error('speedingValue') has-danger @enderror ">
									<label class="control-label">Speeding Value</label>
									<input 
                                    type="text" 
                                    class="form-control @error('speedingValue') 
                                    form-control-danger @enderror " 
                                    id="speedingValue" 
                                    name="speedingValue" 
                                    placeholder="Speeding Value" 
                                    value="{{ old('speedingValue') }}" 
                                    />
									@error('speedingValue')
									<small class="form-control-feedback">{{ $errors->first('speedingValue') }}</small>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group  @error('costValue') has-danger @enderror ">
									<label class="control-label">Cost Value</label>
									<input 
                                    type="text" 
                                    class="form-control @error('costValue') 
                                    form-control-danger @enderror" 
                                    id="costValue" 
                                    name="costValue" 
                                    placeholder="Cost Value" 
                                    value="{{ old('costValue') }}" 
                                    />
									@error('costValue')
									<small class="form-control-feedback">{{ $errors->first('costValue') }}</small>
									@enderror
								</div>
							</div>
                            <div class="col-md-6">
								<div class="form-group  @error('speedType') has-danger @enderror ">
									<label class="control-label">Speed Type</label>
									<select id="tracker_id" class="form-control " name="speedType">
                                            <option value="">Select Speed</option>
                                            <option value="speed">speed</option>
                                            <option value="harsh" selected="">harsh</option>
                                        </select>
									@error('speedType')
									<small class="form-control-feedback">{{ $errors->first('speedType') }}</small>
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