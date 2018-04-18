<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            {{Form::open(array('route' => 'addUser','method'=>'POST'))}}
            <div class="box-header bg-blue-gradient">
                <div class="row">
                    <div class="col-xs-6">
                        <h3 class="box-title">Add User</h3>
                    </div>
                    <div class="col-xs-10">
                    </div>
                </div>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
           <div class="col-md-12 form-group">
                    <label  class="control-label">Name</label>
                    {{Form ::text('name',null,['class'=>'form-control','rows'=>'6'])}}
                 </div>
                    <div class="col-md-12 form-group">
                    <label  class="control-label">Password</label>
                    {{Form ::text('password',null,['class'=>'form-control','rows'=>'6'])}}
                 </div>
           
            <div class="col-md-12 form-group">
                    <label  class="control-label">Email</label>
                    {{Form ::text('email',null,['class'=>'form-control','rows'=>'6'])}}
                 </div>
                  <div class="col-md-12 form-group">
                    <label  class="control-label">Role</label>
                    {{Form ::text('role',null,['class'=>'form-control','rows'=>'6'])}}
                    
                 </div>
                 <div class="col-md-12 form-group">
                    <label  class="control-label">Ratings</label>
                    {{Form ::textarea('u_rating',null,['class'=>'form-control','rows'=>'6'])}}
                    
                 </div>
            <!-- /.box-body -->
            <div class="box-footer text-right bg-gray-light">
                <a href="{{route('viewUser')}}" class="btn btn-default btn-sm btn-flat">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm btn-flat">Save</button>
            </div>
            {{Form::close()}}
        </div>
            </div>
    </div>
</div>
