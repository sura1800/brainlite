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
                                <h3 class="card-title">Batches</h3>
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


                            <button type="button" class="btn btn-warning mr-3" data-toggle="modal" data-target="#exampleModal"> <i class="nav-icon fas fa-plus"></i> Add Batch</button>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Batch Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($batches as $key=>$batch)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $batch->batch_name }}</td>
                                                <td>{{ $batch->status =='Y' ?'Active':'Inactive' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success mr-3" onclick="editBatch('{{$batch->batch_id}}','{{$batch->batch_name}}','{{$batch->status}}')" title="edit"> <i class="nav-icon fas fa-pen"></i></button>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Batch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{route('admin.batches.store')}}" method="post" enctype="multipart/form-data"> @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="batch_name">Batch Name </label>
                                            <input type="text" class="form-control" id="batch_name" name="batch_name" placeholder="Enter Batch Name" required >
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Batch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{url('admin/batches/update')}}" method="post" enctype="multipart/form-data"> @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                                <div class="row">
                                    <input type="hidden" name="batch_id" id="batch_id">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="batch_name">Batch Name </label>
                                            <input type="text" class="form-control" id="batch_name1" name="batch_name" placeholder="Enter Batch Name" required >
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

function editBatch(batch_id,batch_name,status){
   // console.log(batch_id,batch_name,status);

    $("#batch_id").val(batch_id);
    $("#batch_name1").val(batch_name);
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
