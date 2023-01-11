<ol class="datatree-list" data-depth="{{$depth}}">
	@foreach ($treeData as $i => $row)
		<li class="datatree-item" data-id="{{$row->id}}"
			data-depth="{{$row->depth}}">
			<div class="datatree-handle">
				<span data-field-name="title">{{$row->title}} </span>
				/
				<span data-field-name="url">
					<a href="http://{{$row->domain}}"
					   target="_blank">{{idnToUtf8($row->domain)}}</a>

					@if(in_array($row->domain, array_keys(config('netgamer.default_domains'))))
						(CMS)
					@endif
				</span>

				<span data-field-name="_edit">
                    <?php
                    $routeEdit = route('sites.edit', ['site' => $row->id]);
                    $routeDestroy = route('sites.destroy', ['site' => $row->id], false);
                    $routeUndelete = route('sites.undelete', ['sites' => $row->id], false);
                    $routeDeleteForever = route('sites.destroyForever', ['sites' => $row->id], false);
                    $routeDestroyCascade = route('sites.destroyCascade', ['sites' => $row->id], false);
                    ?>

					@if(!empty(!$row->trashed()))
						<a href="{{ $routeEdit }}"
						   class="btn" style="padding: 0;"><i
									class="fas fa-pencil-alt"></i></a>

						@if($row->parent_id != null || !in_array($row->domain, array_keys(config('netgamer.default_domains'))))
							<a href="{{ $routeDestroy }}"
							   class="btn deleteSite"
							   data-method="delete"
							   data-confirm="Точно удалить ?" style="padding: 0;"><i
										class="fa fa-times"></i></a>
						@endif

					@else
						<a href="{{ $routeUndelete }}"
						   class="btn" style="padding: 0;"><i
									class="fa fa-check"></i></a>
						@if($row->parent_id != null ||
!in_array($row->domain, array_keys(config('netgamer.default_domains'))))
							<a href="{{ $routeDeleteForever }}"
							   data-method="delete"
							   data-confirm="Точно удалить навсегда?"
							   class="btn deleteSite" style="padding: 0;"><i
										class="fa fa-times"></i></a>
						@endif
					@endif

					@if(!in_array($row->domain, array_keys(config('netgamer.default_domains'))))
						<a href="{{ $routeDestroyCascade }}"
						   data-method="delete"
						   data-confirm="Точно удалить навсегда?"
						   class="btn deleteSite" style="padding: 0;"><i
									class="fa fa-times" style="color: red;"></i></a>
					@endif
                </span>
			</div>

			@if (count($row->children) > 0)
                <?php $treeData = $row->children; ?>
				@include('cms.sites.datatree')
			@endif

		</li>

	@endforeach
</ol>