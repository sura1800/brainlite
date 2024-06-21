@extends('front.adminlayout.master')
@section('main_content')

<!-- Main content -->
<section class="content mt-4">
    <div class="container-fluid">
        <x-alert />
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Show Student Details</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <!-- <h5>Custom Color Variants</h5> -->
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Username </label>
                                        <input type="text" class="form-control" id="username" name="username"  value="{{$student_details->username}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="student_name">Student Name</label>
                                        <input type="text" class="form-control" id="student_name" name="student_name"  value="{{$student_details->student_name}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No</label>
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no"  value='{{substr($student_details->mobile_no, 0,2) . "*****" . substr($student_details->mobile_no, 7, 4)}}' readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="candidate_reg_id">Candidate Reg ID</label>
                                        <input type="text" class="form-control" id="candidate_reg_id" name="candidate_reg_id"  value="{{$student_details->candidate_reg_id}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tp_id">TP ID</label>
                                        <input type="text" class="form-control" id="tp_id" name="tp_id"  value="{{$student_details->tp_id}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="project_type">Project Type</label>
                                        <input type="text" class="form-control" id="project_type" name="project_type"  value="{{$student_details->project_type}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sector">Sector</label>
                                        <input type="text" class="form-control" id="sector" name="sector"  value="{{$student_details->sector}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="batch_id">Batch ID</label>
                                        <input type="text" class="form-control" id="batch_id" name="batch_id"  value="{{$student_details->batch_id}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="acadamic_year">Acadamic Year</label>
                                        <input type="text" class="form-control" id="acadamic_year" name="acadamic_year"  value="{{$student_details->acadamic_year}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="qp_code">Qp Code</label>
                                        <input type="text" class="form-control" id="qp_code" name="qp_code"  value="{{$student_details->qp_code}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="job_role">Job Role</label>
                                        <input type="text" class="form-control" id="job_role" name="job_role"  value="{{$student_details->job_role}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="training_location">Training Location</label>
                                        <input type="text" class="form-control" id="training_location" name="training_location"  value="{{$student_details->training_location}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" id="state" name="state"  value="{{$student_details->state}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="aadhar_no">Aadhar No</label>
                                        <input type="text" class="form-control" id="aadhar_no" name="aadhar_no"  value='{{substr($student_details->aadhar_no, 0,2) . "*******" . substr($student_details->aadhar_no, 9, 3)}}' readonly>
                                    </div>
                                </div>


                            </div>

                        </form>

                        <!-- /.form-group -->
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->




    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->


@endsection
