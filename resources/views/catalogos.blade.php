<ul class="list-group list-group-flush">
    <li class="list-group-item d-flex justify-content-between align-items-center active">
        <h5>Catálogos</h5>
    </li>
    <a href="{{ route('usuarios.index') }}"
        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <div class="h5"> <i class="bi bi-lock mr-2"></i> Usuarios </div>
        <span class="badge badge-primary badge-pill">{{ $usuarios }} </span>
    </a>
    <a href="" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <div class="h5"> <i class="bi bi-diagram-2 mr-2"></i> Documento </div>
        <span class="badge badge-primary badge-pill">{{ $documentos }} </span>
    </a>
    <a href="" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <div class="h5"> <i class="bi bi-truck mr-2"></i> Servicios</div>
        <span class="badge badge-primary badge-pill">{{ $servicios}} </span>
    </a>
</ul>