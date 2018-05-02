@extends('layouts.app')

@section('content')

   <!-- Main Container -->
            <main id="main-container">
                <!-- Page Header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                Approve Withdraw
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>Withdraw</li>
                                <li><a class="link-effect" href="adduser.html">Approve Withdraw</a></li>
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
                            <h3 class="block-title">Withdraw Request Details</h3>
                        </div>
                        <div class="block-content">
                                <div class="block-content">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                
                                                <th>Name</th>
                                                <th class="hidden-xs" style="width: 15%;">Email</th>
                                                <th class="text-center" style="width: 100px;">Date</th>
                                                <th>Amount</th>
                                                 <th>Bank Details</th>
                                                 <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;?>
                                              @foreach($withdraw as $key=>$data->$id)
                                            <tr>
                                               
                                                <td>Linda Moore</td>
                                                <td class="hidden-xs">
                                                    {{$data->agent_email}}
                                                </td>
                                                <td>{{$data->created_at}}</td>
                                                <td>{{$data->amount}}</td>
                                                <td>Maybank Bhd : 1520-334-6789 (Linda Moore)</td>
                                                <td class="text-center">
                                                <div class="btn-group">
                                               <a href="app-wd.html"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-pencil"></i> Approve</button></a>
                                                <a href="reject-wd.html"<button class="btn btn-xs btn-danger push-5-r push-10" type="button"><i class="fa fa-times"></i> Reject</button></a>
                                            </div>
                                        </td>
                                                 
                                                
                                            </tr>

                                
                                          @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <!-- END Default Table -->
                            
                        
            </div>


            </main>
            <!-- END Main Container -->
@endsection
