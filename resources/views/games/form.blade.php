{!! \Form::text('name', 'Name') !!}
{!! \Form::text('url', 'Url') !!}
{!! \Form::text('callback_url', 'Callback Url For Votes') !!}
{!! \Form::textarea('description', 'Description') !!}
{!! \Form::select('category_id', 'Category', $categories, $game->category->slug ?? "none__") !!}
{!! Form::text('tags', 'Tags (comma seperated)') !!}
{!! Form::file('banner_image', 'Banner Image') !!}
@include('partials.dropzone')

@push('scripts')
    <script src="{{ asset('/js/selectize.min.js') }}"></script>
    <script>
        $('#inp-tags').selectize({

            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                }
            }
        });
    </script>
@endpush
