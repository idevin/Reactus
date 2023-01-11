@if (session()->has('success'))
    <div class="alert alert-success" style="display: block;"><span class="glyphicon glyphicon-ok"></span>
        <em>{{ session('success') }}</em>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger" style="display: block;"><span class="glyphicon glyphicon-ok"></span>
        <em>{{ session('error') }}</em>
    </div>
@endif
