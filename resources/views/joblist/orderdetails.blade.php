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
                                <li><a class="link-effect" href="{{route('viewJoblist')}}">Joblist List</a></li>
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
                                        <?php
                                        $totalprice=0;
                                        ?>
                                       
                                        @foreach($orders as $key=> $data)

                                        <tr>
                                            <td class="text-center">{{$data->OrderID}}</td>
                                            <td class="text-center">{{$data->ProductID}}</td>
                                            <td>{{$data->Name}}</td>
                                            <td class="text-center">{{$data->ProductQuantity}}</td>
                                            <td class="text-right">RM {{$data->Price}}</td>
                                            <td class="text-right">RM {{$data->Total_Amount}}</td>
                                            <?php
                                            $totalprice += $data->Total_Amount;
                                            ?>
                                        </tr>
                                       
                                    @endforeach
                                     <tr class="success">
                                            <td colspan="5" class="text-right text-uppercase"><strong>Total Price:</strong></td>
                                            <td class="text-right">RM {{$totalprice}}</td>
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
                                    <h3 class="block-title">Delivery Address</h3>
                                </div>
                                @foreach($orders1 as $key=> $data)
                                <div class="block-content block-content-full">
                                    <address>
                                        <div><strong>{{$data->name}}</strong></div>
                                        <i class="fa fa-home"></i> {{$data->location_address}}<br>
                                        <i class="fa fa-phone"></i>  {{$data->u_phone}}<br>
                                        <i class="fa fa-envelope-o"></i> <a href="javascript:void(0)">{{$data->email}}</a><br>
                                       
                                    </address>
                                </div>
                                 @endforeach
                            </div>
                            <!-- END Billing Address -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Shipping Address -->
                            <div class="block">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title"><i class="fa fa-pencil"></i>Special Notes</h3>
                                </div>
                                <div class="block-content block-content-full">
                                    
                                        {{$data->special_notes}}
                                   
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