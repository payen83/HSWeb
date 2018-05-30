@extends('layouts.app')

@section('content')
<!DOCTYPE html>  
 <html>  
      <head>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  
           <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
      </head>  

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="content content-boxed">

                    <!-- All Orders -->
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            
                            <h3 class="block-title">Sales Tracking</h3>
                        </div>

                        <!-- Page Content -->
                <div class="content">
                    <!-- My Block -->
                    <div class="block">
                        <div class="block-header">
                            <div class="col-sm-3 form-group">
                                    <div class='input-group date' data-provide="datapicker">
                                            <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                            </span>
                                                <input type='date' class="form-control" name="form_date" id="from_date" placeholder="From Date"/>
                                    </div>
                            </div>
                            <div class="col-sm-3 form-group">
                                    <div class='input-group date'>
                                            <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                            </span>
                                                <input type='date' class="form-control" name="to_date" id="to_date" placeholder="To Date"/> 
                                     </div>
                            </div>
                            
                            <a href="javascript:ajaxLoad(viewSales?report_from='+$('report_from').val()+'&report_to='+$('report_to').val())"<button class="btn btn-primary push-5-r push-10" type="submit"><i class="si si-magnifier"></i>Submit</button></a>
                            
                            
                        </div>
                        <div class="block-content">
                            <!-- Select Date To View Sales Tracking -->
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Product ID</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Product Quantity</th>
                                       
                                        <th class="hidden-xs text-center">Unit Price</th>
                                        <th class="hidden-xs text-center">Total Price</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalprice = 0; ?>
                                    <?php $i = 1;?>
                                    @foreach($orders as $key=>$data)
                                    <tr>
                                        <td class="hidden-xs text-center">{{$i++}}</td>
                                        <td class="hidden-xs text-center">{{$data->ProductID}}</td>
                                        <td class="hidden-xs text-center">{{$data->Name}}</td>
                                        <td class="hidden-xs text-center">{{$data->ProductQuantity}}</td>
                                        <td class="hidden-xs text-center">{{$data->Price}}</td>
                                        <td class="hidden-xs text-center">{{$data->Total_Amount}}</td>
                                        <?php $totalprice += $data->Total_Amount; ?>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>
                            <div class="block">
                            <div class="block-content">
                            <div style="text-align: right;float: right;border-top: solid 1px whitesmoke;margin-top: 10px;">
                                    <table width="100%" style="margin-top: 10px;margin-bottom: 10px">
                                        <tr>
                                            <th style="text-align: right;padding-right: 20px">Total:</th>
                                            <th style="text-align: right">${{$totalprice}}</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: right;padding-right: 20px">Discount:</th>
                                            <th style="text-align: right"></th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: right;padding-right: 20px">Net Amount:</th>
                                            <th style="text-align: right"></th>
                                        </tr>
                                    </table>
                            </div>
                           </div>
                        </div>
                    </div>
                    </div>

                    <!-- END All Orders -->
                </div>
                <!-- END Page Content -->
                </html> 

                <script >
                $(document).ready(function(){   
                    $(function(){  
                        $("#from_date").datepicker();  
                        $("#to_date").datepicker();  
                    });  
                 }); 
                </script>
                
            <!-- END Main Container -->
@endsection 