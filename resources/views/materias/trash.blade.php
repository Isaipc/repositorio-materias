@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.trash'))

@section('primary-title')
    <i class="bi bi-trash-fill"></i>
    {{ __('Materias eliminadas') }}
@endsection



@section('primary-content')
    <table id="materiasTrashDT" class="table table-hover table-responsive-md table-md mt-2 datatable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th></th>
            </tr>
        </thead>
    </table>
@endsection

@section('secondary-content')
    @include('materias.list')
@endsection
