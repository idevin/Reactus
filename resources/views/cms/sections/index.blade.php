@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

<style>
    .btn-toolbar {
        float: left;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }} сайта {{ $site->domain }}</h1>

            @include('cms.partials.flash')

            {{ Form::select('site_id', \App\Models\Site::getTreeOptions(null,true, true), $site->id, ['class' => "form-control", 'id' => 'site-select']) }}

            <hr>

            @if(count($treeData) > 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pull-right" style="margin-left: 10px;margin-bottom:10px;margin-right: 60px;">
                            выбрать все &mdash; <input type="checkbox" class="sowns">
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{route('sections.updateTree')}}" accept-charset="UTF-8"
                  class="datatree form-horizontal" data-instance-id="00000000780ebfb70000000063d6abd4">
                <div class="datatree-inner-wrapper">

                    <?php $depth = 1; ?>

                    @include('cms.sections.datatree')

                </div>

                <div class="datatree-values"></div>

                <div class="btn-toolbar" role="toolbar">

                    <div class="pull-left">
                        <a href="{{route('sections.create', ['site_id' => $site->id], false)}}"
                           class="btn btn-default">Создать</a>
                        <input class="btn btn-primary" type="submit" value="Сохранить изменения">
                    </div>
                </div>
                <br>
                <input name="save_tree" type="hidden" value="1">
                @if($site)
                    <input name="site_id" type="hidden" value="{{$site->id}}">
                @endif
            </form>

            @if(count($treeData) > 0)
                <div class="pull-right" style="margin-top:-35px; padding: 8px 10px 8px 8px;">

                    <small>массовые действия:</small>
                    <a href="{{route('sections.massDelete', ['site_id' => $site->id], false)}}"
                       class="btn btn-danger btn-sm mass-delete" data-method="post"
                       data-back="{{route('sections.index', ['site_id' => $site->id], false)}}"
                       data-confirm="Удалить выбранные элементы?"><i class="fa fa-times"></i></a>
                </div>
            @endif
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function () {

            $('#site-select').change(function () {
                document.location.href = document.location.pathname + '?site_id=' + $(this).val();
            });
        })
    </script>

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
                }).on("mousedown", "input", function (e) {
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
                    var action = $(this).attr("action") || document.location.href;
                    //return false;
                });
            });
        });

    </script>
@stop
