 <!-- Main Container -->
            <main id="main-container">
                
                <!-- Page Content -->
                <div class="content">
                    <!-- My Block -->
                    <div class="block">
                        <div class="block-header">
                            <ul class="block-options">
                            <a href="{{route('viewAddUser')}}"<button class="btn btn-success push-5-r push-10" type="button"><i class="fa fa-plus"></i> Add User</button></a>
                            </ul>
                            <h3 class="block-title">User Management</h3>
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
                                        <th class="hidden-xs" style="width: 15%;">Ratings</th>
                                        <th class="text-center" style="width: 20%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php $i = 1;?>
                                        @foreach($users as $key=>$user)
                                        
                                        <tr>
                                            <td align="center">{{$i++}}</td>
                                            <td class="">{{$user->name}}</td>
                                            <td class="hidden-xs hidden-sm">{{$user->email}}</td>
                                            <td class="hidden-xs hidden-sm">{{$user->role}}</td>
                                            <td align="center">
                                            <td><div class="js-rating" data-score="3"></div></td>
                                            {!!$user->status?"<i  style='color:green' class='glyphicon glyphicon-ok'></i>":"<i style='color: red'class='glyphicon glyphicon-remove'></i>"!!}
                                            </td>
                                            <td class="text-center">
                                            <a href="{{route('viewEditUser',['id'=>$user->id])}}">edit<i class="splashy-document_letter_edit" data-toggle="tooltip" data-placement="top" data-title="Update"></i></a>
                                            <a href="#delete{{$user->id}}" data-toggle="modal"><i class="splashy-document_letter_remove" data-toggle="tooltip"data-placement="bottom" data-title="Remove"></i>delete</a></td>
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

              <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
        <script src="assets/js/core/jquery.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>
        <script src="assets/js/core/jquery.slimscroll.min.js"></script>
        <script src="assets/js/core/jquery.scrollLock.min.js"></script>
        <script src="assets/js/core/jquery.appear.min.js"></script>
        <script src="assets/js/core/jquery.countTo.min.js"></script>
        <script src="assets/js/core/jquery.placeholder.min.js"></script>
        <script src="assets/js/core/js.cookie.min.js"></script>
        <script src="assets/js/app.js"></script>

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

        <!-- Page JS Plugins -->
        <script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>

        <!-- Page JS Code -->
        <script src="assets/js/pages/base_tables_datatables.js"></script>

        <!-- Page Plugins -->
        <script src="assets/js/plugins/jquery-raty/jquery.raty.min.js"></script>

        <!-- Page JS Code -->
        <script src="assets/js/pages/base_comp_rating.js"></script>
 