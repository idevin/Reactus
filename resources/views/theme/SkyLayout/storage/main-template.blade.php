<div class="col-md-8 col-lg-9">
    <div class="view-section">
        <div class="view-section-heading clearfix">
            <h2 class="main-heading">Хранилище</h2>
        </div>
        <div class="row">
            <div class="col-sm-6 user-tags-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="checkbox" value="1" class="choose-all-tags" name="choose_all_tags"> -
                        <a href="#" class="multi-recycle-tags">удалить теги</a>
                    </div>
                </div>

                <div class="user-tag-wrapper">
                    @include(theme('storage.tags'))
                </div>

                <div class="row user-empty-tags">
                    <div class="col-sm-12">
                        <p>
                            <input type="checkbox" value="1" class="choose-all-files" name="choose_all_files">
                            <a href="#" class="no-file-tags">ФАЙЛЫ БЕЗ ТЕГОВ</a> |
                            <a href="#" class="multi-recycle-files">Удалить в корзину</a> |
                            <a href="#" class="multi-download-files">Скачать файлы (ZIP)</a>
                        </p>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">

                <a href="#" class="storage-recycle">Корзина (<span class="storage-recycle-count">{{$recycle_count['count']}}</span> файлов, <span
                            class="storage-recycle-total">{{format_bytes($recycle_count['total'])}}</span>)</a>

                <a href="#" class="storage-favorite">Избранное (<span class="storage-favorite-count">{{$favorite_count}}</span>)</a>

                <a href="#" class="storage-files">
                    Файлы
                </a>

                <a href="#" class="storage-images">
                    Изображения
                </a>

                <a href="#" class="storage-video">
                    Видео
                </a>

                <a href="#" class="storage-links">
                    Ссылки
                </a>
                <br>
                <input type="text" placeholder="Поиск по тегам и файлам" value="" class="search-file-tag">

                <h4>Загрузка файлов</h4>
                @include(theme('storage.upload-form'))

                @include(theme('storage.add-multi-tag-form'))

                <hr>

                @include(theme('storage.link-form'))

                @include(theme('storage.combine-tags-form'))

            </div>
        </div>

        <div class="storage-file-wrapper">
            @include(theme('storage.files'))
        </div>

    </div>
</div>