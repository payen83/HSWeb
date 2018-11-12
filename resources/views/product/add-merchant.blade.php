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
                                <li>Product</li>
                                <li><a class="link-effect" href="#">Add Product</a></li>
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
                            <h3 class="block-title">Add Product Details</h3>
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
                                    {{Form::open(array('route' => 'addProductMerchant','method'=>'POST' , 'enctype' => 'multipart/form-data'))}}
                                        @csrf
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="productname">Product Name</label>
                                            <div class="col-md-7">
                                               {{Form ::text('Name',null,['class'=>'form-control','rows'=>'6', 'required'])}}
                                            </div>
                                            <br>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-4 control-label" for="productname">SKU Number</label>
                                            <div class="col-md-7">
                                               {{Form ::text('sku_number',null,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                            <br>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label"" for="val-desc">Description</label>
                                            <div class="col-md-7">
                                                 {{Form ::textarea('Description',null,['class'=>'form-control','rows'=>'6', 'required'])}}
                                            </div>
                                            <br>
                                            <br>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-price">Price (MYR)</label>
                                            <br>
                                            <div class="col-md-7">
                                                {{Form ::text('Price',null,['class'=>'form-control','rows'=>'6', 'required'])}}
                                            </div>
                                            <br>
                                        </div>
                                       


                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-picture">Image</label>
                                            <div class="col-md-7">
                                                {{Form ::file('ImageURL',null,['class'=>'form-control','rows'=>'6', 'required'])}}
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                       </div>
                                       
                                </div>
                            </div>
                            <!-- Bootstrap Forms Validation -->
                        </div>
                    </div>
                    <!-- END My Block -->
                </div>
                <!-- END Page Content -->

                   <!-- Page Content -->
                <div class="content">
                    <!-- My Block -->
                    <div class="block">
                        <div class="block-header">
                            
                            <h3 class="block-title">Agent Package Details</h3>
                        </div>
                        <div class="block-content">
                           <!-- Page Content -->
                <div class="content content-narrow">
                    <!-- Forms Row -->
                    <div class="row">
                        <div class="col-lg-15">
                            <div class="block">
                                
                                <div class="block-content block-content-narrow">
                                   
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-price">Quantity Per Package</label>
                                          
                                            <div class="col-md-7">
                                                {{Form ::text('QuantityPerPackage',null,['class'=>'form-control','rows'=>'6', 'required'])}}
                                            </div>
                                            
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-price">Discount (%)</label>
                                           <br>
                                            <div class="col-md-7">
                                                {{Form ::text('Discount',null,['class'=>'form-control','rows'=>'6', 'required'])}}
                                               
                                            </div>
                                            <br>
                                        </div>


                                        <div class="form-group">
                                            <br>
                                            <br>
                                            <div class="col-md-8 col-md-offset-4">
                                               <a href="{{route('viewProductMerchant')}}"<button class="btn btn-sm btn-danger" type="submit">Back</button></a>
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
            </main>
            <!-- END Main Container -->
@endsection 