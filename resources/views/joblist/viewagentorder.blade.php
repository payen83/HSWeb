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
      
                            </ul>
                            <h3 class="block-title">HQ Delivery List</h3>
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center" style="width: 15%;" >Job ID</th>
                                        <th class="text-center">Order Number</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Order from</th>
                                        <th class="text-center">Current Status</th>
                                        <th class="hidden-xs text-center">Date/Time</th>
                                        <th class="hidden-xs text-center">Action</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach($agentorder as $key=>$data)
                                    <tr>
                                        <td align="center">{{$i++}}</td>
                                        <td class="text-center">{{$data->JobID}}</td>
                                        <td class="hidden-xs text-center">{{$data->OrderID}}</td>
                                        <td class="hidden-xs text-center">{{$data->name}}</td>
                                        <td class="hidden-xs text-center">{{$data->role}}</td>
                                        <td class="hidden-xs text-center">{{$data->status_job}}</td>
                                        <td class="hidden-xs text-center">{{$data->created_at}}</td>
                                        
                                         <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{route('ViewOrderDetails',['OrderID'=>$data->OrderID])}}"<button class="btn btn-xs btn-success push-5-r push-10" type="button"><i class="fa fa-eye"></i>View</button></a>
                                                <a href="{{route('viewEditAgentOrder',['JobID'=>$data->JobID])}}"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-pencil"></i> Edit</button></a>
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