@extends('layouts.nav')

@section('content')
 <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="content content-boxed">
                    <!-- Header Tiles -->
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="base_pages_ecom_orders.html">
                                <div class="block-content block-content-full">
                                    @foreach($product_available as $key=>$data)
                                    <div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="{{$data->numberofproduct}}"></div>
                                    @endforeach
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Product Available</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    @foreach($order_month as $key=>$data)
                                    <div class="h1 font-w700 text-success" data-toggle="countTo" data-to="{{$data->numberofordermonth}}"></div>
                                    @endforeach
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Order By Month</div> 
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="base_pages_ecom_orders.html">
                                <div class="block-content block-content-full">
                                    @foreach($order_today as $key=>$data)
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="{{$data->numberoforder}}"></div>
                                    @endforeach
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Orders Today</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    @foreach($totalsales as $key=>$data)
                                    <div class="h1 font-w700">$<span data-toggle="countTo" data-to="{{$data->totalsale}}"></span></div>
                                    @endforeach
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Total Sale</div>
                            </a>
                        </div>
                    </div>
                    <!-- END Header Tiles -->


            <!-- END Overview -->

              <!-- Latest Orders -->
                        <div class="col-lg-6">
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <ul class="block-options">
                                        <li>
                                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                        </li>
                                    </ul>
                                    <h3 class="block-title">Latest Orders</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            @foreach($result as $key=>$data)
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="base_pages_ecom_order.html"><strong>{{$data->OrderID}}</strong></a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">{{$data->name}}</a></td>
                                                <td><span class="label label-success">{{$data->status_job}}</span></td>
                                                <td class="text-right"><strong>{{$data->sumprice}}</strong></td>
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                   </div>
               </div>

                <div class="col-lg-6">
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <ul class="block-options">
                                        <li>
                                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                        </li>
                                    </ul>
                                    <h3 class="block-title">Product List</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            @foreach($product as $key=>$data)
                                            <tr>
                                                <td><strong>{{$data->Name}}</strong></td>
                                                <td class="text-right"><strong>{{$data->sku_number}}</strong></td>
                                                <td class="hidden-xs">{{$data->Price}}</td>
                                                <td><span class="label label-success">{{$data->status}}</span></td>
                                                
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                   </div>
               </div>
                            <!-- END Latest Orders -->
            
  
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
@endsection