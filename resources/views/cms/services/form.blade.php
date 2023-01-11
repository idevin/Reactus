{{ Form::model($form, ['url' => route($action, ['services' => $form->id]), 'method' => 'post', 'theme' => 'bootstrap-vertical', 'files' => true, 'novalidate' => 'novalidate']) }}

<div class="form-group clearfix">
	{{ Form::label('name', 'Название', ['class' => 'col-sm-2 control-label required']) }}

	<div class="col-sm-10">
		{{ Form::text('name', $form->name, ['class' => 'form-control']) }}
	</div>
</div>

<div class="form-group clearfix">
	{{ Form::label('description', 'Описание', ['class' => 'col-sm-2 control-label required']) }}

	<div class="col-sm-10">
		{{ Form::textarea('description', $form->description, ['class' => 'form-control', 'id' => 'description']) }}
	</div>
</div>

<div class="form-group clearfix">
	{{ Form::label('roles', 'Роли', ['class' => 'col-sm-2 control-label required']) }}

	<div class="col-sm-10">
		@foreach($roles as $role)

			<input name="roles[]" type="checkbox" value="{{$role->id}}" @if($form->id && in_array($role->id, $roleIds)) checked @endif)> &mdash; {{$role->name}}
			({{$role->description}}) <a href="#" class="role-chooser-show" data-id="{{$role->id}}">еще...</a>

			<div class="role-{{$role->id}}" style="display: none;">
				<br>
				@foreach(array_chunk($role->permissions->toArray(), 4) as $chunk)
					<div class="row">
						@foreach($chunk as $permission)
							<div class="col-md-3"
								 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
								{{$permission['name']}} <br> ({{$permission['description']}}) <br>
								свои - {{$permission['pivot']['own']}}, чужие - {{$permission['pivot']['other']}}
							</div>
						@endforeach
					</div>
					<hr>
				@endforeach
					<div style="text-align: right;">
						<a href="#" class="role-chooser-hide" data-id="{{$role->id}}">свернуть</a>
					</div>
			</div>

			<br>
		@endforeach
	</div>
</div>

<div class="form-group clearfix">
	{{ Form::label('pay_once_label', 'Единовременная оплата', ['class' => 'col-sm-2 control-label required']) }}

	<div class="col-sm-10">
		{{ Form::checkbox('pay_once', 1, (boolean)$form->pay_once == 1) }}
	</div>
</div>

<div class="form-group clearfix">
	{{ Form::label('price_label', 'Цена', ['class' => 'col-sm-2 control-label required']) }}

	<div class="col-sm-10">
		{{ Form::number('price', $form->price, ['class' => 'form-control', 'step' => 0.01, 'min' => 0]) }}
	</div>
</div>

<div class="form-group clearfix">
	{{ Form::label('period_amount', 'Продолжительность', ['class' => 'col-sm-2 control-label required']) }}

	<div class="col-sm-7">
		{{ Form::number('period_amount', $form->period_amount, ['class' => 'form-control', 'id' => 'period_amount', 'min' => "0"]) }}
	</div>

	<div class="col-sm-3">
		{{ Form::select('period', ['' => 'Выберите период'] + \App\Models\BillingService::$periods, $form->period, ['class' => 'form-control', 'id' => 'period']) }}
	</div>
</div>

<div class="form-group clearfix">
	{{ Form::label('free_period_amount', 'Бесплатный период', ['class' => 'col-sm-2 control-label required']) }}

	<div class="col-sm-7">
		{{ Form::number('free_period_amount', $form->free_period_amount, ['class' => 'form-control', 'id' => 'free_period_amount', 'min' => "0"]) }}
	</div>

	<div class="col-sm-3">
		{{ Form::select('free_period', ['' => 'Выберите период'] + \App\Models\BillingService::$periods, $form->period, ['class' => 'form-control', 'id' => 'free_period']) }}
	</div>
</div>

<div class="btn-toolbar" role="toolbar">
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</div>
</div>

{{ Form::close() }}

@section('scripts')
	<script>
        $(function () {
            $(document).on('click', '.role-chooser-show', function () {
                let roleId = $(this).data('id');
                let roleDiv = $('.role-' + roleId);

                if (roleDiv.is(':hidden')) {
                    roleDiv.show('fast');
                    $(this).hide();
                } else {
                    roleDiv.hide('fast');
				}

                return false;
            });

            $(document).on('click', '.role-chooser-hide', function () {
                let roleId = $(this).data('id');
                let roleDiv = $('.role-' + roleId);

                if (roleDiv.is(':visible')) {
                    roleDiv.hide('fast');
					$('.role-chooser-show[data-id=' + roleId + ']').show();
                }
                return false;
            });
        });
	</script>
@stop