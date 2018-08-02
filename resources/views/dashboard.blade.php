@extends('layouts.app')

@section('content')
<!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="content content-boxed">
                    <!-- Header Tiles -->
                    <div class="row">
                         <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                     @foreach($pendingorder as $key=>$data)
                                    <div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="{{$data->pendingorders}}"></div>
                                    @endforeach
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Pending Orders</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    @foreach($completedorder as $key=>$data)
                                    <div class="h1 font-w700 text-success" data-toggle="countTo" data-to="{{$data->completedorders}}"></div>
                                    @endforeach
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Order Completed</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center">
                                <div class="block-content block-content-full">
                                    @foreach($ordertoday as $key=>$data)
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="{{$data->numberoforder}}"></div>
                                    @endforeach
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Orders Today</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <?php
                                        $totalearn=0;
                                        ?>
                                    @foreach($earntoday as $key=>$data)
                                    <?php
                                            $totalearn += $data->amount;
                                    ?>
                                    
                                    @endforeach
                                    <div class="h1 font-w700">$<span data-toggle="countTo" data-to="{{$totalearn}}"></span></div>
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
        
                            <div style="height: 340px;">{!! $chart->container() !!}</div>
                        </div>
                    </div>
                </div>
                {!! $chart->script() !!}

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
                                                <td class="text-center" style="width: 100px;">
                                                <a  href="{{route('ViewOrderDetails',['OrderID'=>$data->OrderID])}}">     
                                                    <strong>{{$data->OrderID}}</strong>
                                                </a></td>
                                                <td class="hidden-xs"><a>{{$data->name}}</a></td>
                                                <td><span class="label label-success">{{$data->status_job}}</span></td>
                                                <td class="text-right"><strong>${{$data->total_price}}</strong></td>
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
                                                    {{$data->TotalQuantity}} UNIT SOLD
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