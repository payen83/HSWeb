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
                                    <div class="h1 font-w700 text-primary" data-toggle="countTo" data-to="35"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Pending</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="120"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Today</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="260"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">Yesterday</div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="h1 font-w700" data-toggle="countTo" data-to="57890"></div>
                                </div>
                                <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600">This Month</div>
                            </a>
                        </div>
                    </div>
                    <!-- END Header Tiles -->

                    <!-- All Orders -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            
                            <h3 class="block-title">All Job List</h3>
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 100px;">Job ID</th>
                                        <th class="text-center" style="width: 100px;">Agent Email</th>
                                        <th class="visible-lg">Order Number</th>
                                        <th>Status</th>
                                        <th class="hidden-xs text-center">Date/Time</th>
                                        <th class="hidden-xs text-right">Total Price</th>
                                        <th class="text-center" style="width: 23%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach($joblists as $key=>$data)
                                    <tr>
                                        <td class="text-center">
                                            <a class="font-">
                                                <strong>{{$data->JobID}}</strong>
                                            </a>
                                        </td>
                                        <td class="hidden-xs text-center">{{$data->agent_email}}</td>
                                         <td class="hidden-xs text-center">{{$data->OrderID}}</td>
                                        <td>
                                            <span class="label label-success">{{$data->job_status}}</span>
                                        </td>
                                        <td class="hidden-xs text-center">{{$data->created_at}}</td>
                                        <td class="text-right hidden-xs">
                                            <strong>RM {{$data->total_price}}</strong>
                                        </td>
                                         <td class="text-center">
                                            <div class="btn-group">
                                                 <a href="editorder.html"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-pencil"></i> Edit</button></a>
                                                <a href="viewjoblist.html"<button class="btn btn-xs btn-success push-5-r push-10" type="button"><i class="fa fa-eye"></i> View</button></a>
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