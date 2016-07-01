@extends("layouts.plane")

@section("body")
<div class="wrapper">
    @include("layouts.top")
    @include("layouts.left")
    @yield("content")
    @include("layouts.footer")
    @include("layouts.control")
</div>
<!-- ./wrapper -->
@stop