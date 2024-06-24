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
                                <h3 class="card-title">TC IDs</h3>
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


                            <button type="button" class="btn btn-warning mr-3" data-toggle="modal" data-target="#exampleModal"> <i class="nav-icon fas fa-plus"></i> Add TC ID</button>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>TC ID</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($tcids as $key=>$tcid)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $tcid->tcid }}</td>
                                                <td>{{ $tcid->status =='Y' ?'Active':'Inactive' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success mr-3" onclick="editBatch('{{$tcid->tcid_id}}','{{$tcid->tcid}}','{{$tcid->status}}')" title="edit"> <i class="nav-icon fas fa-pen"></i></button>
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
        <h5 class="modal-title" id="exampleModalLabel">Add TC ID</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{route('admin.tc_ids.store')}}" method="post" enctype="multipart/form-data"> @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tcid">TC ID </label>
                                            <input type="text" class="form-control" id="tcid" name="tcid" placeholder="Enter TC ID Name" required >
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
        <h5 class="modal-title" id="exampleModalLabel">Edit TC ID</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{url('admin/tc_ids/update')}}" method="post" enctype="multipart/form-data"> @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                                <div class="row">
                                    <input type="hidden" name="tcid_id" id="tcid_id">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tcid">TC ID </label>
                                            <input type="text" class="form-control" id="tcid1" name="tcid" placeholder="Enter TC ID" required >
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

function editBatch(tcid_id,tcid,status){
    $("#tcid_id").val(tcid_id);
    $("#tcid1").val(tcid);
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
