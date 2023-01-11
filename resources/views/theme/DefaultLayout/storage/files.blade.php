@if(count($files) > 0)
    @foreach($files as $file)
        @include(theme('storage.file'))
    @endforeach
@else
    <div class="row">
        <div class="col-sm-12">
            <div align="center">Файлов не найдено...</div>
        </div>
    </div>
@endif