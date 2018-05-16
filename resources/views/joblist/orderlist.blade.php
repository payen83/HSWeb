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
                                <li><a class="link-effect" href="{{route('viewJoblist')}}">Job List</a></li>
                                <li>Order List</li>
                                
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
                            <a href="{{route('OrderProduct')}}"<button class="btn btn-success push-5-r push-10" type="button"><i class="fa fa-plus"></i> Add Orders</button></a>
                            </ul>
                            <h3 class="block-title">Order List</h3>
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->

                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 100px;">Bil</th>
                                        <th class="text-center" >Order ID</th>
                                        <th class="text-center" >Customer Email</th>
                                        <th class="hidden-xs text-center">Date/Time</th>
                                        <th class="text-center" style="width: 23%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach($orders as $key=>$data)
                                    <tr>
                                        <td class="hidden-xs text-center">{{$i++}}</td>
                                         <td class="hidden-xs text-center">{{$data->OrderID}}</td>
                                         <td class="hidden-xs text-center">{{$data->email}}</td>
                                        <td class="hidden-xs text-center">{{$data->created_at}}</td>
                
                                         <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{route('ViewOrderDetails',['OrderID'=>$data->OrderID])}}"<button class="btn btn-xs btn-success push-5-r push-10" type="button"><i class="fa fa-eye"></i> View</button></a>
                                                <button class="btn btn-xs btn-danger push-5-r push-10" type="button" onclick="return myFunction()"><i class="fa fa-times"></i> Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                           
                        </div>
                    </div>
                    <!-- END All Orders -->
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
@endsection 