@extends('companies.master')
@section('pageTitle', 'Profile Setting')
@section('pageCss')
@stop
@section('content')
<?php
// dd(user_data);
?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Profile</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </div>
    <!-- <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
    </div> -->
</div>

<div class="container-fluid">
    @if(Session::has('status'))
    <div class="alert alert-{{ Session::get('status') }}">
        <i class="ti-user"></i> {{ Session::get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30"> <img src="{{ asset('public/assets/admin/images/users/profile-photo.jpg') }}" class="img-circle" width="150" />
                        <h4 class="card-title m-t-10">{{ Auth::user()->name }} </h4>
                        <h6 class="card-subtitle"></h6>
                    </center>
                </div>
                <div>
                    <hr>
                </div>
                <div class="card-body">
                    <small class="text-muted">Email address </small>
                    <h6>{{ Auth::user()->email }}</h6>
                    <small class="text-muted p-t-30 db">Phone</small>
                    <h6>{{ Auth::user()->phone }}</h6>
                    <!-- <small class="text-muted p-t-30 db">Address</small>
                    <h6>71 Pilgrim Avenue Chevy Chase, MD 20815</h6>
                    <div class="map-box">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470029.1604841957!2d72.29955005258641!3d23.019996818380896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1493204785508" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>  -->
                    <!-- <small class="text-muted p-t-30 db">Social Profile</small>
                    <br />
                    <button class="btn btn-circle btn-secondary"><i class="fa fa-facebook"></i></button>
                    <button class="btn btn-circle btn-secondary"><i class="fa fa-twitter"></i></button>
                    <button class="btn btn-circle btn-secondary"><i class="fa fa-youtube"></i></button> -->
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings" role="tab">Settings</a> </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="settings" role="tabpanel">
                        <div class="card-body">
                            <form class="form-horizontal form-material" method="Post" action="{{ url('/company/profile-edit') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" placeholder="Full Name" name="user_id" class="form-control form-control-line" value="{{  $user_data['id'] }}">
                                <div class="form-group">
                                    <label class="col-md-12">Company Name</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Full Name" name="name" class="form-control form-control-line" value="{{ $errors->has('name') ? old('name') : $user_data['name'] }}">
                                    </div>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="User Email" class="form-control form-control-line" name="email" id="example-email" value="{{ $errors->has('email') ? old('email') : $user_data['email'] }}">
                                    </div>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12">Phone No</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="123 456 7890" name="phone" class="form-control form-control-line" value="{{ $errors->has('phone') ? old('phone') : $user_data['phone'] }}" />
                                    </div>
                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">About</label>
                                    <div class="col-md-12">
                                        <textarea rows="10" placeholder="About" name="info" class="form-control form-control-line">{{ $errors->has('info') ? old('info') : $user_data['info'] }}</textarea>
                                    </div>
                                    @if ($errors->has('info'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('info') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" type="submit">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
@section('pagejs')
@stop