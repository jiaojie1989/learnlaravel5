@extends("layouts.dashboard")

@section("content")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include("contents.title", ["home" => "Home", "partname" => "Hello World"])
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @include("widgets.charts.line", ["height" => 600, "title" => "App Android Push Registers"])
            </div>
        </div>
    </section>
</div>

<!-- /.content-wrapper -->
@stop