{!! \Form::text('name', 'Name') !!}
{!! \Form::text('url', 'Url') !!}
{!! \Form::textarea('description', 'Description') !!}
{!! \Form::select('category_id', 'Category', $categories, $game->category->id ?? 'null') !!}
@include('partials.dropzone')
