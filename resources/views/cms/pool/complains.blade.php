<div class="col-lg-6">
    <h1>Жалобы</h1>

    @if (count($complains) > 0)
        <table class="table table-hover">
            <thead>
            <th>ID</th>
            <th>Обьект</th>
            <th>Жалоба на</th>
            <th>Жалоба от</th>
            <th>Опция</th>
            <th>Текст</th>
            <th>Действия</th>
            </thead>
            <tbody class="sortable" data-entityname="slider">
            @foreach ($complains as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        @if($item->object())
                            {!! html_entity_decode($item->object()->getContentArray()['data']) !!}
                        @endif
                    </td>
                    <td>
                        {{username($item->on_user)}}
                    </td>
                    <td>
                        {{username($item->user)}}
                    </td>
                    <td>
                        @if($item->complain_option)
                            {!! $item->complain_option->title !!}
                        @endif
                    </td>
                    <td>
                        {{$item->content}}

                        @if(!empty($item->answer))
                            <hr>
                            <small><b>Ответ:</b> {{$item->answer}}</small>
                        @endif
                    </td>
                    <td>
                        <p>
                            <a href="{{ route('cms.pool.delete', ['object' => class_basename($item), 'id' => $item->id], false) }}"
                               data-method="delete"
                               data-confirm="Точно удалить?"
                               class="btn btn-default">удалить</a>

                            <a href="{{ route('cms.pool.answer', ['object' => class_basename($item), 'id' => $item->id], false) }}"
                               class="btn btn-default">ответить</a>
                        </p>

                        <p>
                            <a href="{{ route('cms.pool.approve_complain', ['id' => $item->id], false) }}"
                               class="btn btn-default">подтвердить</a>

                            <a href="{{ route('cms.pool.deny_complain', ['id' => $item->id], false) }}"
                               class="btn btn-default">опровергнуть</a>
                        </p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">Жалоб не найдено</p>
    @endif
</div>