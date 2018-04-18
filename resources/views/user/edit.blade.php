<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header bg-blue-gradient">
                <div class="row">
                    <div class="col-xs-4">
                        <h3 class="box-title">Edit User</h3>
                    </div>
                    <div class="col-xs-8">
                    </div>
                </div>  
            </div>
     <table class="table table-bordered">
        
         <tr>

    {{Form::open(['route' => ['editUser','id'=>$data->id],'method'=>'POST'])}}
         <div class="box-body">
                <div class="col-md-12 form-group">
                    <label  class="control-label">Nama</label>
                    {{Form ::text('name',$data->name,['class'=>'form-control'])}}
                </div>
               
                <div class="col-md-12 form-group">
                    <label  class="control-label">Email</label>
                    {{Form ::text('email',$data->email,['class'=>'form-control'])}}
                </div>
            
           <div class="col-md-12 form-group">
                    <label  class="control-label">Password</label>
                    {{Form ::text('password',$data->password,['class'=>'form-control'])}}
                </div>
             
          <div class="col-md-12 form-group">
                    <label  class="control-label">Rating</label>
                    {{Form ::textarea('u_rating',$data->u_rating,['class'=>'form-control'])}}
                </div>

        <div class="col-md-12 form-group">
                    <label  class="control-label">Role</label>
                    {{Form ::textarea('role',$data->role,['class'=>'form-control'])}}
                </div>
         
                        </div>
         </div>
          <div class="box-footer text-right bg-gray-light">
                <a href="{{route('viewUser')}}" class="btn btn-default btn-sm btn-flat">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm btn-flat">Save</button>
            </div>
    {{Form::close()}}
             
</tr>  