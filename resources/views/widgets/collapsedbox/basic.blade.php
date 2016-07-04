<div class="box box-{{ $color or "default" }} {{ empty($collapse) ? "collapsed-box" : "" }} {{ empty($solid) ? "" : "box-solid" }}">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $title or "Null" }}</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-{{ empty($collapse) ? "plus" : "minus" }}"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{ $content or "Null" }}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->