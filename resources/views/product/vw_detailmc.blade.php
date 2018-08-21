@extends('layouts.app')

@section('content')
    <!-- Main Container -->
            <main id="main-container">
                <!-- Page Header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                Approval Product Details
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li><a class="link-effect" href="{{route('viewProductApproval')}}">Product Approval</a></li>
                                <li>Approval Product Details</li>
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
                            
                            <h3 class="block-title">APPROVAL PRODUCT DETAILS</h3>
                        </div>
                        <div class="block-content">
                           <!-- Page Content -->
                <div class="content content-narrow">
                    <!-- Forms Row -->
                    <div class="row">
                        <div class="col-lg-15">
                            <div class="block">
                                <ul class="block-options">
                                 <form name ="frmapprove">
                                    <a href="{{route('updateApproval',['ProductID'=>$data->id])}}"<button class="btn btn-xs btn-success push-5-r push-10" type="submit" onclick="return myFunction1()"><i class="fa fa-check"></i> APPROVE PRODUCT</button></a>
                                 </form>
                                 <!-- <a href="{{route('updateApproval',['ProductID'=>$data->id])}}"<button class="btn btn-xs btn-success push-5-r push-10" type="button"><i class="fa fa-check"></i> APPROVE PRODUCT</button></a> -->
                                 </ul>
                                
                                <div class="block-content block-content-narrow">
                                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                            {{Form ::hidden('id',$data->id,['class'=>'form-control','rows'=>'6'])}}
                                        
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="productname">Product Name</label>
                                            <div class="col-md-7">
                                                {{Form ::label('Name',$data->Name,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-4 control-label" for="productname">SKU Number</label>
                                            <div class="col-md-7">
                                                {{Form ::label('sku_number',$data->sku_number,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label"" for="val-desc">Description</label>
                                            <div class="col-md-7">
                                               {{Form ::textarea('Description',$data->Description,array('disabled'),['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-price">Price (MYR)</label>
                                            <div class="col-md-7">
                                                {{Form ::label('Price',$data->Price,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                       

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-picture">Image</label>
                                            <div class="col-md-7">
                                            @if($data->ImageURL == '')
                                            <td class="hidden-xs"><img src="{{ url('/') }}/upload/images/no-image.png" width="70" height="100"></td>
                                            @endif
                                            @if($data->ImageURL != '')
                                            <td class="hidden-xs"><img src="{{ url('/') }}/upload/images/<?php echo $data->ImageURL; ?>" width="70" height="100"></td>
                                            @endif
                                           
                               
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
                          
                            <h3 class="block-title">PRODUCT PACKAGE</h3>
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
                                                {{Form ::label('QuantityPerPackage',$data->QuantityPerPackage,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                            
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-price">Discount (%)</label>
                                           <br>
                                            <div class="col-md-7">
                                                {{Form ::label('Discount',$data->Discount*100,['class'=>'form-control','rows'=>'6'])}}
                                                
                                            </div>
                                            <br>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-8 col-md-offset-4">
                                                <a href="{{route('viewProductApproval')}}"<button class="btn btn-sm btn-danger" type="submit">Back</button></a>
                                            </div>
                                        </div>
                                  
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

       
        <script>
        function myFunction1() {
        var r = confirm('Are you sure want to approve this product ?');
        
        if (r == true){
            document.frmapprove.submit();
            return true;
        }
        
        else
            return false;
         }
        </script>
@endsection 