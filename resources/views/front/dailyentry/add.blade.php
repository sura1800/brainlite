@extends('front.adminlayout.master')
@section('main_content')

<style>
        .preview {
            display: inline-block;
            margin: 10px;
        }
        .preview img {
            width: 240px;
            height: 200px;
            margin-right: 10px;
        }
</style>
<!-- Main content -->
<section class="content mt-4">
    <div class="container-fluid">
        <x-alert />
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Add Daily Entries</h3>
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
                                <input type="hidden" name="entry_date" value="{{date('Y-m-d')}}">
                                <input type="hidden" name="user_id" value="{{Auth::guard('front')->user()->id}}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="batch_id">Batch</label>
                                        <select class="form-control" id="batch_id" name="batch_id" required>
                                            <option value="">Choose..</option>
                                            @foreach($batches as $batch)
                                            <option value="{{$batch->batch_id}}">{{$batch->batch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tcid_id">TC ID</label>
                                        <select class="form-control" id="tcid_id" name="tcid_id" required>
                                            <option value="">Choose..</option>
                                            @foreach($tcids as $tcid)
                                            <option value="{{$tcid->tcid_id}}">{{$tcid->tcid}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_role">Job Role</label>
                                        <select class="form-control" id="job_role" name="job_role_id" required>
                                            <option value="">Choose..</option>
                                            @foreach($job_roles as $job_role)
                                            <option value="{{$job_role->job_role_id}}">{{$job_role->job_role_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sector">Sector</label>
                                        <select class="form-control" id="sector" name="sector_id" required>
                                            <option value="">Choose..</option>
                                            @foreach($sectors as $sector)
                                            <option value="{{$sector->sector_id}}">{{$sector->sector_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="file-input">Upload Images</label>
                                        <input type="file" class="form-control" id="file-input" name="images[]" multiple required>
                                    </div>
                                </div>

                                <div class="col-md-12" id="preview-container">

                                </div>

                            </div>

                            <button type="submit" class="btn btn-success mt-4">Submit</button>

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

<script>

$(document).ready(function(){
    $("#file-input").on("change", function(){
        var files = $(this)[0].files;
        $("#preview-container").empty();
        if(files.length > 0){
            for(var i = 0; i < files.length; i++){
                var reader = new FileReader();
                reader.onload = function(e){
                    $("<div class='preview'><img src='" + e.target.result + "'></div>").appendTo("#preview-container");
                };
                reader.readAsDataURL(files[i]);
            }
        }
    });

    // <br><button type='button' class='btn btn-danger delete mt-1'><i class='nav-icon fas fa-trash-alt'></i></button>
    // $("#preview-container").on("click", ".delete", function(){
    //     $(this).parent(".preview").remove();
    // });

});

</script>

@endsection
