<div class="form-check form-switch">
    <input class="form-check-input change-status" type="checkbox" role="switch"
        @if ($r_item->estatus == 1) checked @endif @if ($r_item->isArchived()) disabled @endif
        data-id="{{ $r_item->id }}" data-url="/{{ $route }}">
</div>
