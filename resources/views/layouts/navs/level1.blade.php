<li>
    <a href="{{ $href or "#"}}">
        <i class="fa fa-{{ $symbol or "circle" }}"></i> <span>{{ $name }}</span>
        @if (isset($num))
        <small class="label pull-right bg-{{ $color or "red" }}">{{ $num }}</small>
        @endif
    </a>
</li>