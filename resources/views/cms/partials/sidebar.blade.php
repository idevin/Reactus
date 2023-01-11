<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('cms.index') }}"><i class="fas fa-dashboard fa-fw"></i> Панель Управления</a>
            </li>

            <li>
                <a href="#"><i class="fas fa-users fa-fw"></i> Роли и пользователи<span class="fas arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('cms.users.index') }}"><i class="fas fa-user fa-fw"></i> Пользователи</a>
                    </li>
                    <li>
                        <a href="{{ route('roles.index') }}"><i class="fas fa-list fa-fw"></i> Роли <span
                                    class="fas arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ route('roles.create') }}">Создать</a>
                            </li>
                            <li>
                                <a href="{{ route('roles.index') }}">Все</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('permissions.index') }}"><i class="fas fa-exclamation-triangle fa-fw"></i>
                            Права и
                            действия</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fas fa-money-bill fa-fw"></i> Биллинг<span
                            class="fas arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('cms.billing.discounts.index') }}"><i class="fas fa-percent fa-fw"></i> Скидки</a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ route('cms.billing.discounts.create') }}">Создать</a>
                            </li>
                            <li>
                                <a href="{{ route('cms.billing.discounts.index') }}">Все</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('cms.billing.tariffs.index') }}"><i class="fas fa-concierge-bell fa-fw"></i>
                            Тарифы</a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ route('cms.billing.tariffs.create') }}">Создать</a>
                            </li>
                            <li>
                                <a href="{{ route('cms.billing.tariffs.index') }}">Все</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('cms.billing.services.index') }}"><i class="fas fa-list fa-fw"></i>
                            Сервисы<span class="fas fa-arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ route('cms.billing.services.create') }}">Создать</a>
                            </li>
                            <li>
                                <a href="{{ route('cms.billing.services.index') }}">Все</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('cms.billing.service_options.index') }}"><i class="fas fa-list fa-fw"></i>
                            Опции сервисов<span class="fas fa-arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ route('cms.billing.service_options.create') }}">Создать</a>
                            </li>
                            <li>
                                <a href="{{ route('cms.billing.service_options.index') }}">Все</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('subscriptions.index') }}"><i class="fas fa-list fa-fw"></i> Подписки<span
                                    class="fas fa-arrow"></span></a>
                    </li>
                    <li>
                        <a href="{{ route('currency.index') }}"><i class="fas fa-list fa-fw"></i> Валюта<span
                                    class="fas fa-arrow"></span></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fas fa-user fa-fw"></i>Формы<span class="fas arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('forms.index') }}"><i class="fas fa-comment-o fa-fw"></i>Поля</a>
                    </li>
                    <li>
                        <a href="{{ route('form_groups.index') }}"><i class="fas fa-comments-o fa-fw"></i>Группы
                            полей</a>
                    </li>
                    <li>
                        <a href="{{ route('feedback.index') }}"><i
                                    class="fas fa-commenting-o fa-fw fa-toggle-right"></i>Обратная связь</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fas fa-users fa-fw"></i> Каталоги<span class="fas arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('objects.create') }}">Создать</a>
                    </li>
                    <li>
                        <a href="{{ route('objects.index') }}">Все</a>
                    </li>
                    <li>
                        <a href="{{ route('object_fields.index') }}"><i class="fas fa-list fa-fw"></i> Поля <span
                                    class="fas arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ route('object_fields.create') }}">Создать</a>
                            </li>
                            <li>
                                <a href="{{ route('object_fields.index') }}">Все</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('object_field_groups.index') }}"><i class="fas fa-list fa-fw"></i> Группы
                            полей <span
                                    class="fas arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ route('object_field_groups.create') }}">Создать</a>
                            </li>
                            <li>
                                <a href="{{ route('object_field_groups.index') }}">Все</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('object_fields_relations.index') }}"><i class="fas fa-list fa-fw"></i> Каталоги и группы полей <span
                                    class="fas arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ route('object_fields_relations.create') }}">Создать</a>
                            </li>
                            <li>
                                <a href="{{ route('object_fields_relations.index') }}">Все</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fas fa-sitemap fa-fw"></i> Домены и сайты<span class="fas arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('domains.index') }}"><i class="fas fa-genderless fa-fw fa-toggle-right"></i>
                            Домены</a>
                    </li>
                    <li>
                        <a href="{{ route('thematic.index') }}"><i class="fas fa-genderless fa-fw fa-toggle-right"></i>
                            Тематика доменов
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sites.index') }}"><i class="fas fa-file-text-o fa-fw fa-toggle-right"></i>
                            Сайты</a>
                    </li>

                    <li>
                        <a href="{{ route('settings.index') }}"><i class="fas fa-cog fa-fw"></i> Настройки</a>
                    </li>

                    <li>
                        <a href="{{ route('site_users.index') }}"><i class="fas fa-id-card-o fa-fw fa-toggle-right"></i>
                            Управление Сайтами</a>
                    </li>

                    <li>
                        <a href="{{ route('site_sections.index') }}"><i class="fas fa-clone fa-fw fa-toggle-right"></i>
                            Перенос сайтов в
                            разделы</a>
                    </li>
                    <li>
                        <a href="{{ route('sections_site.index') }}"><i class="fas fa-clone fa-fw fa-toggle-right"></i>
                            Перенос разделов в
                            сайты</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('language.index') }}"><i class="fas fa-language fa-toggle-right"></i> Языки</a>
            </li>

            <li>
                <a href="{{ route('templates.index') }}"><i class="fas fa-certificate fa-toggle-right"></i> Шаблоны</a>
            </li>

            <li>
                <a href="{{ route('template_prototypes.index') }}"><i class="fas fa-certificate fa-toggle-right"></i> Прототипы
                    шаблонов</a>
            </li>

            <li>
                <a href="#"><i class="fas fa-file-text fa-fw fa-toggle-right"></i> Разделы<span
                            class="fas arrow"></span></a>

                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('sections.index') }}"><i class="fas fa-genderless fa-fw fa-toggle-right"></i>
                            Все разделы</a>
                    </li>
                    <li>
                        <a href="{{ route('section_users.index') }}"><i class="fas fa-file-text fa-fw"></i> Управление
                            Разделами</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('articles.index') }}"><i class="fas fa-file fa-fw"></i> Статьи</a>
            </li>

            <li>
                <a href="{{ route('comments.index') }}"><i class="fas fa-comment-o fa-fw"></i> Комментарии</a>
            </li>

            <li>
                <a href="#"><i class="fas fa-lock fa-fw"></i> Модераторство<span class="fas arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('cms.pool.index') }}"><i class="fas fa-genderless fa-fw fa-toggle-right"></i>
                            Пул</a>
                    </li>
                    <li>
                        <a href="{{ route('complain_options.index') }}"><i class="fas fa-filter fa-fw"></i> Опции
                            жалоб</a>
                    </li>
                </ul>
            </li>
            <li>

                <a href="#"><i class="fas fa-lock fa-fw"></i> Лог<span class="fas arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('activities.index') }}"><i
                                    class="fas fa-genderless fa-fw fa-toggle-right"></i>
                            Активность</a>
                    </li>
                    <li>
                        <a href="{{ route('activity_languages.index') }}"><i
                                    class="fas fa-genderless fa-fw fa-toggle-right"></i>
                            Сообщения активности</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
