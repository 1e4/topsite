{!! \Form::text('name', 'Name') !!}
{!! \Form::text('url', 'Url') !!}
{!! \Form::text('callback_url', 'Callback Url For Votes') !!}
{!! \Form::textarea('description', 'Description') !!}
{!! \Form::select('category_id', 'Category', $categories, $game->category->slug ?? "none__") !!}
{!! Form::file('banner_image', 'Banner Image') !!}
@include('partials.dropzone')
