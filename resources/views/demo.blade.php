@extends("layouts.dashboard")

@section("content")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include("contents.title", ["home" => "Home", "partname" => "Dashboard"])
    @include("contents.main")
</div>
<!-- /.content-wrapper -->
@stop