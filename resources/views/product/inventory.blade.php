@extends('layouts.app')

@section('content')
           <!-- Main Container -->
            <main id="main-container">
             <!-- Page Header -->
                <div class="content bg-gray-lighter">
                    <div class="row items-push">
                        <div class="col-sm-7">
                            <h1 class="page-heading">
                                
                            </h1>
                        </div>
                        <div class="col-sm-5 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <li>Product</li>
                                <li><a class="link-effect" href="{{route('viewInventory')}}">Agent Product Inventory</a></li>
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
                            <h3 class="block-title">Agent Product Inventory</h3>
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                            
                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%;"></th>
                                        <th class="hidden-xs">Agent Details</th>
                                        <th class="text-center">Number Of Product</th>
                                        <th class="text-center" style="width: 20%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($inventories as $key=>$data)
                                    <tr>
                                        <td class="text-center">{{$i++}}</td>
                                        <td class="font-w600">{{$data->name}}    ({{$data->email}})</td>
                                        <td class="text-center">{{$data->NumberOfProducts}}</td>
                                      
                                        <td class="text-center" >
                                            <div class="btn-group">
                                                 <a href="{{route('viewInventoryDetails',['user_id'=>$data->user_id])}}"<button class="btn btn-xs btn-success push-5-r push-10" type="button"><i class="fa fa-eye"></i> View</button></a>
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
                    </div>
                    <!-- END My Block -->
                </div>
                 <!-- Footer -->
            <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
                <div class="pull-right">
                    ElyzianInteractive@2018
                </div>
               
            </footer>
            <!-- END Footer -->
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->

        <script>
        function myFunction() {
        var r = confirm('Are you sure want to delete record ?');
        
        if (r == true){
            document.frmdelete.submit();
            return true;
        }
        
        else
            return false;
         }
        </script>
@endsection 