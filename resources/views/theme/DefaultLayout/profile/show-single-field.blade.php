@foreach($group['fields'] as $field)
    @if($field->value && isset($field->value['visibility']) && $field->value['visibility'] != 2)
        <div class="row">
            <div class="col-sm-6">
                <div class="overflowed">{{$field->name}}</div>
            </div>
            <div class="col-sm-6">
                <div class="overflowed">
                    @if(!empty($field->value['value']))
                    {{$field->value['value']}}
                    @else
                    &mdash;
                    @endif
                </div>
            </div>
        </div>
    @endif
@endforeach