@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
        <div class="d-flex flex-row">
            {!! \Form::open()->route('category.destroy', [$category])->delete() !!}
            <button type="submit" onclick="if(confirm('Are you sure you want to delete this') === false) return false" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-cross fa-sm text-white-50"></i> Delete this category</button>
            {!! \Form::close() !!}
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editing Category {{ $category->name }}</h6>
        </div>
        <div class="card-body">
            {!! \Form::open()->route('category.update', [$category])->fill($category)->put() !!}
            {!! \Form::text('name', 'Name') !!}
            {!! \Form::submit('Edit Category') !!}
            {!! \Form::close() !!}
        </div>
    </div>

@endsection