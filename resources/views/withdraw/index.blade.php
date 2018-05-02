@extends('layouts.app')

@section('content')

<!-- Main Container -->
            <main id="main-container">
                
                <!-- Page Content -->
                <div class="content">
                    <!-- My Block -->
                    <div class="block">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <button type="button"><i class="si si-settings"></i></button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                                </li>
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="close"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Withdraw Request List</h3>
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Date</th>
                                        <th class="hidden-xs">Agent Name</th>
                                        <th class="hidden-xs" style="width: 15%;">Amount</th>
                                        <th class="text-center" style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach($withdraw as $key=>$data)
                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                        <td class="hidden-xs">{{$data->created_at}}</td>
                                        <td class="hidden-xs">{{$data->agent_email}}</td>
                                        <td class="hidden-xs">{{$data->amount}}</td>
                                      
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="appwithdraw.html"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-eye"></i> View</button></a>
                                              
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
              
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
@endsection