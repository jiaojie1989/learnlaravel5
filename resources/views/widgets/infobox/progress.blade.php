<div class="info-box bg-{{ $background or "aqua" }}">
    <span class="info-box-icon"><i class="fa {{ $icon or "fa-bookmark-o" }}"></i></span>

    <div class="info-box-content">
        <span class="info-box-text">{{ $text or "Null" }}</span>
        <span class="info-box-number">{{ $number or "Null" }}</span>

        <div class="progress">
            <div class="progress-bar" style="width: {{ $progress or "50%" }}"></div>
        </div>
        <span class="progress-description">
            {{ $progress_desc or "Null" }}
        </span>
    </div>
    <!-- /.info-box-content -->
</div>