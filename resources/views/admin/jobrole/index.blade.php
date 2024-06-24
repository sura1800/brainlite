@extends('admin.layouts.master')
@section('main_content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Job Roles</h3>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">

                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif


                            <button type="button" class="btn btn-warning mr-3" data-toggle="modal" data-target="#exampleModal"> <i class="nav-icon fas fa-plus"></i> Add Job Role</button>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Job Role Name</th>
                                        <th>Job Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($roles as $key=>$role)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $role->job_role_name }}</td>
                                                <td>{{ $role->job_code }}</td>
                                                <td>{{ $role->status =='Y' ?'Active':'Inactive' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success mr-3" onclick="editBatch('{{$role->job_role_id}}','{{$role->job_role_name}}','{{$role->job_code}}','{{$role->status}}')" title="edit"> <i class="nav-icon fas fa-pen"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal -->

    <!--Add Batch Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Job Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{route('admin.job-roles.store')}}" method="post" enctype="multipart/form-data"> @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="job_role_name">Job Role Name </label>
                                            <input type="text" class="form-control" id="job_role_name" name="job_role_name" placeholder="Enter Job Role Name" required >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="job_code">Job Code </label>
                                            <input type="text" class="form-control" id="job_code" name="job_code" placeholder="Enter Job Code" required >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status">Status</label><br>
                                            &nbsp&nbsp<input type="radio" id="status" name="status" value="Y" checked /> Active  &nbsp &nbsp &nbsp
                                            <input type="radio" id="status" name="status" value="N" /> Inactive
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">submit</button>
            </div>
        </form>
    </div>
  </div>
</div>


<!--Edit Batch Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Job Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{url('admin/job-roles/update')}}" method="post" enctype="multipart/form-data"> @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                                <div class="row">
                                    <input type="hidden" name="job_role_id" id="job_role_id">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="job_role_name">Job Role Name </label>
                                            <input type="text" class="form-control" id="job_role_name1" name="job_role_name" placeholder="Enter Job Role Name" required >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="job_code">Job Code </label>
                                            <input type="text" class="form-control" id="job_code1" name="job_code" placeholder="Enter Job Code" required >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status">Status</label><br>
                                            &nbsp&nbsp<input type="radio" id="status1" name="status" value="Y" /> Active  &nbsp &nbsp &nbsp
                                            <input type="radio" id="status2" name="status" value="N"/> Inactive
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">submit</button>
            </div>
        </form>
    </div>
  </div>
</div>

<script>

function editBatch(role_id,role_name,job_code,status){
    $("#job_role_id").val(role_id);
    $("#job_role_name1").val(role_name);
    $("#job_code1").val(job_code);

    if(status =='Y'){
        $("#status1").attr('checked',true);
    }
    else{
        $("#status2").attr('checked',true);
    }
    $("#editModal").modal();
}

</script>

@endsection
