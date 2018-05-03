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
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="base_pages_ecom_order.html"><strong>ORD.7116</strong></a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Vincent Sims</a></td>
                                                <td><span class="label label-success">Delivered</span></td>
                                                <td class="text-right"><strong>$271,00</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_order.html"><strong>ORD.7115</strong></a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Scott Ruiz</a></td>
                                                <td><span class="label label-danger">Canceled</span></td>
                                                <td class="text-right"><strong>$430,00</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_order.html"><strong>ORD.7114</strong></a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Susan Elliott</a></td>
                                                <td><span class="label label-success">Delivered</span></td>
                                                <td class="text-right"><strong>$897,00</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_order.html"><strong>ORD.7113</strong></a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">John Parker</a></td>
                                                <td><span class="label label-warning">Processing</span></td>
                                                <td class="text-right"><strong>$965,00</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="base_pages_ecom_order.html"><strong>ORD.7116</strong></a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Vincent Sims</a></td>
                                                <td><span class="label label-success">Delivered</span></td>
                                                <td class="text-right"><strong>$271,00</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_order.html"><strong>ORD.7115</strong></a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Scott Ruiz</a></td>
                                                <td><span class="label label-danger">Canceled</span></td>
                                                <td class="text-right"><strong>$430,00</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_order.html"><strong>ORD.7114</strong></a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Susan Elliott</a></td>
                                                <td><span class="label label-success">Delivered</span></td>
                                                <td class="text-right"><strong>$897,00</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_order.html"><strong>ORD.7114</strong></a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Susan Elliott</a></td>
                                                <td><span class="label label-success">Delivered</span></td>
                                                <td class="text-right"><strong>$897,00</strong></td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
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
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="base_pages_ecom_product_edit.html"><strong>AA 123</strong></a></td>
                                                <td><a href="base_pages_ecom_product_edit.html">Milk Thistle (Silymarin)</a></td>
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
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_product_edit.html"><strong>AA 124</strong></a></td>
                                                <td><a href="base_pages_ecom_product_edit.html">Digestive Enzymes by Naturenetics</a></td>
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
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_product_edit.html"><strong>AA 125</strong></a></td>
                                                <td><a href="base_pages_ecom_product_edit.html">MGO™ 550+ Manuka Honey</a></td>
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
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_product_edit.html"><strong>AA 126</strong></a></td>
                                                <td><a href="base_pages_ecom_product_edit.html">MGO™ 550+ Manuka Honey</a></td>
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
                                            <tr>
                                                <td class="text-center" style="width: 100px;"><a href="base_pages_ecom_order.html">13-04 09:20</a></td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Vincent Sims</a></td>
                                                <td><span class="label label-primary">Customer</span></td>
                                                <td class="text-right"><strong>vincent@gmail.com</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_order.html">13-04 10:20
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Scott Ruiz</a></td>
                                                <td><span class="label label-success">Agent</span></td>
                                                <td class="text-right"><strong>scott@gmail.com</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_order.html">12-04 13:45</td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">Susan Elliott</a></td>
                                                <td><span class="label label-success">Customer</span></td>
                                                <td class="text-right"><strong>susan@gmail.com</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><a href="base_pages_ecom_order.html">11-04 18:20</td>
                                                <td class="hidden-xs"><a href="base_pages_ecom_customer.html">John Parker</a></td>
                                                <td><span class="label label-primary">Agent</span></td>
                                                <td class="text-right"><strong>john@gmail.com</strong></td>
                                            </tr>
                                           
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