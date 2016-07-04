<div class="box box-{{ $color or "primary" }}">
    <div class="box-header with-border">
        {{-- Bar Chart --}}
        <h3 class="box-title">{{ $title or "Bar Chart Title" }}</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="chart">
            <canvas id="{{ $id or "barChart" }}" style="height:{{ $height or 250 }}px"></canvas>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->