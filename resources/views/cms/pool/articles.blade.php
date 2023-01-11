<div class="col-lg-6">
    <h1>Статьи</h1>

    @if (count($articles) > 0)
        <table class="table table-hover">
            <thead>
            <th>ID</th>
            <th>Данные</th>
            <th>Действия</th>
            </thead>
            <tbody class="sortable" data-entityname="slider">
            @foreach ($articles as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        <a href="{{$item->url()}}" target="_blank">{{$item->title}}</a>

                        @if(!empty($item->moderationAnswer()))
                            <hr>
                            <small>
                                <b>Примечание:</b> {{$item->moderationAnswer()->content}}
                                <a href="{{ route('cms.pool.delete_answer', ['id' => $item->moderationAnswer()->id]) }}">x</a>
                            </small>
                        @endif

                        @if(!empty($item->moderationAnswer()) && strtotime($item->moderationAnswer()->confirmed_at) > 0)
                            <hr>
                            <b>Ответ
                                прочитан:</b> {{date('Y-m-d H:i', strtotime($item->moderationAnswer()->confirmed_at))}}
                        @endif
                    </td>
                    <td>
                        <a target="_blank" href="{{ route('articles.edit', ['article' => $item->id]) }}"
                           class="btn btn-default">редактировать</a>
                        @if(empty($item->transfer_to_section))
                            <a href="{{ route('cms.pool.approve', ['object' => class_basename($item), 'id' => $item->id]) }}"
                               class="btn btn-default">подтвердить</a>
                        @else
                            <a href="{{ route('cms.pool.approve_transfer', ['object' => class_basename($item), 'id' => $item->id]) }}"
                               class="btn btn-default">подтвердить перенос</a>

                            <a href="{{ route('cms.pool.deny_transfer', ['object' => class_basename($item), 'id' => $item->id]) }}"
                               class="btn btn-default">запретить перенос</a>
                        @endif

                        <a href="{{ route('cms.pool.answer', ['object' => class_basename($item), 'id' => $item->id]) }}"
                           class="btn btn-default">примечание</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">Статьей для модерации не найдено</p>
    @endif
</div>