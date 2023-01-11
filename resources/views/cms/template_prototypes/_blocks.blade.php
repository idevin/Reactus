<div class="col-sm-2">

</div>

<div class="col-sm-10" style="border: 1px solid #cccccc;padding:20px;">
    <div class="col-sm-2">

        <h4>{{$positionName}}</h4>

        <div class="col-sm-10">
            <br/> №
            п.п. {{ Form::number('stroke_sort_order[' . $positionOptions[$positionName] . ']', null, ['class' => 'form-control', 'min' => 1]) }}
        </div>

        <div class="col-sm-2">
            <a class="add_stroke" title="Добавить строку"
               href="{{ route($route, ['add_stroke' => $positionOptions[$positionName], 'template_prototype' => $form->id]) }}">добавить
                строку</a>
        </div>
    </div>
    <div class="col-sm-10">

        @if(isset($session[$positionName]))
            @if(count($session[$positionName]) > 0)
                @foreach($session[$positionName] as $i => $stroke)
                    <div class="col-sm-12" style="border: 1px solid #cccccc;padding:20px;">
                        <div class="col-sm-1"> № <br>
                            <b>{{$i}}</b>
                        </div>
                        <div class="col-sm-5" style="border: 1px solid #cccccc; padding: 10px;">
                            Добавить модуль: <br>
                            {{ Form::select('module[' . $positionOptions[$positionName] . '][' . $i . ']', $modules, null, ['class' => 'form-control']) }}
                            <br>
                            №
                            п.п. {{ Form::number('module_id[' . $positionOptions[$positionName] . '][' . $i . '][sort_order]', null, ['class' => 'form-control', 'min' => 1]) }}
                            <a class="add_module"
                               href="{{ route($route, ['add_module' => $positionOptions[$positionName], 'stroke' => $i, 'template_prototype' => $form->id]) }}">добавить</a>
                            <br>
                        </div>
                        <div class="col-sm-6">

                            @if(!empty($stroke))
                                @foreach($stroke as $j => $module)
                                    <div class="col-sm-10">
                                        {{$j}} &mdash; <b>{{$module->name}}</b>
                                    </div>
                                    <div class="col-sm-2">
                                        <a title="удалить"
                                           href="{{ route($route, ['delete_module' => $positionOptions[$positionName], 'stroke' => $i, 'module' => $j, 'template_prototype' => $form->id]) }}">удалить</a>
                                    </div>
                                @endforeach
                            @endif


                            <div style="float:right;"><br/><br/>
                                <a href="{{ route($route, ['delete_stroke' => $positionOptions[$positionName], 'stroke' => $i, 'template_prototype' => $form->id]) }}">удалить
                                    строку</a>
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif
        @endif
    </div>
</div>
