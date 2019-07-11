{{--<form method="post" action="{{url('/image/upload/store')}}" enctype="multipart/form-data"--}}
{{--      class="dropzone" id="dropzone">--}}
{{--    @csrf--}}
{{--</form>--}}
<div id="dropzone" class="dropzone"></div>
@push('scripts')
    <script src="{{ asset('/js/dropzone.min.js') }}"></script>
    <script type="text/javascript">

        // $(document).ready(function() {
        Dropzone.options.dropzone =
            {
                init: function () {

                    var mockFile = '',
                        thisDropzone = this;

                    @if(isset($images))
                            @foreach($images as $image)
                        mockFile = {name: '{{$image['name']}}', size: {{ $image['size'] }} }; // here we get the file name and size as response

                    thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                    thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "/images/" + '{{ $image['name'] }}');//uploadsfolder is the folder where you have all those uploaded files
                    thisDropzone.emit("complete", mockFile);

                    @endforeach
                    @endif
                },
                url: '{{ url('/image/upload/store') }}',
                maxFilesize: {{ $maxFilesize ?? 10 }},
                renameFile: function (file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                timeout: 5000,
                removedfile: function (file) {
                    if (file.hasOwnProperty('upload'))
                        var name = file.upload.filename;
                    else
                        var name = file.name;

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url("/image/delete") }}',
                        data: {filename: name},
                        success: function (data) {
                            console.log("File has been successfully removed!!");
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },

                success: function (file, response) {
                    $(".dropzone-form > form").append("<input type='hidden' name='images[]' value='" + response.success + "'>");
                },
                error: function (file, response) {
                    return false;
                }
            };
        // })

    </script>
@endpush