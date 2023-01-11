@if(!empty($fields) && !empty($route))
	<div class="form-group" style="text-align: center;">
		<div class="row">
			<div class="col-lg-12">
				<form method="GET" action="{{$route}}" accept-charset="UTF-8"
					  class="form-inline form-horizontal" role="form">

					@if(!empty($request['ord']))
						<input type="hidden" name="ord" value="{{$request['ord']}}">
					@endif

					@if(!empty($request['limit']))
						<input type="hidden" name="limit" value="{{$request['limit']}}">
					@endif

					@if(!empty($request['page']))
						<input type="hidden" name="page" value="{{$request['page']}}">
					@endif

					@foreach($fields as $field)
						@if(!empty($field['name']) && !empty($field['placeholder']))
							<div class="form-group" id="fg_{{$field['name']}}"
								 style="margin-right:15px;margin-bottom:5px;">

								<label for="{{$field['name']}}" class="sr-only">
									{{$field['placeholder']}}
								</label>
								@if($field['name'] != 'created_at')
									@if($field['type'] == 'input')
										<span id="div_{{$field['name']}}">

                                    <input class="form-control"
										   placeholder="{{$field['placeholder']}}"
										   type="text"
										   @if(!empty($request[$field['name']]))
										   value="{{$request[$field['name']]}}"
										   @endif
										   id="f_{{$field['name']}}"
										   name="{{$field['name']}}">
        </span>
									@endif

									@if($field['type'] == 'checkbox')
											{{$field['placeholder']}} &mdash; <input type="checkbox" id="id_{{$field['name']}}" name="{{$field['name']}}"
											   value="1"  @if(!empty($request[$field['name']]))checked="checked"@endif>
									@endif

								@endif

								@if($field['name'] == 'created_at')
									<span id="div_created_at">

                            <div id="range_created_at_container">
                                <div class="input-daterange">
                                   <div class="input-group">
                                       <div class="input-group-addon">
                                   <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                   </div>
                                       <input
											   class="form-control"
											   placeholder="{{$field['placeholder']}}"
											   type="text"
											   name="created_at[from]"
											   autocomplete="off"
											   @if(!empty($request['created_at']) && !empty($request['created_at']['from']))
											   value="{{$request['created_at']['from']}}"
                                               @endif
                                       >
                                   </div>
                                   <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                        </div>
                                        <input
												class="form-control"
												placeholder="{{$field['placeholder']}}"
												type="text"
												name="created_at[to]"
												autocomplete="off"
												@if(!empty($request['created_at']) && !empty($request['created_at']['to']))
												value="{{$request['created_at']['to']}}"
                                                @endif
                                        >
                                   </div>
                                </div>
                            </div>
        </span>
								@endif


							</div>
						@endif
					@endforeach

					<input class="btn btn-primary" type="submit" value="поиск" style="margin-top:-5px;">
					<a href="{{$route}}" class="btn btn-primary" style="margin-top:-5px;">X</a>
					<input type="hidden" name="search" value="1">
				</form>
			</div>
		</div>
	</div>
@endif

@if(!empty($buttons))
	<div class="row from-group">
		<div class="col-lg-12">
			@foreach($buttons as $button)
				<a href="{{$button['route']}}" class="btn btn-primary">{{$button['name']}}</a>
			@endforeach
		</div>
	</div>
@endif