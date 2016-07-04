<!-- small box -->
<div class="small-box bg-{{$color or "yellow"}}">
    <div class="inner">
        <h3>{!! $data or "Null" !!}</h3>

        <p>{{$desc or "An error happened."}}</p>
    </div>
    <div class="icon">
        <i class="ion {{$icon or ""}}"></i>
    </div>
    <a href="{!! $link !!}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>