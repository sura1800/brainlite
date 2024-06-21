<div>
    @if(\Session::has('success'))
    <div class="text-success pt-3 text-green-700">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
    @endif

    @if(\Session::has('error'))
    <div class="text-danger pt-3 ">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
    @endif

    @if ($errors->any())
    <div class="text-danger pt-3 text-red-600">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>