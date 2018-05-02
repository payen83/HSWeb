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
                                <li><a class="link-effect" href="{{route('ViewOrderList')}}">Order List</a></li>
                                <li>Order Details</li>
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
                           
                        </div>
                         <!-- Products -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Orders Details</h3>
                        </div>
                        <div class="block-content">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 100px;">Order ID</th>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-right" style="width: 10%;">UNIT COST</th>
                                            <th class="text-right" style="width: 10%;">PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($orders as $key=> $data)

                                        <tr>
                                            <td class="text-center"><a href="base_pages_ecom_product_edit.html"><strong>{{$data->OrderID}}</strong></a></td>
                                            <td class="text-center"><a href="base_pages_ecom_product_edit.html"><strong>{{$data->ProductID}}</strong></a></td>
                                            <td><a href="base_pages_ecom_product_edit.html">{{$data->Name}}</a></td>
                                            <td class="text-center">{{$data->ProductQuantity}}</td>
                                            <td class="text-right">${{$data->Price}}</td>
                                            <td class="text-right">${{$data->Total_Amount}}</td>
                                            
                                            
                                          
                                        </tr>
                                       
                                    @endforeach
                                     <tr class="success">
                                            <td colspan="5" class="text-right text-uppercase"><strong>Total Price:</strong></td>
                                            <td class="text-right">${{$data->total_price}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END Products -->

                    <!-- Customer -->
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Billing Address -->
                            <div class="block">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Billing Address</h3>
                                </div>
                                <div class="block-content block-content-full">
                                    <div class="h4 push-5">Bruce Edwards</div>
                                    <address>
                                        Sunset Str 598<br>
                                        Melbourne<br>
                                        Australia, 11-671<br><br>
                                        <i class="fa fa-phone"></i> (999) 888-77777<br>
                                        <i class="fa fa-envelope-o"></i> <a href="javascript:void(0)">company@example.com</a>
                                    </address>
                                </div>
                            </div>
                            <!-- END Billing Address -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Shipping Address -->
                            <div class="block">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Shipping Address</h3>
                                </div>
                                <div class="block-content block-content-full">
                                    <div class="h4 push-5">Dennis Ross</div>
                                    <address>
                                        Sunrise Str 620<br>
                                        Melbourne<br>
                                        Australia, 11-587<br><br>
                                        <i class="fa fa-phone"></i> (999) 888-55555<br>
                                        <i class="fa fa-envelope-o"></i> <a href="javascript:void(0)">company@example.com</a>
                                    </address>
                                </div>
                            </div>
                            <!-- END Shipping Address -->
                        </div>
                    </div>
                    <!-- END Customer -->

                  
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
@endsection 