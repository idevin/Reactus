<div class="col-lg-6">
    <h1>разделы</h1>

    @if (count($sections) > 0)
        <table class="table table-hover">
            <thead>
            <th>ID</th>
            <th>Раздел</th>
            </thead>
            <tbody class="sortable" data-entityname="slider">
            @foreach ($sections as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        @if($item->section->parent_id)
                            <a href="{{route_to_section($item->section)}}" target="_blank">{{$item->section->title}}</a>
                        @else
                            <a href="http://{{$item->section->site->domain}}/sections"
                               target="_blank">{{$item->section->title}}</a>
                        @endif
                    </td>
                    <td>
                        <p>
                            <a href="{{ route('cms.pool.approve_section_transfer', ['id' => $item->id]) }}"
                               class="btn btn-default">подтвердить</a>

                            <a href="{{ route('cms.pool.deny_section_transfer', ['id' => $item->id]) }}"
                               class="btn btn-default">опровергнуть</a>
                        </p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">Разделов для переноса не найдено</p>
    @endif
</div>