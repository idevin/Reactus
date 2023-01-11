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

            @if (count($fields) > 0)

                <table class="table table-hover">
                    <thead>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'object_field_groups.index', 'alias' => 'id', 'name' => 'ID'])
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'object_field_groups.index', 'alias' => 'title', 'name' => 'Имя'])
                    </th>
                    <th>
                       Описание
                    </th>
                    <th>
                        @include('cms.partials.sort_field', ['route' => 'object_field_groups.index', 'alias' => 'sort_order', 'name' => '№ по порядку'])
                    </th>
                    <th>Действия</th>
                    </thead>
                    <tbody class="sortable" data-entityname="slider">
                    @foreach ($fields as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ truncate_content($item->description, 100) }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>
                                <a href="{{ route('object_field_groups.edit', ['object_field_group' => $item->id]) }}"
                                   class="btn btn-default"><i
                                            class="fas fa-pencil-alt"></i></a>

                                @if($item->id != config('netgamer.user_field_group'))
                                    <a href="{{ route('object_field_groups.destroy', ['object_field_group' => $item->id], false) }}"
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
                        @include('cms.partials.pagination')
                    </div>
                </div>

            @else
                <p class="alert alert-warning">Записей не найдено</p>
            @endif


        </div>
    </div>

@section('scripts')
 <!--
    <script language="javascript" type="text/javascript">
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
-->
@endsection

@stop