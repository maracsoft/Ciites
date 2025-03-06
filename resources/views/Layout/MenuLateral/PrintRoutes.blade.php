@foreach ($rutas as $key => $route)
  <li class="nav-item">
    <a href="{{ $route->url }}" class="nav-link">
      <i class="{{ $route->icon_class }} nav-icon"></i>
      <p>
        {{ $route->label }}
      </p>
    </a>
  </li>
@endforeach
