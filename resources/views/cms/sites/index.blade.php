@extends('cms.layouts.master')

@section('title')
	<title>Cms &bull; Панель управления &bull; {{ $title }}</title>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-12">

			@include('cms.partials.breadcrumbs', ['active' => $title])

			<h1 class="page-header">{{ $title }}</h1>

			@include('cms.partials.flash')

			<div align="center">
				<h5>
					<a href="#" class="site-list-view">список</a> / <a href="#" class="site-tree-view">дерево</a>
				</h5>
			</div>
			@if($order)
				<div class="site-tree row" style="display: none;">
					@else
						<div class="site-tree row">
							@endif
							<div class="col-lg-12">
								<form method="POST" action="{{route('sites.updateTree')}}" accept-charset="UTF-8"
									  class="datatree form-horizontal"
									  data-instance-id="00000000780ebfb70000000063d6abd4">
									<div class="datatree-inner-wrapper">

                                        <?php
                                        $depth = 1;
                                        ?>

										@include('cms.sites.datatree')

									</div>

									<div class="datatree-values"></div>

									<div class="btn-toolbar" role="toolbar">

										<div class="pull-left">
											<a href="{{route('sites.create')}}" class="btn btn-default">Создать
												сайт</a>
											<input class="btn btn-primary" type="submit" value="Сохранить изменения">
										</div>


									</div>
									<br>

									<input name="save_tree" type="hidden" value="1">
								</form>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">

								@if($order)
									<div class="site-list" style="display:block;">
										@else
											<div class="site-list" style="display:none;">
												@endif

												<div class="form-group">
													{!! $filter !!}
												</div>

												@if (count($fields) > 0)
													<table class="table table-hover">
														<thead>
														<th>
															@include('cms.partials.sort_field', ['route' => 'sites.index', 'alias' => 'id', 'name' => 'ID'])
														</th>
														<th>

															@include('cms.partials.sort_field', ['route' => 'sites.index', 'alias' => 'domain', 'name' => 'Название'])
														</th>
														<th>Родитель</th>
														<th>Владелец</th>
														<th>Статистика</th>
														<th>Управление</th>
														</thead>
														<tbody class="sortable" data-entityname="slider">
														@foreach ($fields as $item)
															<tr>
																<td>{{ $item->id }}</td>
																<td>
																	<a href="http://{{ $item->domain }}"
																	   target="_blank">{{ idnToUtf8($item->domain) }}</a>
																	@if(in_array($item->domain, array_keys(config('netgamer.default_domains'))))
																		(CMS)
																	@endif
																</td>
																<td>
																	@if($item->parent)
																	{{idnToUtf8($item->parent->domain)}}
																	@else
																	&mdash;
																	@endif
																</td>
																<td>
																	@if($item->user)
																		<a href="mailto: {{$item->user->email}}">{{$item->user->email}}</a>
																		({{$item->user->username}})
																		@else
																		&mdash;
																	@endif
																</td>
																<td>
																	<small>
																		статьи: {{count($item->articles)}}
																	</small>
																	<br>
																	<small>
																		комментарии: {{count($item->comments)}}
																	</small>
																	<br>
																	<small>
																		разделы: {{count($item->sections)}}
																	</small>
																</td>
																<td>
																	@if(empty($item->trashed()))
																		<a href="{{ route('sites.edit', ['site' => $item->id]) }}"
																		   class="btn btn-default"><i
																					class="fas fa-pencil-alt"></i></a>

																		@if($item->parent_id != null || !in_array($item->domain, array_keys(config('netgamer.default_domains'))))
																			<a href="{{ route('sites.destroy', ['site' => $item->id]) }}"
																			   class="btn btn-danger btn-sm deleteSite"
																			   data-method="delete"
																			   data-confirm="Точно удалить ?"><i
																						class="fa fa-times"></i></a>
																		@endif
																	@else

																		<form action="{{route('sites.undelete', ['sites' => $item->id])}}"
																			  class="form-inline">
																			<button class="btn btn-danger deleteSite"
																					style="margin-right:5px;">
																				восстановить
																			</button>
																		</form>

																		@if(!in_array($item->domain, array_keys(config('netgamer.default_domains'))))
																			<a href="{{route('sites.destroyForever', ['sites' => $item->id])}}"
																				  data-method="delete"
																				  data-confirm="Точно удалить?">
																				<button class="btn btn-danger deleteSite">
																					x
																				</button>
																			</a>
																		@endif
																	@endif

																</td>
															</tr>
														@endforeach
														</tbody>
													</table>
													<div class="col-lg-12">

														@include('cms.partials.pagination')
													</div>
												@else
													<p class="alert alert-warning">Записей не найдено</p>
												@endif
											</div>
									</div>
							</div>
						</div>
				</div>

			@section('scripts')
				<script language="javascript" type="text/javascript">
                    $(document).ready(function () {

                        $('[data-instance-id="00000000780ebfb70000000063d6abd4"]').each(function () {
                            var root = $(this);
                            var form = root.find(".datatree-values");
                            root.find(".datatree-inner-wrapper").nestable({
                                listNodeName: "ol",
                                itemNodeName: "li",
                                rootClass: "datatree-inner-wrapper",
                                listClass: "datatree-list",
                                itemClass: "datatree-item",
                                dragClass: "datatree-dragel",
                                handleClass: "datatree-handle",
                                collapsedClass: "datatree-collapsed",
                                placeClass: "datatree-placeholder",
                                noDragClass: "datatree-nodrag",
                                emptyClass: "datatree-empty",
                                expandBtnHTML: "<button data-action=\"expand\" type=\"button\">Expand</button>",
                                collapseBtnHTML: "<button data-action=\"collapse\" type=\"button\">Collapse</button>",
                                group: 0,
                                maxDepth: 5,
                                threshold: 20
                            }).on("mousedown", "a", function (e) {
                                e.stopImmediatePropagation();
                            }).each(function () {
                                var ol = $(this).children(".datatree-list");
                                if (ol.length) rapyd.datatree.updateDepth(ol);
                                rapyd.datatree.updateForm($(this), form, "items");
                            }).on("change", function () {
                                var ol = $(this).children(".datatree-list");
                                if (ol.length) rapyd.datatree.updateDepth(ol);
                                var updated = rapyd.datatree.updateForm($(this), form, "items");
                            });
                            $(".datatree").submit(function () {
                                return $(this).attr("action") || document.location.href;
                            });
                        });
                    });

				</script>

@endsection

@stop

