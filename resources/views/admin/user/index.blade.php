@extends('admin.layouts.master')
@section('main_content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Users</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <form action="" method="get" enctype="multipart/form-data">@csrf
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_name">User's Name</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" value="@if(isset($_GET['user_name'])){{$_GET['user_name']}}@endif">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email ID</label>
                                        <input type="text" class="form-control" id="email" name="email" value="@if(isset($_GET['email'])){{$_GET['email']}}@endif">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone">Phone No</label>
                                        <input type="number" class="form-control" id="phone" name="phone" value="@if(isset($_GET['phone'])){{$_GET['phone']}}@endif">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="aadhaar">Aadhaar No</label>
                                        <input type="number" class="form-control" id="aadhaar" name="aadhaar" value="@if(isset($_GET['aadhaar'])){{$_GET['aadhaar']}}@endif">
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

                <div class="col-12 mt-3">
                    <div class="card">
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

                            <table id="" class="table table-bordered table-striped mt-2">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Username</th>
                                        <th>Student Name</th>
                                        <th>Aadhaar No</th>
                                        <th>Phone No</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($users) > 0)
                                        @foreach($users as $key=>$user)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->aadhaar }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ date('d-m-Y',strtotime($user->created_at))}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                            <tr>
                                                <th colspan="8" class="text-center">No data found</th>
                                            </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex mt-2 float-right">
                                    {{$users->links()}}
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

<script>
    $(".reset").click(function(){
        window.location.href = "{{route('admin.users.index')}}";
    })
</script>

@endsection
