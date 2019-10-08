{!! \Form::text('name', 'Name') !!}
{!! \Form::text('url', 'Url') !!}
{!! \Form::textarea('description', 'Description') !!}
{!! \Form::select('category_id', 'Category', $categories, $game->category->id ?? 'null') !!}
{!! Form::file('banner_image', 'Banner Image') !!}
@include('partials.dropzone')
