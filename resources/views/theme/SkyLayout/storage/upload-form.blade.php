<form id="fileupload" action="#" method="POST" enctype="multipart/form-data">
    <div class="storage-add-file">
        Введите теги(через запятую):

        <input type="text" name="upload_tags" class="storage-upload-tags has-tag-autocomplete form-control input-lg tags-input"
               data-role="tagsinput">
        <br>
        Выберите файлы: <input type="file" name="files[]" id="add-storage-files" multiple>

        <span class="fileupload-process"></span>

        <div class="fileupload-progress fade">

            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>

            <div class="progress-extended">&nbsp;</div>
        </div>

        <table role="presentation" class="table table-stripped">
            <tbody class="files"></tbody>
        </table>
    </div>
</form>
