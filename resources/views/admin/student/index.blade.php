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
                                <h3 class="card-title">Students</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <form action="" method="get" enctype="multipart/form-data">@csrf
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="student_name">Student Name</label>
                                        <input type="text" class="form-control" id="student_name" name="student_name" value="@if(isset($_GET['student_name'])){{$_GET['student_name']}}@endif">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No</label>
                                        <input type="number" class="form-control" id="mobile_no" name="mobile_no" value="@if(isset($_GET['mobile_no'])){{$_GET['mobile_no']}}@endif">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="candidate_reg_id">Candidate Reg ID</label>
                                        <input type="text" class="form-control" id="candidate_reg_id" name="candidate_reg_id" value="@if(isset($_GET['candidate_reg_id'])){{$_GET['candidate_reg_id']}}@endif">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tp_id">TP ID</label>
                                        <input type="text" class="form-control" id="tp_id" name="tp_id" value="@if(isset($_GET['tp_id'])){{$_GET['tp_id']}}@endif">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="batch_id">Batch ID</label>
                                        <input type="text" class="form-control" id="batch_id" name="batch_id" value="@if(isset($_GET['batch_id'])){{$_GET['batch_id']}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="acadamic_year">Acadamic Year</label>
                                        <input type="text" class="form-control" id="acadamic_year" name="acadamic_year" value="@if(isset($_GET['acadamic_year'])){{$_GET['acadamic_year']}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="qp_code">Qp Code</label>
                                        <input type="text" class="form-control" id="qp_code" name="qp_code" value="@if(isset($_GET['qp_code'])){{$_GET['qp_code']}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="aadhar_no">Aadhar No</label>
                                        <input type="number" class="form-control" id="aadhar_no" name="aadhar_no" value="@if(isset($_GET['aadhar_no'])){{$_GET['aadhar_no']}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <button type="submit" class="btn btn-lg btn-info mt-4 float-right"> Filter </button>
                                </div>

                            </div>

                        </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-12">
                    <div class="card">
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

                            <!-- @php
                                print_r($_GET);
                            @endphp -->

                            <button type="button" class="btn btn-primary mr-3" data-toggle="modal" data-target="#exampleModal">Upload File <i class="nav-icon fas fa-upload"></i></button>
                            <a href="{{url('admin/student-export/'.json_encode($_GET))}}"><button type="button" class="btn btn-warning">Download File <i class="nav-icon fas fa-download"></i></button></a>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Username</th>
                                        <th>Student Name</th>
                                        <th>Candidate Reg ID</th>
                                        <th>Mobile No</th>
                                        <th>Aadhaar No</th>
                                        <th>Acadamic Year</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($students as $key=>$student)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $student->username }}</td>
                                                <td>{{ $student->student_name }}</td>
                                                <td>{{ $student->candidate_reg_id }}</td>
                                                <td>{{ $student->mobile_no }}</td>
                                                <td>{{ $student->aadhar_no }}</td>
                                                <td>{{ $student->acadamic_year }}</td>
                                                <td>
                                                    <a href="{{route('admin.students.show',$student)}}"><button type="button" class="btn btn-success" title="show"><i class="nav-icon fas fa-eye"></i></button></a>
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

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Excel File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{route('admin.students.store')}}" method="post" enctype="multipart/form-data"> @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="excel_file">Upload File </label>
                                            <input type="file" class="form-control" id="excel_file" name="excel_file" required >
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary">submit</button>
            </div>
        </form>
    </div>
  </div>
</div>

@endsection
