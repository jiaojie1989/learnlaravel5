<li class="treeview {{ isset($active) ? (empty($active) ? "" : "active") : "" }}">
    <a href="#">
        <i class="fa fa-{{ $symbol or "dashboard" }}"></i>
        <span>{{ $name }}</span>
        @if(isset($num))
        <span class="label label-{{ $color or "primary" }} pull-right">{{ $num }}</span>
        @else
        <i class="fa fa-angle-left pull-right"></i>
        @endif
    </a>
    <ul class="treeview-menu">
        @foreach($children as $child)
        <li class="{{ isset($child["active"]) ? (empty($child["active"]) ? "" : "active") : "" }}"><a href="{{ $child["href"] or "#" }}"><i class="fa fa-{{ $child["symbol"] or "circle-o" }}"></i> {{ $child["name"] }}</a></li>
        @endforeach
    </ul>
</li>