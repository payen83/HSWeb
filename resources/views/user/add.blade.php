@extends('layouts.app')

@section('content')
            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>User Management</li>
                                <li><a class="link-effect" href="#">Add User</a></li>
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
                            <h3 class="block-title">Add User Details</h3>
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
                                    {{Form::open(array('route' => 'addUser','method'=>'POST'))}}
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-username">Name <span class="text-danger">*</span></label>
                                            <div class="col-md-7">
                                                <!--<input class="form-control" type="text" id="val-username" name="val-username" placeholder="Enter your name">-->
                                                {{Form ::text('name',null,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-email">Email <span class="text-danger">*</span></label>
                                            <div class="col-md-7">
                                                <!--<input class="form-control" type="text" id="val-email" name="val-email" placeholder="Enter your valid email">-->
                                                {{Form ::text('email',null,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-password">Password <span class="text-danger">*</span></label>
                                            <div class="col-md-7">
                                                <!--<input class="form-control" type="password" id="val-password" name="val-password" placeholder="Choose a good pasword">-->
                                                 {!! Form::password("password",null,["class"=>"form-control",'rows'=>'6']) !!}
                                            </div>
                                        </div>
                                      
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-select2">Role</label>
                                            <div class="col-md-7">
                                                <!--<select class="js-select2 form-control" id="role" name="val-select2" style="width: 100%;" data-placeholder="Choose a role">
                                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin 
                                                    <option value="1">1-Admin</option>
                                                    <option value="2">2-Agent</option>
                                                    <option value="3">3-Customer</option>
                                                    
                                                </select>-->
                                                 {!! Form::select("role",['Admin'=>'Admin','Agent'=>'Agent','Customer'=>'Customer'],null,["class"=>"form-control"]) !!}
                                            </div>
                                       </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-select2">Active</label>
                                            <div class="col-md-7">
                                                   {!! Form::checkbox("status",1,null,["style"=>"width:25px;height:25px"]) !!}
                                                
                                            </div>
                                       </div>


                                        <div class="form-group">
                                            <div class="col-md-8 col-md-offset-4">
                                                <a href="{{route('viewUser')}}"<button class="btn btn-sm btn-danger" type="submit">Back</button></a>
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