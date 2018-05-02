@extends('layouts.app')

@section('content')
            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                Inventory Product <small>
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>Product</li>
                                <li><a class="link-effect" href="product.html">Inventory Product</a></li>
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
                            <a href="{{route('viewInventory')}}"<button class="btn btn-primary push-5-r push-10" type="button"><i class="fa fa-list-ol"></i> Agent Product Inventory</button></a>
                            </ul>
                            <ul class="block-options">
                            <a href="{{route('viewAddProduct')}}"<button class="btn btn-success push-5-r push-10" type="button"><i class="fa fa-plus"></i> Add Product</button></a>
                            </ul>
                            
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center">Product Name</th>
                                        <th class="hidden-xs">Description</th>
                                        <th class="hidden-xs" >Price</th>
                                        <th class="hidden-xs" >Image</th>
                                        <th class="text-center" >Quant/Pack</th>
                                        <th class="text-center" >Discount (%)</th>
                                        <th class="text-center" style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach($products as $key=>$data)
                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                        <td class="hidden-xs">{{$data->Name}}</td>
                                        <td class="hidden-xs" width="350" height="30">{{$data->Description}}</td>
                                        <td class="hidden-xs">${{$data->Price}}</td>
                                        <td class="hidden-xs"><img src="http://localhost:90/HealthShopper/public/upload/images/<?php echo $data->ImageURL; ?>" width="70" height="100"></td>
                                         <td class="hidden-xs">{{$data->QuantityPerPackage}}</td>
                                          <td class="hidden-xs">{{$data->Discount*100}}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{route('viewEditProduct',['ProductID'=>$data->id])}}"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-pencil"></i> Edit</button></a>
                                               
                                                <a href="{{route('viewAssignProduct',['ProductID'=>$data->id])}}" <button class="btn btn-xs btn-success push-5-r push-10" type="button"><i class="fa fa-list-ul"></i> Assign</button></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END Dynamic Table Full -->
                    </div>
                    <!-- END My Block -->
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->

         
        </div>
        <!-- END Page Container -->

@endsection 
