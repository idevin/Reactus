@if(Auth::user())
    <div class="topic-list-item revision">
        <div class="topic-body" style="padding: 15px 18px 14px;">
            <div class="row">

                <div class="col-lg-12">
                    @if(Auth::user()->can('section.create') || get_site()->manager(Auth::user(), 'section.create'))
                        <p><a href="{{route('section.new')}}?section_id={{$section->id}}" style="color: #000;"><strong>Создать
                                    раздел</strong></a>
                        </p>
                    @endif

                    @if(Auth::user()->can('section.edit') || get_site()->manager(Auth::user(), 'section.edit'))
                        <p><a href="{{route('section.edit', ['id' => $section->id])}}"
                              style="color: #000;"><strong>Редактировать раздел</strong></a>
                        </p>

                        @if(Auth::user()->can('section.delete') && $section->parent_id != null)
                            <p><a href="{{route('section.delete', ['id' => $section->id])}}"
                                  style="color: #000;"><strong>Удалить</strong></a>
                            </p>
                        @endif

                        @if(count($section->children) > 0 && (Auth::user()->can('section.sort', $section)))
                            <p><a href="{{route('frontend.section.sort', ['id' => $section->id])}}"
                                  style="color: #000;"><strong>Сортировать</strong></a>
                            </p>
                        @endif
                    @endif
                </div>

            </div>
        </div>
    </div>
@endif

