@extends('layouts.app')

@section('content')
            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="content content-boxed">
                   

                    <!-- All Orders -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <ul class="block-options">
                            <a href="{{route('ViewOrderList')}}"<button class="btn btn-primary push-5-r push-10" type="button"><i class="si si-basket-loaded"></i> Order Details</button></a>
                            </ul>
                            <h3 class="block-title">All Job List</h3>
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center" >Job ID</th>
                                        <th class="text-center">Agent Name</th>
                                        <th class="text-center">Order Number</th>
                                        <th  style="width: 100px;">Status</th>
                                        <th class="hidden-xs text-center">Date/Time</th>
                                        <th class="hidden-xs text-center">Action</th>
                                       
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
                                        <td class="hidden-xs text-center">{{$data->name}}</td>
                                         <td class="hidden-xs text-center">{{$data->OrderID}}</td>
                                        <td>
                                            <span class="label label-success">{{$data->status_job}}</span>  
                                        </td>
                                        <td class="hidden-xs text-center">{{$data->update_at}}</td>
                                        
                                         <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{route('viewJobDetails',['JobID'=>$data->JobID])}}"<button class="btn btn-xs btn-success push-5-r push-10" type="button"><i class="fa fa-eye"></i> View</button></a>
                                                 <a href="{{route('viewEditJoblist',['JobID'=>$data->JobID])}}"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-pencil"></i> Edit</button></a>
                                            </div>
                                        </td>
                                        
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
             <!-- Page JS Code -->

@endsection 