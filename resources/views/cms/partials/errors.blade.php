@if (isset($errors) && count($errors) > 0 && count($errors->all()) > 0)
    <div class="alert alert-danger" style="display: block;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="display: block;">
        <ul>
            <li>{{ session('error') }}</li>
        </ul>
    </div>
@endif
