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
                                <li>User Management</li>
                                <li><a class="link-effect" href="#">User Details</a></li>
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
                            <a href="{{route('viewAddUser')}}"<button class="btn btn-success push-5-r push-10" type="button"><i class="fa fa-plus"></i> Add User</button></a>
                            </ul>
                            <h3 class="block-title">User Details</h3>
                        </div>
                        <div class="block-content">
                            <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->

                            <table class="table table-bordered table-striped js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Name</th>
                                        <th class="hidden-xs">Email</th>
                                        <th class="hidden-xs" style="width: 15%;">Role</th>
                                        <th class="hidden-xs" style="width: 15%;">Status</th>
                                        <th class="text-center" style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php $i = 1;?>
                                        @foreach($users as $key=>$data)
                                        
                                        <tr>
                                            <td align="center">{{$i++}}</td>
                                            <td class="">{{$data->name}}</td>
                                            <td class="hidden-xs hidden-sm">{{$data->email}}</td>
                                            <td class="hidden-xs hidden-sm">{{$data->role}}</td>
                                            <td align="center">
                                            {!!$data->status?"<i  style='color:green' class='glyphicon glyphicon-ok'></i>":"<i style='color: red'class='glyphicon glyphicon-remove'></i>"!!}
                                            </td>
                                            <td class="text-center">
                                           
                                            
                                            <form name ="frmdelete" action="{{route('deleteuser',['id'=>$data->id])}}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger push-5-r push-10" onclick="return myFunction()"><i class="fa fa-times"></i> Delete</button>
                                             <a href="{{route('viewEditUser',['id'=>$data->id])}}"<button class="btn btn-xs btn-success push-5-r push-10" type="button"><i class="fa fa-eye"></i> View</button></a>    
                                            
                                            </form>
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
 