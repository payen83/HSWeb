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
                                <li><a class="link-effect" href="">Withdraw Transaction Details</a></li>
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
                            
                            <h3 class="block-title">Withdraw Transaction Details</h3>
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
                                    {{Form::open(['route' => ['saveWithdrawDetails','withdrawID'=>$data->withdrawID],'method'=>'POST','enctype' => 'multipart/form-data'])}}
                                    @csrf
                                       
                                                 {{Form ::hidden('withdrawID',$data->withdrawID,['class'=>'form-control','rows'=>'6'])}}
                                           
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-ag-email">Agent Name</label>
                                            <div class="col-md-7">
                                                <!--<input class="form-control" type="text" id="val-ag-email" name="val-ag-email" >-->
                                                 {{Form ::label('name',$data->name,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-ag-email">Agent Email</label>
                                            <div class="col-md-7">
                                                <!--<input class="form-control" type="text" id="val-ag-email" name="val-ag-email" >-->
                                                 {{Form ::label('email',$data->email,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-amt">Amount Withdraw (MYR)</label>
                                            <div class="col-md-7">
                                                {{Form ::text('amount',$data->amount,['class'=>'form-control','rows'=>'6', 'required'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-refnum">Reference Number</label>
                                            <div class="col-md-7">
                                                {{Form ::text('ReferenceNumber',null,['class'=>'form-control','rows'=>'6', 'required'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-trans-date">Transaction Date</label>
                                            <div class="col-md-7">
                                                {{Form ::date('TransactionDate',null,['class'=>'form-control','rows'=>'6', 'required'])}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-quantity">Proof of payment</label>
                                            <div class="col-md-7">
                                                 {{Form ::file('ProofURL',null,['class'=>'form-control','rows'=>'6', 'required'])}}
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