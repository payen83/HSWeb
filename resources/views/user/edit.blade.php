@extends('layouts.app')

@section('content')


  <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="content content-boxed">
                    <!-- User Header -->
                    <div class="block">
                        <!-- Basic Info -->
                        <div class="bg-image" style="background-image: url('{{ asset('assets/img/photos/photo3@2x.jpg') }}');">
                            <div class="block-content bg-primary-op text-center overflow-hidden">
                                <div class="push-30-t push animated fadeInDown">
                                     @if($data->url_image == '')
                                    <img class="img-avatar img-avatar96 img-avatar-thumb" src="{{ asset('assets/img/avatars/avatar10.jpg') }}" alt="">
                                    @endif
                                    @if($data->url_image != '')
                                    <img class="img-avatar img-avatar96 img-avatar-thumb" src="{{ url('/') }}/upload/userpic/<?php echo $data->url_image; ?>" alt="">
                                    @endif
                                </div>
                                <div class="push-30 animated fadeInUp">
                                    <h2 class="h4 font-w600 text-white push-5">{{$data->name}}</h2>
                                    <h3 class="h5 text-white-op">{{$data->role}}</h3>
                                </div>
                            </div>
                        </div>
                        <!-- END Basic Info -->

                        <!-- Stats -->
                        <div class="block-content text-center">
                            <div class="row items-push text-uppercase">
                                @if($data->role == 'Merchant')
                                <div class="col-xs-6">
                                    <div class="font-w700 text-gray-darker animated fadeIn">Sales</div>
                                    @foreach($trans as $key=>$input)
                                    @if($input->jumlah == '')
                                    <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">RM 0</a>
                                    @endif
                                    @if($input->jumlah != '')
                                    <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">RM {{$input->jumlah}}</a>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-xs-6">
                                    <div class="font-w700 text-gray-darker animated fadeIn">Products</div>
                                    @foreach($product as $key=>$products)
                                    <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">{{$products->numberofproduct}}</a>
                                    @endforeach
                                </div>
                                @endif
                                @if($data->role == 'Agent')
                                <div class="col-xs-6 col-sm-3">
                                    <div class="font-w700 text-gray-darker animated fadeIn">Sales</div>
                                    @foreach($trans as $key=>$input)
                                    @if($input->jumlah == '')
                                    <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">RM 0</a>
                                    @endif
                                    @if($input->jumlah != '')
                                    <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">RM {{$input->jumlah}}</a>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="font-w700 text-gray-darker animated fadeIn">Products</div>
                                    @foreach($inventory as $key=>$inventorys)
                                    <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">{{$inventorys->numberofagentproduct}}</a>
                                    @endforeach
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="font-w700 text-gray-darker animated fadeIn">Agent Ratings</div>
                                    @foreach($rate as $key=>$agentrate)
                                    <div class="text-warning push-10-t animated flipInX">
                                     <div class="js-rating" data-score="{{$agentrate->u_rating}}"></div>
                                    </div>

                                    @endforeach
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="font-w700 text-gray-darker animated fadeIn">Completed Jobs</div>
                                    @foreach($numjob as $key=>$job)
                                     <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">{{$job->count_job}}</a>

                                    @endforeach
                                </div>
                                 <div>
                                    <div class="font-w700 text-gray-darker animated fadeIn">Cancel Jobs</div>
                                    @foreach($canceljob as $key=>$cancel)
                                     <a class="h2 font-w300 text-primary animated flipInX" href="javascript:void(0)">{{$cancel->count}}</a>

                                    @endforeach
                                </div>
                                @endif
                            </div>
                           
                        </div>
                        <!-- END Stats -->
                    </div> 
                    <!-- END User Header -->

                    <!-- Main Content -->
                        {{Form::open(['route' => ['editUser','id'=>$data->id],'method'=>'POST'])}}
                        @csrf
                        <div class="block">
                            <ul class="nav nav-tabs nav-justified push-20" data-toggle="tabs">
                                <li class="active">
                                    <a href="#tab-profile-personal"><i class="fa fa-fw fa-pencil"></i> Personal</a>
                                </li>
                               
                                <li>
                                    <a href="#tab-profile-privacy"><i class="fa fa-fw fa-lock"></i> Privacy</a>
                                </li>
                            </ul>

                            <div class="block-content tab-content">
                                <!-- Personal Tab -->
                                <div class="tab-pane fade in active" id="tab-profile-personal">
                                    <div class="row items-push">
                                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                           <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label>Name</label>
                                                   {{Form ::text('name',$data->name,['class'=>'form-control','rows'=>'6'])}}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="profile-email">Email Address</label>
                                                    {{Form ::text('email',$data->email,['class'=>'form-control','rows'=>'6'])}}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="profile-email">Identification Number</label>
                                                    {{Form ::text('icnumber',$data->icnumber,['class'=>'form-control','rows'=>'6'])}}
                                                </div>
                                            </div>

                                             <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="profile-email">Phone Number</label>
                                                    {{Form ::text('u_phone',$data->u_phone,['class'=>'form-control','rows'=>'6'])}}
                                                </div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="profile-bio">Address</label>
                                                   {{Form ::textarea('u_address',$data->u_address,['class'=>'form-control','rows'=>'6'])}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Personal Tab -->

                                <!-- Privacy Tab -->
                                <div class="tab-pane fade" id="tab-profile-privacy">
                                    <div class="row items-push">
                                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                           <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="profile-password">Password</label>
                                                    <!--{!! Form::password("password",null,["class"=>"form-control",'rows'=>'6']) !!}-->
                                                    {{ Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control' ) ) }}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="profile-password">Confirm Password</label>
                                                    <!--{!! Form::password("password",null,["class"=>"form-control",'rows'=>'6']) !!}-->
                                                    {{ Form::password('', array('placeholder'=>'Confirm Password', 'class'=>'form-control' ) ) }}
                                                </div>
                                            </div>
                                            <br>
                                            @if(Auth::user()->role == 'SuperAdmin')
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for=role">Role</label>
                                                    {!! Form::select("role",['SuperAdmin'=>'SuperAdmin','Admin'=>'Admin','Agent'=>'Agent','Customer'=>'Customer'],$data->role,["class"=>"form-control",'rows'=>'6']) !!}
                                                </div>
                                            </div>
                                            @endif
                                            @if(Auth::user()->role == 'Admin')
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for=role">Role</label>
                                                    {!! Form::select("role",['Admin'=>'Admin','Agent'=>'Agent','Customer'=>'Customer'],$data->role,["class"=>"form-control",'rows'=>'6']) !!}
                                                </div>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="status">Active</label>
                                                    {!! Form::checkbox("status",1,$data->status,["style"=>"width:25px;height:25px"]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Privacy Tab -->
                            </div>
                            <div class="block-content block-content-full bg-gray-lighter text-center">
                                @if(Auth::user()->role == 'SuperAdmin')
                                <a href="{{url('/user/viewlist-superadmin')}}" <button class="btn btn-sm btn-danger" type="submit">Back</button></a>
                                @endif
                                @if(Auth::user()->role == 'Admin')
                                <a href="{{url('/user/viewlist-admin')}}" <button class="btn btn-sm btn-danger" type="submit">Back</button></a>
                                @endif
                                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check push-5-r"></i> Save Changes</button>
                                <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-refresh push-5-r"></i> Reset</button>
                            </div>
                        </div>
                    {{Form::close()}}
        <!-- END Main Content -->
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->

        <!-- Apps Modal -->
        <!-- Opens from the button in the header -->
        <div class="modal fade" id="apps-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-sm modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <!-- Apps Block -->
                    <div class="block block-themed block-transparent">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Apps</h3>
                        </div>
                        <div class="block-content">
                            <div class="row text-center">
                                <div class="col-xs-6">
                                    <a class="block block-rounded" href="base_pages_dashboard.html">
                                        <div class="block-content text-white bg-default">
                                            <i class="si si-speedometer fa-2x"></i>
                                            <div class="font-w600 push-15-t push-15">Backend</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6">
                                    <a class="block block-rounded" href="bd_dashboard.html">
                                        <div class="block-content text-white bg-modern">
                                            <i class="si si-rocket fa-2x"></i>
                                            <div class="font-w600 push-15-t push-15">Boxed</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Apps Block -->
                </div>
            </div>
        </div>
        <!-- END Apps Modal -->

     
@endsection 