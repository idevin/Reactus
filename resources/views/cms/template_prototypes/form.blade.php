{{ Form::model($form, ['url' => route($action, ['template_prototypes' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical']) }}

<div class="form-group clearfix">
    {{ Form::label('template_id', 'Шаблон', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('template_id', $templates, $form->template_id, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('name', $form->name, ['class' => 'form-control', 'id' => 'title']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('name', 'Добавить строку', ['class' => 'col-sm-2 control-label required']) }}

    @foreach($positionOptions as $positionName => $index)
        &nbsp;@include('cms.template_prototypes._blocks')
    @endforeach

</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
{{ Form::close() }}


@section('scripts')
    <script>
        $(function () {
            $('a.add_module').on('click', function () {
                let moduleSelect = $(this).parent().find('select');
                let moduleValue = moduleSelect.val();

                let sortOrder = $(this).parent().find('[type="number"]').val();

                if (moduleValue === "") {
                    alert('Выберите модуль...');
                } else {
                    let href = $(this).attr('href');
                    let hrefQuery = '&module_id=' + moduleValue + '&sort_order=' + sortOrder;
                    window.location.href = href + hrefQuery;
                }

                return false;
            });

            $('a.add_stroke').on('click', function () {
                let sortOrder = $(this).parent().parent().find('[type="number"]').val();
                let href = $(this).attr('href');
                window.location.href = href + '&sort_order=' + sortOrder;
                return false;
            });
        });
    </script>
@endsection
