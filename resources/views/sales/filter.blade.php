                        
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
                <!-- END Page Content -->
