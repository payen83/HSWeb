@extends('layouts.app')

@section('content')
            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                Product Approval <small>
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>Product</li>
                                <li><a class="link-effect" href="#">Product Approval</a></li>
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
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="hidden-xs"  style="width: 15%;">Image</th>
                                        <th>Product Name</th>
                                        <th class="hidden-xs" >Price</th>
                                        <th class="text-center" >Status</th>
                                        <th class="text-center" style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach($products as $key=>$data)
                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                         @if($data->ImageURL == '')
                                            <td class="hidden-xs"><img src="{{ url('/') }}/upload/images/no-image.png" width="70" height="100"></td>
                                            @endif
                                            @if($data->ImageURL != '')
                                            <td class="hidden-xs"><img src="{{ url('/') }}/upload/images/<?php echo $data->ImageURL; ?>" width="70" height="100"></td>
                                            @endif
                                        <td class="hidden-xs">{{$data->Name}}</td>
                                        <td class="hidden-xs">${{$data->Price}}</td>
                                         <td class="hidden-xs">{{$data->status}}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{route('viewDeatilProduct',['ProductID'=>$data->id])}}"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-pencil"></i> View</button></a>
                                               
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
