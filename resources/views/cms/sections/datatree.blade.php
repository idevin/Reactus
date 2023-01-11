<ol class="datatree-list" data-depth="{{$depth}}">
    <?php $ids = []; ?>
    @foreach ($treeData as $row)
        <li class="datatree-item" data-id="{{$row->id}}"
            data-depth="{{$row->depth}}">
            <div class="datatree-handle">
                <span data-field-name="title">{{$row->title}} </span>
                <br>
                <span data-field-name="url"><a href="{{route('section.show',['id' => $row->id, 'path' => $row->path, 'section' => $row->path])}}"
                                               target="_blank">{{truncate_content($row->url, 50)}}</a></span>

                @if($row->parent_id != null)
                    <span data-field-name="_edit">
                    <?php
                        $routeEdit = route('sections.edit', ['section' => $row->id,
                            'site_id' => $site->id], false);
                        $routeDestroy = route('sections.destroy', ['section' => $row->id,
                            'site_id' => $site->id], false);
                        $routeUndelete = route('sections.undelete', ['sections' => $row->id,
                            'site_id' => $site->id], false);
                        $routeDeleteForever = route('sections.destroyForever', ['sections' => $row->id,
                            'site_id' => $site->id], false);
                        ?>

                        <a href="{{ $routeEdit }}"
                           class="btn" style="padding: 0;"><i
                                    class="fas fa-pencil-alt"></i></a>
                        @if(!$row->trashed())
                            <a href="{{ $routeDestroy }}"
                               class="btn deleteSite"
                               data-method="delete"
                               data-confirm="Точно удалить ?" style="padding: 0;"><i
                                        class="fa fa-times"></i></a>
                        @else
                            @if(isset($routeUndelete))
                                <a href="{{ $routeUndelete }}"
                                   class="btn deleteSite" title="Восстановить"><i class="fa fa-check"
                                                                                  aria-hidden="true"></i></a>
                            @endif
                            @if(isset($routeDeleteForever))
                                <a href="{{ $routeDeleteForever }}"
                                   data-method="delete"
                                   data-confirm="Точно удалить ?"
                                   class="btn deleteSite" style="padding: 0;"><i class="fa fa-times"
                                                                                 aria-hidden="true"></i></a>
                            @endif
                        @endif
                        <input class="sown" style="float: left; margin: 4px 16px 0;" type="checkbox"
                               name="sections[{{$row->id}}]" value="{{$row->id}}">
                </span>
                @endif
            </div>

            @if (count($row->children))
                <?php $treeData = $row->children; ?>
                @include('cms.sections.datatree')
            @endif
        </li>
    @endforeach
</ol>