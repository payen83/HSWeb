@extends('layouts.app')

@section('content') 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />   -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
  

            <!-- Main Container -->
            <main id="main-container">
                        <!-- Page Content -->
                <div class="content">
                    <!-- My Block -->
                    <div class="block">
                        <div class="block-header">
                              <h3 class="block-title">Sales Tracking</h3>
                              <br>
                              <br>
                            <div class="col-sm-3 form-group">
                                    <div class="input-daterange input-group" data-date-format="dd/mm/yyyy">
                                            <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                            </span>
                                                <input class="form-control datepicker" type='text' class="form-control" name="form_date" id="from_date" placeholder="From Date" value="{{date('d-M-Y',strtotime('now'))}}"/>
                                    </div>
                            </div>
                            <div class="col-sm-3 form-group">
                                    <div class="input-daterange input-group" data-date-format="dd/mm/yyyy">
                                            <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                            </span>
                                                <input class="form-control datepicker" type='text' class="form-control" name="to_date" id="to_date" placeholder="To Date" value="{{date('d-M-Y',strtotime('now'))}}"/> 
                                     </div>
                            </div>
                            <button class="btn btn-primary push-5-r push-10" type="submit" name="filter" id="filter"><i class="si si-magnifier"></i>Submit</button></a>


                            <script>  
                                $('#from_date, #to_date').datepicker({
                                       dateFormat: "dd-mm-yy",
                                       
                                     }); 
                                   $('#filter').click(function(){  
                                        var from_date = $('#from_date').val();  
                                        var to_date = $('#to_date').val();  
                                        if(from_date != '' && to_date != '')  
                                        {  
                                             $.ajax({  
                                                  url:"{!! url('/sales-filter/{from_date,to_date}') !!}",  
                                                  method:"GET",  
                                                  data:{from_date:from_date, to_date:to_date},  
                                                  success:function(data)  
                                                  {  
                                                       $('#sale_table').html(data);  
                                                  }  
                                             });  
                                        }  
                                        else  
                                        {  
                                             alert("Please Select Date");  
                                        }  
                                   });  
                                
                         </script>
                            
                         
                            
                            
                        </div>
                        <div class="block-content">
                            <!-- Select Date To View Sales Tracking -->
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            <div id="sale_table">
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
                                        <td class="hidden-xs text-center">${{$data->Price}}</td>
                                        <td class="hidden-xs text-center">${{$data->Total_Amount}}</td>
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
                <!-- END Page Content -->
                
                
            <!-- END Main Container -->
@endsection 