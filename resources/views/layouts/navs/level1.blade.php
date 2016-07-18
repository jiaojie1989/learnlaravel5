<li class="{{ isset($active) ? (empty($active) ? "" : "active") : "" }}">
    <a href="{{ $href or "#"}}">
        <i class="fa fa-{{ $symbol or "circle-o" }}"></i> <span>{{ $name }}</span>
        @if (isset($num))
        <small class="label pull-right bg-{{ $color or "red" }}">{{ $num }}</small>
        @endif
    </a>
</li>