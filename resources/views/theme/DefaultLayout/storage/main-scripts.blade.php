@include(theme('storage.upload-templates'))

<script src="/js/tmpl.min.js"></script>
<script src="/js/jquery.ui.widget.js"></script>
<script src="/js/jquery.fileupload-process.js"></script>
<script src="/js/jquery.fileupload-ui.js"></script>

<script>
    $(function () {

        $(document).on('click', '.storage-favorite', function () {

            $.ajax({
                url: '/api/storage/favorite',
                method: 'GET',
                data: {
                    token: window.user.auth_token
                },
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-file-wrapper').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        var xhr;

        $(document).on('keyup', '.search-file-tag', function () {

            xhr = $.ajax({
                url: '/api/storage/search',
                method: 'POST',
                data: {
                    string: $(this).val(),
                    token: window.user.auth_token
                },
                beforeSend: function () {
                    if (xhr) {
                        xhr.abort();
                    }
                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-file-wrapper').html(data.data.html);
                    }
                    xhr = null;
                },
                complete: function () {
                }
            });

            return false;

        });


        $(document).on('submit', '.add-storage-url', function () {

            $.ajax({
                url: '/api/storage/add_url',
                method: 'POST',
                data: $(this).serialize(),
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-file-wrapper').prepend(data.data.html);
                    } else {
                        $('.add-storage-url .error').html(data.data.error);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.storage-recycle', function () {

            $.ajax({
                url: '/api/storage/recycle',
                method: 'GET',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-file-wrapper').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });


        $(document).on('submit', '.combine-storage-tags', function () {

            $.ajax({
                url: '/api/storage/combine_tags',
                method: 'POST',
                data: $(this).serialize(),
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        alert('теги обьединены.');
                    } else {
                        alert(data.data.error);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('change', '.choose-all-tags', function () {
            if ($(this).is(':checked') == true) {
                $('.choosen-tag').prop('checked', true);
            } else {
                $('.choosen-tag').prop('checked', false);
            }

            return false;
        });

        $(document).on('change', '.choose-all-files', function () {
            if ($(this).is(':checked') == true) {
                $('.choosen-files').prop('checked', true);
            } else {
                $('.choosen-files').prop('checked', false);
            }

            return false;
        });


        $(document).on('click', '.storage-images', function () {

            $.ajax({
                url: '/api/storage/images',
                method: 'GET',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-file-wrapper').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.storage-files', function () {

            $.ajax({
                url: '/api/storage/files',
                method: 'GET',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-file-wrapper').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.storage-tag', function () {

            $.ajax({
                url: $(this).attr('href'),
                data: {
                    tag_id: $(this).data('tag_id')
                },
                method: 'POST',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.success == true) {
                        $('.storage-file-wrapper').html(data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.multi-recycle-files', function () {
            var files_to_recycle = [];

            $('.storage-file-wrapper').find('.choosen-files').each(function (i, e) {
                if ($(e).is(':checked') == true) {
                    files_to_recycle.push($(e).val());
                }
            });

            if (files_to_recycle.length == 0) {
                alert('Выберите файлы для удаления');
            } else {
                $.ajax({
                    url: '/api/storage/multi_recycle',
                    data: {
                        ids: files_to_recycle
                    },
                    method: 'POST',
                    beforeSend: function () {

                    },
                    success: function (data) {
                        if (data.data.success == true) {
                            for (var i = 0; i < data.data.files.length; i++) {
                                $('.file[data-id="' + data.data.files[i].id + '"]').remove();
                            }
                        } else {

                        }
                    },
                    complete: function () {
                    }
                });
            }

            return false;
        });

        $(document).on('click', '.multi-recycle-tags', function () {
            var tags = [];

            $('.user-tags').find('.choosen-tag').each(function (i, e) {
                if ($(e).is(':checked') == true) {
                    tags.push($(e).val());
                }
            });

            if (tags.length == 0) {
                alert('Выберите теги для удаления');
            } else {
                $.ajax({
                    url: '/api/storage/multi_recycle_tags',
                    data: {
                        ids: tags
                    },
                    method: 'POST',
                    beforeSend: function () {

                    },
                    success: function (data) {
                        if (data.data.success == true) {
                            for (var i = 0; i < data.data.tags.length; i++) {
                                $('.user-tag[data-tag_id="' + data.data.tags[i] + '"]').remove();
                            }
                        } else {

                        }
                    },
                    complete: function () {
                    }
                });
            }

            return false;
        });

        $(document).on('click', '.multi-download-files', function () {
            var files_to_download = [];

            $('.storage-file-wrapper').find('.choosen-files').each(function (i, e) {
                if ($(e).is(':checked') == true) {
                    files_to_download.push($(e).val());
                }
            });

            if (files_to_download.length == 0) {
                alert('Выберите файлы для скачивания');
            } else {
                $.ajax({
                    url: '/api/storage/multi_download',
                    data: {
                        ids: files_to_download
                    },
                    method: 'POST',
                    beforeSend: function () {

                    },
                    success: function (data) {
                        if (data.data.success == true) {
                            window.location = data.data.href;

                        } else {

                        }
                    },
                    complete: function () {
                    }
                });
            }

            return false;
        });

        $(document).on('click', '.delete-bin-file', function () {

            $.ajax({
                url: '/api/storage/delete_bin_file',
                data: {
                    id: $(this).data('id')
                },
                method: 'POST',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-recycle-count').text(data.data.recycle_count);
                        $('.file[data-id="' + data.data.file.id + '"]').remove();
                    } else {

                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.remove-storage-tag', function () {

            $.ajax({
                url: '/api/storage/remove_tag',
                data: {
                    id: $(this).data('id'),
                    file_id: $(this).data('file_id')
                },
                method: 'POST',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-file-tags[data-id="' + data.data.file_id + '"] .storage-tag-wrapper[data-tag_id="' + data.data.tag_id + '"]').remove();
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.edit-user-storage-tag', function () {
            var id = $(this).data('id');

            $.ajax({
                url: '/api/storage/edit_user_tag',
                data: {
                    id: id
                },
                method: 'POST',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.user-tag[data-tag_id="' + data.data.id + '"]').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('submit', '.edit-user-tag-form', function () {
            var tag = $('.tag_name');

            $.ajax({
                url: '/api/storage/update_user_tag',
                data: {
                    id: tag.data('id'),
                    name: tag.val()
                },
                method: 'POST',
                beforeSend: function () {

                },
                success: function (data) {
                    var tagWrapper = $('.user-tag[data-tag_id="' + data.data.id + '"]');

                    if (data.data.success == true) {
                        tagWrapper.replaceWith(data.data.html);
                    } else {
                        $('.error-user-tag[data-id="' + data.data.id + '"]').html(data.data.error);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.remove-user-storage-tag', function () {

            $.ajax({
                url: '/api/storage/remove_user_tag',
                data: {
                    id: $(this).data('id')
                },
                method: 'POST',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-tag-wrapper[data-tag_id="' + data.data.tag_id + '"]').remove();
                        $('.user-tag[data-tag_id="' + data.data.tag_id + '"]').remove();
                        $('.user-tags-wrapper').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.filter-tag', function () {

            $.ajax({
                url: '/api/storage/filter_tag',
                data: {
                    id: $(this).data('id')
                },
                method: 'POST',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-file-wrapper').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.no-file-tags', function () {

            $.ajax({
                url: '/api/storage/no_file_tags',
                method: 'GET',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-file-wrapper').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });


        $(document).on('submit', '.add-multi-tag', function () {
            var e = $(this).find('input[type="text"]');
            var currentElement = null;

            $(e).each(function (i, el) {
                var v = $(el).val();

                if (v != "") {
                    currentElement = el;
                    return false;
                }
            });


            $.ajax({
                url: '/api/storage/add_multi_tag',
                data: {
                    name: $(currentElement).val()
                },
                method: 'POST',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.user-tags-wrapper').html(data.data.html);
                        $('.add-multi-tag .tag').remove();
                    }
                },
                complete: function () {
                }
            });

            return false;
        });


        $(document).on('submit', '.add-storage-tag', function () {
            var e = $(this).find('input[type="text"]');

            $.ajax({
                url: '/api/storage/add_tag',
                data: {
                    name: e.val(),
                    file_id: $(this).find('input[type="hidden"]').val()
                },
                method: 'POST',
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.file[data-id="' + data.data.file.id + '"]').html(data.data.html);
                        e.val('');
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.delete-file', function () {

            $.ajax({
                url: '/api/storage/delete_file',
                method: 'POST',
                data: {id: $(this).data('id')},
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-recycle-count').text(data.data.count);
                        $('.storage-recycle-total').text(data.data.total);
                        $('.file[data-id="' + data.data.file.id + '"]').remove();
                    } else {

                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.favorite-file', function () {

            $.ajax({
                url: '/api/storage/favorite_file',
                method: 'POST',
                data: {id: $(this).data('id')},
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-favorite-count').text(data.data.favorite_count);
                        $('.file[data-id="' + data.file.id + '"]').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.unfavorite-file', function () {

            $.ajax({
                url: '/api/storage/unfavorite_file',
                method: 'POST',
                data: {id: $(this).data('id')},
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-favorite-count').text(data.data.favorite_count);
                        $('.file[data-id="' + data.file.id + '"]').html(data.data.html);
                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $(document).on('click', '.undelete-file', function () {

            $.ajax({
                url: '/api/storage/undelete_file',
                method: 'POST',
                data: {id: $(this).data('id')},
                beforeSend: function () {

                },
                success: function (data) {
                    if (data.data.success == true) {
                        $('.storage-recycle-count').text(data.data.count);
                        $('.storage-recycle-total').text(data.data.total);
                        $('.file[data-id="' + data.data.file.id + '"]').remove();
                    } else {

                    }
                },
                complete: function () {
                }
            });

            return false;
        });

        $('#fileupload').fileupload({
            dataType: 'json',
            url: '/api/storage/add_files',
            singleFileUploads: true,
            autoUpload: true,
            done: function (e, data) {
                $('.storage-file-wrapper').prepend(data.result.html);
                $('#fileupload .files').html('');
            }
        });

        var storageInput = $('#fileupload .bootstrap-tagsinput input[type="text"]');

        function highlight(s, t) {
            var matcher = new RegExp("(" + $.ui.autocomplete.escapeRegex(t) + ")", "ig");
            return s.replace(matcher, "<strong>$1</strong>");
        }

        storageInput.autocomplete({
            minLength: 0,
            source: function (request, response) {

                $.ajax({
                    url: '/api/storage/search_tag',
                    dataType: 'json',
                    data: {
                        name: request.term
                    },
                    success: function (data) {
                        response($.map(data.data, function (item) {
                            return {
                                name: highlight(item.name, request.term),
                                value: item.name
                            };

                        }));
                    }
                });
            },
            select: function (event, ui) {
                $(event.target).val(ui.item.value);

                var enter = $.Event("keypress");
                enter.which = 13;
                enter.keyCode = 13;
                $(event.target).trigger(enter);

                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>").append(item.name).appendTo(ul);
        };

    });

</script>
