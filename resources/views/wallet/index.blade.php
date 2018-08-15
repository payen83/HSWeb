@extends('layouts.nav')

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
                                <li><a class="link-effect" href="{{route('viewWallet')}}">Transaction</a></li>
                                <li>Transaction Wallet History</li>
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
                            @foreach($wallet1 as $key=> $data)
                            <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Available for Withdraw: $ {{$data->jumlah}}</h3>
                             <br>
                             <form name ="frmwithdraw" class="text-right">
                                    <a  href="{{route('withdrawrequest',['amount'=>$data->jumlah])}}"<button class="btn  btn-success push-5-r push-10" type="submit" onclick="return myFunction1()"><i class="fa fa-credit-card-alt"></i> Withdraw</button></a>
                            </form>
                            </div>
                             @endforeach
                            </ul>
                           
                        </div>
                         <!-- Products -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">Transaction Wallet History</h3>
                        </div>
                        <div class="block-content">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">Date/Time</th>
                                            <th style="width: 30%;">Status</th>
                                            <th style="width: 35%;">Message</th>
                                            <th class="text-right" style="width: 20%;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalamount=0;
                                        ?>
                                       
                                        @foreach($wallet as $key=> $data)

                                        <tr>
                                            <td>{{$data->created_at}}</td>
                                            <td>{{$data->status}}</td>
                                            <td>{{$data->message}}</td>
                                            <td class="text-right">{{$data->amount}}</td>
                                            <?php
                                            $totalamount += $data->amount;
                                            ?>
                                        </tr>
                                       
                                    @endforeach
                                     <tr class="success">
                                            <td colspan="5" class="text-right text-uppercase"><strong>Total Wallet Amount:</strong></td>
                                            <td class="text-right">${{$totalamount}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END Products -->

                    <!-- Customer -->
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Billing Address -->
                            
                            <div class="block">
                                <div class="block-header bg-gray-lighter">
                                    <h3 class="block-title">Merchant Details</h3>
                                </div>
                                @foreach($wallet1 as $key=> $data)
                                <div class="block-content block-content-full">
                                    <address>
                                        <div><strong>{{$data->name}}</strong></div>
                                        <i class="fa fa-home"></i> {{$data->u_address}}<br>
                                        <i class="fa fa-phone"></i>  {{$data->u_phone}}<br>
                                        <i class="fa fa-envelope-o"></i> <a href="javascript:void(0)">{{$data->email}}</a><br>
                                       
                                    </address>
                                </div>
                                 @endforeach
                            </div>
                            <!-- END Billing Address -->
                        </div>
                        <div class="col-lg-6">
                            
                            <div class="block">
                                
                            </div>
                            
                        </div>
                    </div>

                   
                    <!-- END Customer -->

                  
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->

             <script>
                function myFunction1() {
                var r = confirm('Are you sure want to request for withdrawal ?');
                
                if (r == true){
                    document.frmwithdraw.submit();
                    return true;
                }
                
                else
                    return false;
                 }
            </script>
@endsection 