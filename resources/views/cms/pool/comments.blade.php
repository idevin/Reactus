<div class="col-lg-6">
    <h1>Коментарии</h1>

    @if (count($arComments) > 0)
        <table class="table table-hover">
            <thead>
            <th>ID</th>
            <th>Сообщение</th>
            <th>Действия</th>
            </thead>
            <tbody class="sortable" data-entityname="slider">
            @foreach ($arComments as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        <small>
                            {!! html_entity_decode($item->content) !!}
                            <hr>
                            URL статьи: <a target="_blank"
                                           href="{{route_to_article($item->article)}}#c{{$item->id}}">{{$item->article->title}}</a>
                        </small>
                    </td>
                    <td>
                        <a href="{{ route('cms.pool.approve', ['object' => class_basename($item), 'id' => $item->id], false) }}"
                           class="btn btn-default">подтвердить</a>

                        <a href="{{ route('cms.pool.delete', ['object' => class_basename($item),'id' => $item->id], false) }}"
                           data-method="delete"
                           data-confirm="Точно удалить?"
                           class="btn btn-default">удалить</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">Коментариев для модерации не найдено</p>
    @endif
</div>