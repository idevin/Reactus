@extends('cms.layouts.master')

@section('title')
    <title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">

            @include('cms.partials.breadcrumbs', ['active' => $title])

            <h1 class="page-header">{{ $title }}</h1>

            @include('cms.partials.flash')

            <div class="site-tree row">
                <div class="col-lg-12">
                    <form method="POST" action="{{route('complain_options.updateTree')}}"
                          accept-charset="UTF-8"
                          class="datatree form-horizontal"
                          data-instance-id="00000000780ebfb70000000063d6abd4">
                        <div class="datatree-inner-wrapper">

                            <?php
                            $depth = 1;
                            ?>

                            @include('cms.complain_options.datatree')

                        </div>

                        <div class="datatree-values"></div>

                        <div class="btn-toolbar" role="toolbar">

                            <div class="pull-left">
                                <a href="{{route('complain_options.create')}}" class="btn btn-default">Создать</a>
                                <input class="btn btn-primary" type="submit" value="Сохранить изменения">
                            </div>


                        </div>
                        <br>

                        <input name="save_tree" type="hidden" value="1">
                    </form>
                </div>
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
                            var action = $(this).attr("action") || document.location.href;
                            return action;
                        });
                    });


                });

            </script>

@endsection

@stop

