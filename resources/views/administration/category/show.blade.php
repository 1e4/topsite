@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Viewing Category</h1>
        <div class="d-flex flex-row">
            <a href="{{ route('category.edit', $category) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-4"><i class="fas fa-pen fa-sm text-white-50"></i> Edit this category</a>
            {!! \Form::open()->route('category.destroy', [$category])->delete() !!}
            <button type="submit" onclick="if(confirm('Are you sure you want to delete this') === false) return false" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-cross fa-sm text-white-50"></i> Delete this category</button>
            {!! \Form::close() !!}
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Viewing "{{ $category->name }}"</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>Name</td>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <td>Slug</td>
                    <td>{{ $category->slug }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection