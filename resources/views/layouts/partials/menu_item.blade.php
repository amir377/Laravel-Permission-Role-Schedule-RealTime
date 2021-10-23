@if($permission)
    <li class="nav-item">
        <a class="nav-link @if ($active) active @endif" @if ($active) aria-current="page" @endif href="{{ $link }}">
            <span data-feather="home"></span>
            {{ $label }}
        </a>
    </li>
@endif
