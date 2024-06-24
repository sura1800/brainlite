@extends('admin.layouts.master')
@section('main_content')
<!-- Main content -->
<section class="content mt-4">
    <div class="container-fluid">
        <x-alert />
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">View Daily Entries</h3>
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
                        <form action="{{route('daily-entries.store')}}" method="post" enctype="multipart/form-data">@csrf
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">User Name</label>
                                        <select class="form-control" id="user_id" name="user_id" readonly>
                                            <option value="">Choose..</option>
                                            @foreach($customers as $customer)
                                               <option value="{{$customer->id}}" @if($entry_details->user_id == $customer->id) {{"selected"}} @endif >{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="entry_date">Entry Date</label>
                                        <input type="date" class="form-control" id="entry_date" name="entry_date" value="{{$entry_details->entry_date}}" readonly required/>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="batch_id">Batch</label>
                                        <select class="form-control" id="batch_id" name="batch_id" required readonly>
                                            <option value="">Choose..</option>
                                            @foreach($batches as $batch)
                                            <option value="{{$batch->batch_id}}" @if($entry_details->batch_id == $batch->batch_id) {{"selected"}} @endif>{{$batch->batch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tcid_id">TC ID</label>
                                        <select class="form-control" id="tcid_id" name="tcid_id" readonly required>
                                            <option value="">Choose..</option>
                                            @foreach($tcids as $tcid)
                                            <option value="{{$tcid->tcid_id}}"  @if($entry_details->tcid_id == $tcid->tcid_id) {{"selected"}} @endif >{{$tcid->tcid}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_role">Job Role</label>
                                        <select class="form-control" id="job_role" name="job_role_id" required readonly>
                                            <option value="">Choose..</option>
                                            @foreach($job_roles as $job_role)
                                            <option value="{{$job_role->job_role_id}}" @if($entry_details->job_role_id == $job_role->job_role_id) {{"selected"}} @endif >{{$job_role->job_role_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sector">Sector</label>
                                        <select class="form-control" id="sector" name="sector_id" required readonly>
                                            <option value="">Choose..</option>
                                            @foreach($sectors as $sector)
                                            <option value="{{$sector->sector_id}}" @if($entry_details->sector_id == $sector->sector_id) {{"selected"}} @endif >{{$sector->sector_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="images">Upload Images</label> <br>
                                   @php
                                        $images = json_decode($entry_details->images);
                                   @endphp
                                    <div style=" display: inline-block;margin: 10px;">
                                        @if(count($images) > 0)
                                                @foreach($images as $image)
                                                    <img src="{{url('upload/daily_entry/'.$image)}}" class="m-1" width="240px" height="200px">
                                                @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <!-- <button type="submit" class="btn btn-success mt-4">Submit</button> -->

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
