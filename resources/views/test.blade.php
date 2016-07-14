@extends("layouts.dashboard")

@section("content")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include("contents.title", ["home" => "Home", "partname" => "Dashboard"])
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Table</h3>
                    </div>
                    <div class="box-body">
                        {!! $embed1 !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- /.content-wrapper -->
@stop