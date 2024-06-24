@extends('front.adminlayout.master')
@section('main_content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-12 mt-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                            <h3 class="card-title">Daily Entries</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <form action="" method="get" enctype="multipart/form-data" class="form-data">@csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="batch_id">Batch</label>
                                        <select class="form-control" id="batch_id" name="batch_id">
                                            <option value="">Choose..</option>
                                            @foreach($batches as $batch)
                                               <option value="{{$batch->batch_id}}"
                                                @php
                                                    if(isset($_GET['batch_id']) && $_GET['batch_id'] == $batch->batch_id ){echo 'selected'; }
                                                @endphp >
                                                {{$batch->batch_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tcid_id">TC ID</label>
                                        <select class="form-control" id="tcid_id" name="tcid_id">
                                            <option value="">Choose..</option>
                                            @foreach($tcids as $tcid)
                                            <option value="{{$tcid->tcid_id}}"
                                            @php
                                                if(isset($_GET['tcid_id']) && $_GET['tcid_id'] == $tcid->tcid_id ){echo 'selected'; }
                                            @endphp >
                                            {{$tcid->tcid}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="job_role">Job Role</label>
                                        <select class="form-control" id="job_role" name="job_role_id">
                                            <option value="">Choose..</option>
                                            @foreach($job_roles as $job_role)
                                            <option value="{{$job_role->job_role_id}}"
                                            @php
                                                if(isset($_GET['job_role_id']) && $_GET['job_role_id'] == $job_role->job_role_id ){echo 'selected'; }
                                            @endphp >
                                            {{$job_role->job_role_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sector">Sector</label>
                                        <select class="form-control" id="sector" name="sector_id">
                                            <option value="">Choose..</option>
                                            @foreach($sectors as $sector)
                                            <option value="{{$sector->sector_id}}"
                                            @php
                                                if(isset($_GET['sector_id']) && $_GET['sector_id'] == $sector->sector_id ){echo 'selected'; }
                                            @endphp>
                                            {{$sector->sector_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="entry_date">Entry Date</label>
                                        <input type="date" class="form-control" id="entry_date" name="entry_date" value="@if(isset($_GET['entry_date'])){{$_GET['entry_date']}}@endif" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                        <button type="reset" class="btn btn-danger float-right mr-2 reset"> Reset </button>
                                        <button type="submit" class="btn btn-dark float-right mr-2"><i class="nav-icon fas fa-search"></i> Filter </button>
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
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
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

                            <a href="{{route('daily-entries.create')}}"><button type="button" class="btn btn-dark mr-3 float-right"> <i class="nav-icon fas fa-plus"></i> Daily Entry</button></a><br><br>
                                <table id="" class="table table-bordered table-striped data-table">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Batch Name</th>
                                            <th>TC ID</th>
                                            <th>Job Role Name</th>
                                            <th>Sector</th>
                                            <th>Entry Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($entries) > 0)
                                        @foreach($entries as $key=>$entry)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$entry->batch_name}}</td>
                                                    <td>{{$entry->tcid}}</td>
                                                    <td>{{$entry->job_role_name}}</td>
                                                    <td>{{$entry->sector_name}}</td>
                                                    <td>{{date('d-m-Y',strtotime($entry->entry_date))}}</td>
                                                    <td>
                                                         <a href="{{route('daily-entries.show',$entry)}}"><button type="button" class="btn btn-warning m-1"><i class="nav-icon fas fa-eye"></i></button></a>
                                                    </td>
                                                </tr>
                                        @endforeach

                                    @else
                                        <tr>
                                            <th colspan="7" class="text-center">No data found</th>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                                <div class="d-flex mt-2 float-right">
                                    {{$entries->links()}}
                                </div>

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
<script>

    $(".reset").click(function(){
        window.location.href = "{{route('daily-entries.index')}}";
    })
</script>

@endsection
