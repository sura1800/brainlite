
<div class="row">
    <div class="col-md-6">
        <h4 class="card-title">
            <span class="btn btn-info btn-sm"><i class="{{$icon_class}}"></i></span>
            {{$file_data[0]['noc_no']}}</h4>
    </div>
    <div class="col-md-6">
        <div class="d-flex justify-content-end">
            <span class="mr-2">{{$file_data[0]['datetime']}}</span>
            <img src={{$file_data[0]['qrimg']}} alt="">
        </div>        
    </div>

    <div class="col-md-12">
        <div>
            {{-- <div class="d-sm-inline-block d-block pr-1 pl-1 border-right"><label>{{__('Type')}}</label>: {{$type}}</div>
            <div class="d-sm-inline-block d-block pr-1 pl-1 border-right"><label>{{__('Size')}}</label>: {{$filesizenyteformat}}</div>
            @foreach ($file_data as $fd)
            <div class="d-sm-inline-block d-block pr-1 pl-1 border-right">{{$fd['label']}}<label>: {{$fd['value']}}</div>
            @endforeach --}}
                
        </div>
    </div>
</div>