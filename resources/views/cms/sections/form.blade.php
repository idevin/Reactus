{{ Form::model($form, ['url' => route($action, ['site_id' => $site->id, 'sections' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true]) }}

<div class="form-group clearfix">
    {{ Form::label('title', 'Название', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('title', $form->title, ['class' => 'form-control', 'id' => 'title']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('parent_id', 'Родитель', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::select('parent_id', $sections, $form->parent_id,['class' => 'form-control', 'id' => 'parent_id']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('content', 'Контент', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::textarea('content',  $form->content, ['class' => 'form-control', 'id' => 'content']) }}
    </div>
</div>

<div class="form-group clearfix">
    {{ Form::label('tags', 'Метки (через запятую)', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-10">
        {{ Form::text('tags', !empty($tags) ? $tags : null, ['class' => 'form-control', 'id' => 'tags', 'data-role'=>"tagsinput"]) }}
    </div>
</div>

<hr>

<div class="form-group clearfix">
    {{ Form::label('filter_articles', 'Фильтр статей', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-1">
        {{ Form::checkbox('filter_articles', 1, $form->filter_articles, ['id' => 'filter_articles']) }}
    </div>

    <div class="col-sm-3">
        {{Form::select('filter_articles_sort', \App\Models\Article::$sortOptions, $settings->filter_articles_sort)}}
    </div>

    <div class="col-sm-2">
        {{Form::select('filter_articles_sort_direction', collect(\App\Models\Article::$directions)->map(function($direction){
        return [$direction => $direction];
        }), $settings->filter_articles_sort_direction)}}
    </div>

    <div class="col-sm-2">
        {{Form::select('filter_articles_view', \App\Models\Article::$viewOptions, $settings->filter_articles_view)}}
    </div>

    <div class="col-sm-2">
        {{Form::select('articles_limit', \App\Models\Article::$limits, $settings->articles_limit)}}
    </div>

</div>

<hr>

<div class="form-group clearfix">
    {{ Form::label('filter_sections', 'Фильтр Разделов', ['class' => 'col-sm-2 control-label required']) }}

    <div class="col-sm-1">
        {{ Form::checkbox('filter_sections', 1, $settings->filter_sections, ['id' => 'filter_sections']) }}
    </div>

    <div class="col-sm-3">
        {{Form::select('filter_sections_sort', \App\Models\Section::$sortOptions, $settings->filter_sections_sort)}}
    </div>

    <div class="col-sm-2">
        {{Form::select('filter_sections_sort_direction', collect(\App\Models\Section::$directions)->map(function($direction){
        return [$direction => $direction];
        }), $settings->filter_sections_sort_direction)}}
    </div>

    <div class="col-sm-2">
        {{Form::select('filter_sections_view', \App\Models\Section::$viewOptions, $settings->filter_sections_view)}}
    </div>

    <div class="col-sm-2">
        {{Form::select('sections_limit', \App\Models\Section::$limits, $settings->sections_limit)}}
    </div>

</div>

<hr>

<div class="btn-toolbar" role="toolbar">
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

{{ Form::close() }}

@section('scripts')
    <script>
        $(function () {
            $('#tags').tagsinput({
                trimValue: true
            });
        });
    </script>
@endsection

<style>
    .bootstrap-tagsinput {
        display: block;
    }
</style>