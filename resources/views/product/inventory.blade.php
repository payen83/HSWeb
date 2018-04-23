@extends('layouts.app')

@section('content')
           <!-- Main Container -->
            <main id="main-container">
             <!-- Page Header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>Product</li>
                                <li><a class="link-effect" href="adduser.html">Agent Product Inventory</a></li>
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
                            <h3 class="block-title">Agent Product Inventory</h3>
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%;"></th>
                                        <th class="hidden-xs" style="width: 10%;">Product ID</th>
                                        <!--<th class="hidden-xs">Product Name</th>-->
                                        <th class="hidden-xs" style="width: 15%;">Agent Email</th>
                                        <th class="text-center" style="width: 10%;">Quantity</th>
                                        <th class="text-center" style="width: 10%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($inventories as $key=>$data)
                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                        <td class="font-w600">{{$data->product_id}}</td>
                                        <!--<td class="font-w600">{{$data->product_name}}</td>-->
                                        <td class="font-w600">{{$data->agent_email}}</td>
                                        <td class="hidden-xs">{{$data->quantity}}</td>
                                      
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{route('viewEditInvProduct',['id'=>$data->id])}}"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-pencil"></i> Edit</button></a>
                                                <button class="btn btn-xs btn-danger push-5-r push-10" type="button" onclick="return myFunction()"><i class="fa fa-times"></i> Delete</button>
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
                    </div>
                    <!-- END My Block -->
                </div>
                 <!-- Footer -->
            <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
                <div class="pull-right">
                    ElyzianInteractive@2018
                </div>
               
            </footer>
            <!-- END Footer -->
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
@endsection 