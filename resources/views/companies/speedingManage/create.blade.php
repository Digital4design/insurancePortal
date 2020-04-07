@extends('companies.master')
@section('pageTitle','Create New Violation')
@section('content')
@section('pageCss')
<style></style>
@stop
<div class="row">
   <div class="col-lg-12">
      <div class="card card-outline-info">
         <div class="card-header">
            <h4 class="m-b-0 text-white">Add New Violation</h4>
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
                           <label class="control-label">Violation Count</label>
                           <select name="speedingValue" id="speedingValue" class="form-control">
                                    <option value="">Select Status speeding Value</option>
                                    @for ($i = 0; $i <= 10; $i++)
                                       <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    <!-- 
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option> 
                                    -->
                                </select>
                                @error('speedingValue')
                                 <small class="form-control-feedback">{{ $errors->first('speedingValue') }}</small>
                                @enderror
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group  @error('costValue') has-danger @enderror ">
                           <label class="control-label">Rating</label>
                           <input
                              type="text"
                              class="form-control @error('costValue')
                              form-control-danger @enderror"
                              id="costValue"
                              name="costValue"
                              placeholder="e.g: 8"
                              value="{{ old('costValue') }}"
                           />
                           @error('costValue')
                           <small class="form-control-feedback">{{ $errors->first('costValue') }}</small>
                           @enderror
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group  @error('speedType') has-danger @enderror">
                           <label class="control-label">Violation Type</label>
                           <select id="tracker_id" class="form-control @error('speedType') has-danger @enderror" name="speedType">
                              <option value="">Select Violation Type</option>
                              <option value="speed">speed</option>
                              <option value="harsh">harsh</option>
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
<script type="text/javascript"></script>
@stop
