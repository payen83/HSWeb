@extends('layouts.app')

@section('content')
   <!-- Main Container -->
            <main id="main-container">
                <!-- Page Header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                Edit User Details
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>User Management</li>
                                <li><a class="link-effect" href="adduser.html">Edit User Details</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- END Page Header -->

                <!-- Page Content -->
                <div class="content">
                    <!-- My Block -->
                    <div class="block">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <button type="button"><i class="si si-settings"></i></button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="close"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Edit User Details</h3>
                        </div>
                        <div class="block-content">
                           <!-- Page Content -->
                <div class="content content-narrow">
                    <!-- Forms Row -->
                    <div class="row">
                        <div class="col-lg-15">
                            <div class="block">
                                
                                <div class="block-content block-content-narrow">
                                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                        {{Form::open(['route' => ['editUser','id'=>$data->id],'method'=>'POST'])}}
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-username">Name</label>
                                            <div class="col-md-7">
                                              {{Form ::text('name',$data->name,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-email">Email</label>
                                            <div class="col-md-7">
                                             {{Form ::text('email',$data->email,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-password">Password</label>
                                            <div class="col-md-7">
                                            {!! Form::password("password",null,["class"=>"form-control",'rows'=>'6']) !!}
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-select2">Role</label>
                                            <div class="col-md-7">
                                              {!! Form::select("role",['Admin'=>'Admin','Agent'=>'Agent','Customer'=>'Customer'],null,["class"=>"form-control",'rows'=>'6']) !!}
                                            </div>
                                       </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-select2">Active</label>
                                            <div class="col-md-7">
                                                    {!! Form::checkbox("status",$data->status,1,null,["style"=>"width:25px;height:25px"]) !!}
                                                
                                            </div>
                                       </div>

                                        <div class="form-group">
                                            <div class="col-md-8 col-md-offset-4">
                                                <a href="{{route('viewUser')}}" <button class="btn btn-sm btn-danger" type="submit">Back</button></a>
                                                <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                            </div>
                                        </div>
                                  {{Form::close()}}
                                </div>
                            </div>
                            <!-- Bootstrap Forms Validation -->
                        </div>
                    </div>
                    <!-- END My Block -->
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
@endsection 
          
        