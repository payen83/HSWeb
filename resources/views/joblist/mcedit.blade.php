@extends('layouts.nav')

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
                                <li><a class="link-effect" href="{{route('listpendingjob')}}">Pending Jobs</a></li>
                                <li>Update Job Status</li>
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
                           
                            <h3 class="block-title">Update Job Status</h3>
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
                                    {{Form::open(['route' => ['editStatusOrder','JobID'=>$data->JobID],'method'=>'POST'])}}
                                        @csrf
                                      
                                                {{Form ::hidden('JobID',$data->JobID,['class'=>'form-control','rows'=>'6'])}}
                                       
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-ag-email">Agent Name</label>
                                            <div class="col-md-7">
                                                {{Form ::label('name',$data->name,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-ag-email">Order Number</label>
                                            <div class="col-md-7">
                                                {{Form ::label('OrderID',$data->OrderID,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-status">Delivery Method</label>
                                            <div class="col-md-7">
                                               {!! Form::select('delivery_method',['POS'=>'POS (Postage)','COD'=>'COD (Cash On Delivery)'],null,["class"=>"form-control",'rows'=>'6']) !!}
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-status">Status</label>
                                            <div class="col-md-7">
                                               {!! Form::select('status_job',['Pending'=>'Pending','OnDelivery'=>'OnDelivery','Completed'=>'Completed'],$data->status_job,["class"=>"form-control",'rows'=>'6']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-ag-email">Tracking Number</label>
                                            <div class="col-md-7">
                                                {{Form ::text('tracking_number',$data->tracking_number,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                       <br><br>
                                        <div class="form-group">
                                            <div class="col-md-8 col-md-offset-4">
                                                <a href="{{route('listpendingjob')}}"<button class="btn btn-sm btn-danger" type="submit">Back</button></a>
                                                <button class="btn btn-sm btn-primary" type="submit">Submit</button></a>
                                            </div>
                                        </div>
                                    </form>
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