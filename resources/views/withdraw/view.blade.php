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
                               
                            </ul>
                            <h3 class="block-title">Withdraw Request Details</h3>
                        </div>
                        <div class="block-content">
                                <div class="block-content">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs" style="width: 10%;">ID</th>
                                                <th>Name</th>
                                                <th class="hidden-xs" style="width: 15%;">Email</th>
                                                <th>Date/Time</th>
                                                <th>Amount</th>
                                                 <th>Bank Details</th>
                                                 <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;?>
                                              @foreach($withdraw as $key=>$data)
                                            <tr>
                                                <td>{{$data->withdrawID}}</td>
                                                <td>{{$data->name}}</td>
                                                <td class="hidden-xs">
                                                    {{$data->email}}
                                                </td>
                                                <td>{{$data->created_at}}</td>
                                                <td>RM {{$data->amount}}</td>
                                                <td>{{$data->u_bankname}} : {{$data->u_accnumber}}</td>
                                                <td class="text-center">
                                                <div class="btn-group">
                                               <a href="{{route('viewApproveWithdraw',['withdrawID'=>$data->withdrawID])}}"<button class="btn btn-xs btn-primary push-5-r push-10" type="button"><i class="fa fa-pencil"></i> Approve</button></a>
                                                <a href="{{route('viewRejectWithdraw',['withdrawID'=>$data->withdrawID])}}"<button class="btn btn-xs btn-danger push-5-r push-10" type="button"><i class="fa fa-times"></i> Reject</button></a>
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
