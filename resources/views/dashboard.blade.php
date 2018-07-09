@extends('layouts.app')

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
                                    <div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="35"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Pending Orders</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700 text-success" data-toggle="countTo" data-to="28"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Order Completed</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="base_pages_ecom_orders.html">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="109"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Orders Today</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700">$<span data-toggle="countTo" data-to="8970"></span></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Earnings Today</div>
                            </a>
                        </div>
                    </div>
                    <!-- END Header Tiles -->

            <!-- Overview -->
             <div class="row">
                <div class="col-lg-6">
                    <div class="block block-opt-refresh-icon4">
                        <div class="block-header bg-gray-lighter">
                            <ul class="block-options">
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Orders Overview</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <!-- Chart.js Charts (initialized in js/pages/base_pages_ecom_dashboard.js), for more examples you can check out http://www.chartjs.org/docs/ -->
                            <div style="height: 340px;"><canvas class="js-chartjs-overview"></canvas></div>
                        </div>
                    </div>
                </div>

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
                                            @foreach($latestorder as $key=>$data)
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a><strong>{{$data->OrderID}}</strong></a></td>
                                                <td class="hidden-xs"><a>{{$data->name}}</a></td>
                                                <td><span class="label label-success">{{$data->status_job}}</span></td>
                                                <td class="text-right"><strong>${{$data->amount}}</strong></td>
                                            </tr>
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                            <!-- END Latest Orders -->
            
                    <!-- Top Products and Latest Orders -->
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Top Products -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <ul class="block-options">
                                        <li>
                                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                        </li>
                                    </ul>
                                    <h3 class="block-title">Top Products</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                            @foreach($topproduct as $key=>$data)
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a><strong>{{$data->sku_number}}</strong></a></td>
                                                <td><a>{{$data->Name}}</a></td>
                                                <td class="hidden-xs text-center">
                                                    <div class="text-warning">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- END Top Products -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Latest Customer Register -->
                            <div class="block block-opt-refresh-icon4">
                                <div class="block-header bg-gray-lighter">
                                    <ul class="block-options">
                                        <li>
                                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                        </li>
                                    </ul>
                                    <h3 class="block-title">Latest User Registration</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-borderless table-striped table-vcenter">
                                        <tbody>
                                             @foreach($latestuser as $key=>$data)
                                            <tr>
                                                <td class="text-center"><a>{{$data->created_at}}</a></td>
                                                <td class="hidden-xs"><a>{{$data->name}}</a></td>
                                                <td><span class="label label-primary">{{$data->role}}</span></td>
                                                <td class="text-right"><strong>{{$data->email}}</strong></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END Latest Orders -->
                        </div>
                    </div>
                    <!-- END Top Products and Latest Orders -->
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
@endsection 