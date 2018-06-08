@extends('layouts.app')

@section('content')
    <!-- Main Container -->
            <main id="main-container">
                <!-- Page Header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                Edit Product Details
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>Product</li>
                                <li><a class="link-effect" href="">Edit Product Details</a></li>
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
                            
                            <h3 class="block-title">EDIT PRODUCT DETAILS</h3>
                        </div>
                        <div class="block-content">
                           <!-- Page Content -->
                <div class="content content-narrow">
                    <!-- Forms Row -->
                    <div class="row">
                        <div class="col-lg-15">
                            <div class="block">
                                <ul class="block-options">
                                 <form name ="frmdelete" action="{{route('delete',['id'=>$data->id])}}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger push-5-r push-10" onclick="return myFunction()"><i class="fa fa-times"></i> DELETE PRODUCT</button>
                                 </form>
                                 </ul>
                                
                                <div class="block-content block-content-narrow">
                                    <!-- jQuery Validation (.js-validation-bootstrap class is initialized in js/pages/base_forms_validation.js) -->
                                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                      {{Form::open(['route' => ['editProduct','id'=>$data->id],'method'=>'POST','enctype' => 'multipart/form-data'])}}
                                      @csrf
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-productid">Product ID</label>
                                            <div class="col-md-7">
                                                {{Form ::text('id',$data->id,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="productname">Product Name</label>
                                            <div class="col-md-7">
                                                {{Form ::text('Name',$data->Name,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label"" for="val-desc">Description</label>
                                            <div class="col-md-7">
                                               {{Form ::textarea('Description',$data->Description,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-price">Price</label>
                                            <div class="col-md-7">
                                                {{Form ::text('Price',$data->Price,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                        </div>
                                       

                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-picture">Image</label>
                                            <div class="col-md-7">
                                            <img src="{{ url('/') }}/upload/images/<?php echo $data->ImageURL; ?>" width="70" height="100">
                                            {{Form ::file('ImageURL',null,['class'=>'form-control','rows'=>'6'])}}
                               
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
                          
                            <h3 class="block-title">AGENT PRODUCT PACKAGE</h3>
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
                                                {{Form ::text('QuantityPerPackage',$data->QuantityPerPackage,['class'=>'form-control','rows'=>'6'])}}
                                            </div>
                                            
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="val-price">Discount (%)</label>
                                           <br>
                                            <div class="col-md-7">
                                                {{Form ::text('Discount',$data->Discount*100,['class'=>'form-control','rows'=>'6'])}}
                                                
                                            </div>
                                            <br>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-8 col-md-offset-4">
                                                <a href="{{route('viewProduct')}}"<button class="btn btn-sm btn-danger" type="submit">Back</button></a>
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

        <script>
        function myFunction() {
        var r = confirm('Are you sure want to delete record ?');
        
        if (r == true){
            document.frmdelete.submit();
            return true;
        }
        
        else
            return false;
         }
        </script>
@endsection 