<ol class="datatree-list" data-depth="{{$depth}}">
    @foreach ($treeData as $row)
        <li class="datatree-item" data-id="{{$row->id}}"
            data-depth="{{$row->depth}}">
            <div class="datatree-handle">
                <span data-field-name="title">{{$row->name}} </span>

                <span data-field-name="_edit">
                    <?php
                    $routeEdit = route('object_field_groups.edit', ['object_field_groups' => $row->id], false);
                    $routeDestroy = route('object_field_groups.destroy', ['object_field_groups' => $row->id], false);
                    ?>

                    <a href="{{ $routeEdit }}"
                       class="btn" style="padding: 0;"><i
                                class="fas fa-pencil-alt"></i></a>

                    @if($row->id != config('netgamer.user_field_group'))
                        <a href="{{ $routeDestroy }}"
                           class="btn deleteSite"
                           data-method="delete"
                           data-confirm="Точно удалить ?" style="padding: 0;"><i
                                    class="fa fa-times"></i></a>
                    @endif
                </span>
            </div>

            @if (count($row->children) > 0)
                <?php $treeData = $row->children; ?>
                @include('cms.object_field_groups.datatree')
            @endif

        </li>

    @endforeach
</ol>