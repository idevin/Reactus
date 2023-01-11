@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }}</h1>

            <div class="form-group">
                {!! $filter !!}
            </div>

            @include('cms.partials.flash')

            <div class="site-tree row">
                <div class="col-lg-12">
                    <form method="POST" action="{{route('form_groups.updateTree')}}" accept-charset="UTF-8"
                          class="datatree form-horizontal"
                          data-instance-id="00000000780ebfb70000000063d6abd4">
                        <div class="datatree-inner-wrapper">

                            <?php
                            $depth = 1;
                            ?>

                            @include('cms.form_groups.datatree')

                        </div>

                        <div class="datatree-values"></div>

                        <div class="btn-toolbar" role="toolbar">

                            {{--<div class="pull-left">--}}
                                {{--<input class="btn btn-primary" type="submit" value="Сохранить изменения">--}}
                            {{--</div>--}}

                        </div>
                        <br>

                        <input name="save_tree" type="hidden" value="1">
                    </form>
                </div>
            </div>


            @if (count($fields) > 0)

                <table class="table table-hover">
                    <thead>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'form_groups.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'form_groups.index', 'alias' => 'name', 'name' => 'Имя'])
                    </th>
                    </thead>
                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="{{ route('form_groups.edit', ['form_group' => $item->id]) }}"
                                   class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>

                                @if($item->id != config('netgamer.user_field_group'))
                                    <a href="{{ route('form_groups.destroy', ['form_group' => $item->id], false) }}"
                                       class="btn btn-danger btn-sm"
                                       data-method="delete" data-confirm="Точно удалить?"><i
                                                class="fa fa-times"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-12">
                        @if(count($fields) > 10)
                            @include('cms.partials.pagination')
                        @endif
                    </div>
                </div>
            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif


        </div>
    </div>

@section('scripts')
    <script>
        $(document).ready(function () {

            $('[data-instance-id="00000000780ebfb70000000063d6abd4"]').each(function () {
                var root = $(this);
                var form = root.find(".datatree-values");
                root.find(".datatree-inner-wrapper").nestable({
                    listNodeName: "ol",
                    itemNodeName: "li",
                    rootClass: "datatree-inner-wrapper",
                    listClass: "datatree-list",
                    itemClass: "datatree-item",
                    dragClass: "datatree-dragel",
                    handleClass: "datatree-handle",
                    collapsedClass: "datatree-collapsed",
                    placeClass: "datatree-placeholder",
                    noDragClass: "datatree-nodrag",
                    emptyClass: "datatree-empty",
                    expandBtnHTML: "<button data-action=\"expand\" type=\"button\">Expand</button>",
                    collapseBtnHTML: "<button data-action=\"collapse\" type=\"button\">Collapse</button>",
                    group: 0,
                    maxDepth: 5,
                    threshold: 20
                }).on("mousedown", "a", function (e) {
                    e.stopImmediatePropagation();
                }).each(function () {
                    var ol = $(this).children(".datatree-list");
                    if (ol.length) rapyd.datatree.updateDepth(ol);
                    rapyd.datatree.updateForm($(this), form, "items");
                }).on("change", function () {
                    var ol = $(this).children(".datatree-list");
                    if (ol.length) rapyd.datatree.updateDepth(ol);
                    var updated = rapyd.datatree.updateForm($(this), form, "items");
                });
                $(".datatree").submit(function () {
                    return $(this).attr("action") || document.location.href;
                });
            });
        });

    </script>

@endsection

@stop
