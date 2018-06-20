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
                                <li><a class="link-effect" href="{{route('viewJoblist')}}">Joblist</a></li>
                                <li>Job Details</li>
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
                          
                           
                        </div>
                         <!-- Products -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Job Details</h3>
                        </div>
                        <div class="block-content">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 100px;">Bil</th>
                                            <th>Order ID</th>
                                            <th>Job Status</th>
                                            <th>Date/Time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;?>
                                       
                                        @foreach($job as $key=> $data)

                                        <tr>
                                            <td class="text-center">{{$i++}}</td>
                                            <td><a href="{{route('ViewOrderDetails',['OrderID'=>$data->OrderID])}}"><strong>{{$data->OrderID}}</strong></a></td>
                                            <td>{{$data->job_status}}</a></td>
                                            <td>{{$data->created_at}}</td>
                                        </tr>
                                       
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END Products -->

                  
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
@endsection 