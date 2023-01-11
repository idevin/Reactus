<ol class="datatree-list" data-depth="{{$depth}}">
    @foreach ($treeData as $row)
        <li class="datatree-item" data-id="{{$row->id}}"
            data-depth="{{$row->depth}}">
            <div class="datatree-handle">
                <span data-field-name="title">{{$row->title}} </span>

                <span data-field-name="_edit">
                    <?php
                    $routeEdit = route('complain_options.edit', ['complain_option' => $row->id], false);
                    $routeDestroy = route('complain_options.destroy', ['complain_option' => $row->id], false);
                    ?>

                    <a href="{{ $routeEdit }}"
                       class="btn" style="padding: 0;"><i
                                class="fas fa-pencil-alt"></i></a>

                        <a href="{{ $routeDestroy }}"
                           class="btn deleteSite"
                           data-method="delete"
                           data-confirm="Точно удалить ?" style="padding: 0;"><i
                                    class="fa fa-times"></i></a>

                </span>
            </div>

            @if (count($row->children) > 0)
                <?php $treeData = $row->children; ?>
                @include('cms.complain_options.datatree')
            @endif

        </li>

    @endforeach
</ol>