@extends('layouts.nav')

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
                            <h3 class="block-title">Pending Jobs</h3>
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center" style="width: 15%;" >Job ID</th>
                                        <th class="text-center">Customer Name</th>
                                        <th class="text-center">Order Number</th>
                                        <th class="hidden-xs text-center">Date/Time</th>
                                        <th class="hidden-xs text-center">Action</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach($result as $key=>$data)
                                    <tr>
                                        <td align="center">{{$i++}}</td>
                                        <td class="text-center">{{$data->JobID}}</td>
                                        <td class="hidden-xs text-center">{{$data->name}}</td>
                                         <td class="hidden-xs text-center">{{$data->OrderID}}</td>
                                        <td class="hidden-xs text-center">{{$data->created_at}}</td>
                                        
                                         <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{route('MerchantOrderDetails',['OrderID'=>$data->OrderID])}}"<button class="btn btn-xs btn-success push-5-r push-10" type="button"><i class="fa fa-eye"></i>View</button></a>
                                                @if($data->status_job == 'Pending')
                                                <a href="{{route('viewEditStatusJob',['JobID'=>$data->JobID])}}"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-pencil"></i> Update</button></a>
                                                @endif
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