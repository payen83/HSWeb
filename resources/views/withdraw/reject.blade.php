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
                                <li>Withdraw</li>
                                <li><a class="link-effect" href="">Reject Withdraw Transaction </a></li>
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
                            <h3 class="block-title">Reject Withdraw Transaction</h3>
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
                                    {{Form::open(['route' => ['saveRejectWdDetails','withdrawID'=>$data->withdrawID]])}}
                                      @csrf
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-ag-email">Agent Email</label>
                                            <div class="col-md-7">
                                                 {{Form ::label('email',$data->email,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-amt">Amount Withdraw</label>
                                            <div class="col-md-7">
                                                 {{Form ::text('amount',$data->amount,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-quantity">Rejection Reason</label>
                                            <div class="col-md-7">
                                                  <div class="col-md-7">
                                                {{Form ::textarea('RejectReason',null,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <div class="col-md-8 col-md-offset-4">
                                                <a href="{{route('viewWithdrawDetails',['withdrawID'=>$data->withdrawID])}}"<button class="btn btn-sm btn-danger" type="submit">Back</button></a>
                                                <button class="btn btn-sm btn-primary" type="submit">Submit</button></a>
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