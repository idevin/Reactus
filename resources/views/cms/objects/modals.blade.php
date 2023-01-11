<!-- Обновление нода -->
<div class="modal fade" id="nodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route('objects.updateNode', absolute: false)}}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="nodeModalLabel">Обьект</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="" id="nodeId">
                    <div class="form-group clearfix">
                        <label for="name" class="col-sm-2 control-label required">Название</label>

                        <div class="col-sm-10">
                            <input id="nodeLabel" class="form-control" name="name" type="text" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('objects.destroy', ['object' => 0], false)}}" class="btn btn-danger btn-sm"
                       data-method="delete" data-confirm="Точно удалить ?"><i class="fa fa-times"></i></a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
            </form>
        </div>
    </div>
</div>