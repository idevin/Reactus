<script src="/assets/admin/components/jquery/dist/jquery.min.js"></script>
<script src="/assets/admin/components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/admin/components/metisMenu/dist/metisMenu.min.js"></script>

<script src="/js/tooltip.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/lang/summernote-ru-RU.js"></script>

<script src="/assets/admin/js/sb-admin-2.js"></script>
<script src="/assets/admin/js/delete-handler.js"></script>

<script src="/assets/admin/datatree/js/nestable/jquery.nestable.js"></script>
<script src="/assets/admin/datatree/js/datatree.js"></script>
<script src="/assets/admin/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/admin/datepicker/locales/bootstrap-datepicker.ru.js"></script>
<script src="/assets/admin/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

<script src="/assets/admin/autocomplete/jquery.autocomplete.min.js"></script>

<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        if ($(document).find('#range_created_at_container').length > 0) {
            $('#range_created_at_container .input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ru',
                todayBtn: 'linked',
                autoclose: true,
                maxDate: "+1m"
            });
        }

        if ($(document).find('#dates0').length > 0 && $(document).find('#dates1').length > 0) {
            $('#dates0').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ru',
                todayBtn: 'linked',
                autoclose: true,
                maxDate: "+1m"
            });

            $('#dates1').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ru',
                todayBtn: 'linked',
                autoclose: true,
                maxDate: "+1m"
            });
        }

        // $('[id="content"]').redactor();
        // $('[id="sections_description"]').redactor();
        // $('[id="articles_description"]').redactor();

    });

</script>