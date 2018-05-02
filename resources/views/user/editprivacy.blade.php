@extends('layouts.profile')

@section('contentprofile')
                    
                    <div class="block">
                            <ul class="nav nav-tabs nav-justified push-20" data-toggle="tabs">
                                <li class="active">
                                    <a href="{{route('viewEditUserPersonal',['id'=>$data->id])}}"><i class="fa fa-fw fa-pencil"></i> Personal</a>
                                </li>
                                <li>
                                    <a href="{{route('viewEditUserPrivacy',['id'=>$data->id])}}"><i class="fa fa-fw fa-lock"></i> Privacy</a>
                                </li>
                            </ul>

                    {{Form::open(['route' => ['editUserPrivacy','id'=>$data->id],'method'=>'POST'])}}
                            <div class="block-content tab-content">
                               
                                 <!-- Privacy Tab -->
                                
                                    <div class="row items-push">
                                        <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="profile-password">Password</label>
                                                    {!! Form::password("password",null,["class"=>"form-control",'rows'=>'6']) !!}
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="profile-password-new">Role</label>
                                                    {!! Form::select("role",['Admin'=>'Admin','Agent'=>'Agent','Customer'=>'Customer'],null,["class"=>"form-control",'rows'=>'6']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label for="profile-password-new-confirm">Active</label>
                                                    {!! Form::checkbox("status",$data->status,1,null,["style"=>"width:25px;height:25px"]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                <!-- END Password Tab -->
                            </div>
                            <div class="block-content block-content-full bg-gray-lighter text-center">
                                <a href="{{route('viewUser')}}" <button class="btn btn-sm btn-danger" type="submit">Back</button></a>
                                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check push-5-r"></i> Save Changes</button>
                                <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-refresh push-5-r"></i> Reset</button>
                            </div>
                        </div>
                    {{Form::close()}}
                    <!-- END Main Content -->
                </div>
               
@endsection 