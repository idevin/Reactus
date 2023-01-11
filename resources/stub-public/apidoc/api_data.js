define({ "api": [
  {
    "type": "GET",
    "url": "/api/announcement/search",
    "title": "Поиск по анонсу",
    "group": "Announcements",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "object_type",
            "description": "<p>Тип обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>строка поиска</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AnnouncementController.php",
    "groupTitle": "Announcements",
    "name": "GetApiAnnouncementSearch"
  },
  {
    "type": "POST",
    "url": "/api/announcement/create",
    "title": "Создание анонса",
    "group": "Announcements",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID объекта</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "announce_id",
            "description": "<p>ID анонса</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "object_type",
            "description": "<p>Тип объекта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "announce_type",
            "description": "<p>Тип анонса</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>название</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>описание</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AnnouncementController.php",
    "groupTitle": "Announcements",
    "name": "PostApiAnnouncementCreate"
  },
  {
    "type": "POST",
    "url": "/api/announcement/delete",
    "title": "Удаление анонса",
    "group": "Announcements",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID анонса (не обязательно)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "object_type",
            "description": "<p>Тип обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "announce_type",
            "description": "<p>Тип анонса</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "announce_id",
            "description": "<p>ID анонса</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AnnouncementController.php",
    "groupTitle": "Announcements",
    "name": "PostApiAnnouncementDelete"
  },
  {
    "type": "GET",
    "url": "/api/article_groups/search_article",
    "title": "Поиск по статье для группы статей",
    "group": "Article_Groups",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>символы для поиска</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "current_article_id",
            "description": "<p>ID статьи, к которой прикрепляется группа</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "current_article_group_ids",
            "description": "<p>Массив текущих статей в группе</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticleGroupsController.php",
    "groupTitle": "Article_Groups",
    "name": "GetApiArticle_groupsSearch_article"
  },
  {
    "type": "GET",
    "url": "/api/article_groups/search_group",
    "title": "Поиск по группе статей",
    "group": "Article_Groups",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Cимволы для поиска</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticleGroupsController.php",
    "groupTitle": "Article_Groups",
    "name": "GetApiArticle_groupsSearch_group"
  },
  {
    "type": "POST",
    "url": "/api/article_groups/create",
    "title": "Создание группы статей",
    "group": "Article_Groups",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "article_id",
            "description": "<p>ID статьи к которой при крепляется группа статей</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>название группы статей</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticleGroupsController.php",
    "groupTitle": "Article_Groups",
    "name": "PostApiArticle_groupsCreate"
  },
  {
    "type": "POST",
    "url": "/api/article_groups/delete",
    "title": "Удаление группы статей",
    "group": "Article_Groups",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID группы статей</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticleGroupsController.php",
    "groupTitle": "Article_Groups",
    "name": "PostApiArticle_groupsDelete"
  },
  {
    "type": "GET",
    "url": "/api/article/{alias}-{id}.html",
    "title": "Просмотр статьи",
    "group": "Articles",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "GetApiArticleAliasIdHtml"
  },
  {
    "type": "GET",
    "url": "/api/articles",
    "title": "Список статей с фильтром",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "field",
            "defaultValue": "rating",
            "description": "<p>Поле сортировки для статей (доступные значения: , &quot;comments&quot;, &quot;rating&quot;, &quot;views&quot;, &quot;commented_at&quot;, &quot;published_at&quot;, &quot;created_at&quot;, &quot;deleted_at&quot;)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "order",
            "defaultValue": "asc",
            "description": "<p>Направление сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "section_id",
            "description": "<p>ID раздела для фильтра</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "term",
            "description": "<p>Строка для поиска по заголовку статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "page",
            "description": "<p>номер страницы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "GetApiArticles"
  },
  {
    "type": "GET",
    "url": "/api/articles/form",
    "title": "Форма статьи",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "article_id",
            "description": "<p>ID статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "author_id",
            "description": "<p>ID для смены пользователя (необязательно)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "GetApiArticlesForm"
  },
  {
    "type": "GET",
    "url": "/api/articles/revisions",
    "title": "Ревизии статьи",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "field",
            "description": "<p>поле сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "order",
            "description": "<p>направление сортировки</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "GetApiArticlesRevisions"
  },
  {
    "type": "GET",
    "url": "/api/articles/section",
    "title": "Получение всех статей в разделе",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID раздела</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "GetApiArticlesSection"
  },
  {
    "type": "GET",
    "url": "/api/articles/show_revision",
    "title": "Просмотр ревизии статьи",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID ревизии</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "GetApiArticlesShow_revision"
  },
  {
    "type": "GET",
    "url": "/api/articles/slug",
    "title": "Генерация статьи (slug)",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>символы для алиаса</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "article_id",
            "description": "<p>ID статьи (необязательное поле)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "GetApiArticlesSlug"
  },
  {
    "type": "GET",
    "url": "/api/articles/sort",
    "title": "Сортировка статей",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "section_id",
            "description": "<p>Id раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Поиск по статьям</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>Страница для пагинатора</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "field",
            "description": "<p>Поле для сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "order",
            "description": "<p>Сортировка по возрастанию, по убыванию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "view",
            "description": "<p>Вывод списком или сеткой (1 - сетка, 0 - список)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "GetApiArticlesSort"
  },
  {
    "type": "POST",
    "url": "/api/articles/auto_save",
    "title": "Автосохранение статьи",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<ul> <li>Токен ключ пользователя</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<ul> <li>ID статьи (если статья автоматически сохранена)</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>название статьи</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "section_id",
            "description": "<ul> <li>ID раздела</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<ul> <li>контент статьи</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "react_data",
            "description": "<ul> <li>данные для reactjs</li> </ul>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "PostApiArticlesAuto_save"
  },
  {
    "type": "POST",
    "url": "/api/articles/cancel",
    "title": "Отмена статьи и помещение в черновик",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<ul> <li>Токен ключ пользователя</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<ul> <li>ID статьи</li> </ul>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "PostApiArticlesCancel"
  },
  {
    "type": "POST",
    "url": "/api/articles/create",
    "title": "Создание статьи",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>Тело статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "JSON",
            "optional": false,
            "field": "react_data",
            "description": "<p>Данные редактора</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "section_id",
            "description": "<p>ID раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "author_id",
            "description": "<p>ID автора</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "active",
            "description": "<p>активная статья или нет</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "slug",
            "description": "<p>alias для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "seo_title",
            "description": "<p>СЕО название для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "seo_description",
            "description": "<p>СЕО описание для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "seo_h1",
            "description": "<p>СЕО h1 для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "seo_breadcrumbs",
            "description": "<p>СЕО хлебные крошки для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": true,
            "field": "published_at",
            "description": "<p>Дата публикации статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": true,
            "field": "unpublished_at",
            "description": "<p>Дата снятия с публикации</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "allow_comments",
            "description": "<p>Разрешить коментарии или нет для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "moderate_comments",
            "description": "<p>Модерировать комментарии или нет</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "draft",
            "description": "<p>Статья черновик или нет</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "tags",
            "description": "<p>Тэги для статьи (через запятую)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "images",
            "description": "<p>Картинки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "slides[]",
            "description": "<p>Картинки для слайдера</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "article_group",
            "description": "<p>Группы статей</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "content_short",
            "description": "<p>краткое описание</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "hide_author",
            "description": "<p>скрыть автора статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_article_rating",
            "description": "<p>Показывать рейтинг</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_background",
            "description": "<p>Показывать картинку на заднем фоне</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "PostApiArticlesCreate"
  },
  {
    "type": "POST",
    "url": "/api/articles/delete",
    "title": "Удаление статьи",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID статьи</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "PostApiArticlesDelete"
  },
  {
    "type": "POST",
    "url": "/api/articles/delete_article_group_article",
    "title": "Удаление статьи из группы статей",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "article_group_id",
            "description": "<p>ID группы статей</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "PostApiArticlesDelete_article_group_article"
  },
  {
    "type": "POST",
    "url": "/api/articles/delete_language",
    "title": "Удаление языка для статьи",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID удаляемого языка</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "object_type",
            "description": "<p>Тип обьекта (app\\Models\\Article, app\\Models\\Section...)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "PostApiArticlesDelete_language"
  },
  {
    "type": "POST",
    "url": "/api/articles/mass_delete",
    "title": "Массовое удаление статьи",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "ids[]",
            "description": "<p>ID статей</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "PostApiArticlesMass_delete"
  },
  {
    "type": "POST",
    "url": "/api/articles/update",
    "title": "Обновление статьи",
    "group": "Articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>Тело статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "JSON",
            "optional": false,
            "field": "react_data",
            "description": "<p>Данные редактора</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "section_id",
            "description": "<p>ID раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "active",
            "description": "<p>активная статья или нет</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "slug",
            "description": "<p>alias для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "seo_title",
            "description": "<p>СЕО название для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "seo_description",
            "description": "<p>СЕО описание для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "seo_h1",
            "description": "<p>СЕО h1 для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "seo_breadcrumbs",
            "description": "<p>СЕО хлебные крошки для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "author_id",
            "description": "<ul> <li>ID автора</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": true,
            "field": "published_at",
            "description": "<p>Дата публикации статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "allow_comments",
            "description": "<p>Разрешить коментарии или нет для статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "moderate_comments",
            "description": "<p>Модерировать комментарии или нет</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "draft",
            "description": "<p>Статья черновик или нет</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "tags",
            "description": "<p>Тэги для статьи (через запятую)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "images[]",
            "description": "<p>Картинки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "slides[]",
            "description": "<p>Картинки для слайдера</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "article_group",
            "description": "<p>группа статей article_group[name: &quot;...&quot;, article_id, items: [[article_id: 1, name: &quot;name&quot;, sort_o rder: 1]]]</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "other_section_id",
            "description": "<p>Перенос статьи в другой раздел и на другой сайт</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "language_articles",
            "description": "<p>связка языковых статей [language_id =&gt; ...,article_id =&gt; ... (nullable),title =&gt; ...,slug =&gt; ...]</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "content_short",
            "description": "<p>краткое описание</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "hide_author",
            "description": "<p>скрыть автора статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_article_rating",
            "description": "<p>Показывать рейтинг</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_background",
            "description": "<p>Показывать картинку на заднем фоне</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ArticlesController.php",
    "groupTitle": "Articles",
    "name": "PostApiArticlesUpdate"
  },
  {
    "type": "GET",
    "url": "/api/credentials/user/{id}",
    "title": "Получение данных пользователя",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "id",
            "description": "<p>ID пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CredentialsController.php",
    "groupTitle": "Auth",
    "name": "GetApiCredentialsUserId"
  },
  {
    "type": "GET",
    "url": "/api/logged",
    "title": "Проверка авторизации",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AuthController.php",
    "groupTitle": "Auth",
    "name": "GetApiLogged"
  },
  {
    "type": "POST",
    "url": "/api/login",
    "title": "Логинизация",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "login",
            "description": "<p>Телефон, имя пользователя или e-mail</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>пароль</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "hash",
            "description": "<p>Хэш для авторизации</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AuthController.php",
    "groupTitle": "Auth",
    "name": "PostApiLogin"
  },
  {
    "type": "POST",
    "url": "/api/logout",
    "title": "Logout",
    "group": "Auth",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/AuthController.php",
    "groupTitle": "Auth",
    "name": "PostApiLogout"
  },
  {
    "type": "POST",
    "url": "/api/profile/change_domain_nick",
    "title": "Смена домена и ника",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain",
            "description": "<p>Имя нового или текущего домена в виде domain.tld</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Auth",
    "name": "PostApiProfileChange_domain_nick"
  },
  {
    "type": "POST",
    "url": "/api/profile/change_username",
    "title": "Смена ника",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>Новое имя пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Auth",
    "name": "PostApiProfileChange_username"
  },
  {
    "type": "GET",
    "url": "/api/services/info",
    "title": "Инфо о сервисе перед оплатой",
    "group": "Billing",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "service_id",
            "description": "<p>ID сервиса</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "options",
            "description": "<p>опции сервиса [{id: N, count: M}]</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/ServicesController.php",
    "groupTitle": "Billing",
    "name": "GetApiServicesInfo"
  },
  {
    "type": "POST",
    "url": "/api/services/pay",
    "title": "Оплата сервиса",
    "group": "Billing",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "service_id",
            "description": "<p>ID сервиса</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "options",
            "description": "<p>опции сервиса [{id: N, count: M}]</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "autorenew",
            "description": "<p>автопродление сервиса</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/ServicesController.php",
    "groupTitle": "Billing",
    "name": "PostApiServicesPay"
  },
  {
    "type": "POST",
    "url": "/api/balance/add",
    "title": "Добавление баланса на счет пользователя",
    "group": "Billing_balance",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "amount",
            "description": "<p>кол-во валюты</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "back_url",
            "description": "<p>URL успешной оплаты</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "iso_code",
            "description": "<p>Код валюты</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "autorenew",
            "description": "<p>автоподписка на все сервисы и тарифы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/BalanceController.php",
    "groupTitle": "Billing_balance",
    "name": "PostApiBalanceAdd"
  },
  {
    "type": "GET",
    "url": "/api/currency/form",
    "title": "Форма пополнения баланса",
    "group": "Billing_currency",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/CurrencyController.php",
    "groupTitle": "Billing_currency",
    "name": "GetApiCurrencyForm"
  },
  {
    "type": "GET",
    "url": "/api/currency/get_discounts",
    "title": "Конвертирование валюты",
    "group": "Billing_currency",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "iso_code",
            "description": "<p>код валюты</p>"
          },
          {
            "group": "Parameter",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/CurrencyController.php",
    "groupTitle": "Billing_currency",
    "name": "GetApiCurrencyGet_discounts"
  },
  {
    "type": "POST",
    "url": "/api/currency/convert",
    "title": "Конвертирование валюты",
    "group": "Billing_currency",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "from",
            "description": "<p>С какой валюты конвертировать (международный код)</p>"
          },
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "amount",
            "description": "<p>кол-во валюты</p>"
          },
          {
            "group": "Parameter",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/CurrencyController.php",
    "groupTitle": "Billing_currency",
    "name": "PostApiCurrencyConvert"
  },
  {
    "type": "POST",
    "url": "/api/currency/convert_to_points",
    "title": "Конвертирование рублей и баллов",
    "group": "Billing_currency",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Float",
            "optional": false,
            "field": "amount",
            "description": "<p>кол-во валюты или баллов</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "from",
            "description": "<p>из баллов в поинты и наоборот (1 - из валюты в баллы, 2 - из баллов в валюту)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "iso_code",
            "description": "<p>ISO код валюты</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/CurrencyController.php",
    "groupTitle": "Billing_currency",
    "name": "PostApiCurrencyConvert_to_points"
  },
  {
    "type": "GET",
    "url": "/api/discount",
    "title": "Данные скидок",
    "group": "Billing_dicounts",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/BillingController.php",
    "groupTitle": "Billing_dicounts",
    "name": "GetApiDiscount"
  },
  {
    "type": "GET",
    "url": "/api/billing/history",
    "title": "История оплат",
    "group": "Billing_history",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Строка для поиска по описанию</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>Страница для пагинации</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "dates",
            "description": "<p>массив дат в json формате</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "field",
            "description": "<p>Сортировка по полю (из sort_options)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "order",
            "description": "<p>Направление сортировки (из sort_directions)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "site_id",
            "description": "<p>Выборка по сайту (обьект sites)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/BillingController.php",
    "groupTitle": "Billing_history",
    "name": "GetApiBillingHistory"
  },
  {
    "type": "GET",
    "url": "/api/profile/services",
    "title": "Подписки сервисов",
    "group": "Billing_services",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "token",
            "description": "<p>Token пользователя</p>"
          },
          {
            "group": "Parameter",
            "optional": false,
            "field": "field",
            "description": "<p>Сортировка по полю (0 - сайт, 1 - название, 2 - дата начала сервиса, 3 - дата следующего списания, 4 - дата окончания)</p>"
          },
          {
            "group": "Parameter",
            "optional": false,
            "field": "order",
            "description": "<p>Направление сортировки (0 - по возрастанию, 1 - по убыванию)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/MyServicesController.php",
    "groupTitle": "Billing_services",
    "name": "GetApiProfileServices"
  },
  {
    "type": "GET",
    "url": "/api/services",
    "title": "Данные для сервисов",
    "group": "Billing_services",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/ServicesController.php",
    "groupTitle": "Billing_services",
    "name": "GetApiServices"
  },
  {
    "type": "GET",
    "url": "/api/profile/sites",
    "title": "Сайты, сервисы и тариф",
    "group": "Billing_sites",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/MySitesController.php",
    "groupTitle": "Billing_sites",
    "name": "GetApiProfileSites"
  },
  {
    "type": "POST",
    "url": "/api/subscription_services/delete",
    "title": "Удаление сервиса",
    "group": "Billing_subscriptions",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID сервиса</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "delete_forever",
            "description": "<p>Мягкое удаление - 0, полное удаление - 1</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/SubscriptionServicesController.php",
    "groupTitle": "Billing_subscriptions",
    "name": "PostApiSubscription_servicesDelete"
  },
  {
    "type": "POST",
    "url": "/api/subscriptions/delete",
    "title": "Удаление подписки с сервисами",
    "group": "Billing_subscriptions",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID подписки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "delete_forever",
            "description": "<p>Мягкое удаление - 0, полное удаление - 1</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/SubscriptionsController.php",
    "groupTitle": "Billing_subscriptions",
    "name": "PostApiSubscriptionsDelete"
  },
  {
    "type": "GET",
    "url": "/api/profile/tariffs",
    "title": "Тарифы и сервисы, заказы",
    "group": "Billing_tariffs",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/MyTariffsController.php",
    "groupTitle": "Billing_tariffs",
    "name": "GetApiProfileTariffs"
  },
  {
    "type": "GET",
    "url": "/api/tariffs",
    "title": "Данные для тарифов",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token пользователя</p>"
          }
        ]
      }
    },
    "group": "Billing_tariffs",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/TariffsController.php",
    "groupTitle": "Billing_tariffs",
    "name": "GetApiTariffs"
  },
  {
    "type": "GET",
    "url": "/api/tariffs/info",
    "title": "Инфо о тарифе перед оплатой",
    "group": "Billing_tariffs",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "tariff_id",
            "description": "<p>ID тарифа</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/TariffsController.php",
    "groupTitle": "Billing_tariffs",
    "name": "GetApiTariffsInfo"
  },
  {
    "type": "POST",
    "url": "/api/tariffs/pay",
    "title": "Оплата тарифа",
    "group": "Billing_tariffs",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "tariff_id",
            "description": "<p>ID тарифа</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "autorenew",
            "description": "<p>автопродление тарифа</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Token пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Billing/TariffsController.php",
    "groupTitle": "Billing_tariffs",
    "name": "PostApiTariffsPay"
  },
  {
    "type": "GET",
    "url": "/api/modules/v2/menu_advanced/search",
    "title": "Поиск",
    "group": "Block_menu__advanced_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>слово для поиска</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/MenuAdvancedController.php",
    "groupTitle": "Block_menu__advanced_",
    "name": "GetApiModulesV2Menu_advancedSearch"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/menu_advanced/create",
    "title": "Создание пункта меню",
    "group": "Block_menu__advanced_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Название для блока</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "url",
            "description": "<p>URL</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "image",
            "description": "<p>URL картинки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort_order",
            "description": "<p>Порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>ID родителя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_menu_advanced_id",
            "description": "<p>ID модуля в системе</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/MenuAdvancedController.php",
    "groupTitle": "Block_menu__advanced_",
    "name": "PostApiModulesV2Menu_advancedCreate"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/menu_advanced/delete",
    "title": "Удаление пункта меню",
    "group": "Block_menu__advanced_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID Url-a</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/MenuAdvancedController.php",
    "groupTitle": "Block_menu__advanced_",
    "name": "PostApiModulesV2Menu_advancedDelete"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/menu_advanced/update",
    "title": "Обновление пункта меню",
    "group": "Block_menu__advanced_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Название для блока</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID пункта меню</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "url",
            "description": "<p>URL</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "image",
            "description": "<p>URL картинки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort_order",
            "description": "<p>Порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>ID родителя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_menu_advanced_id",
            "description": "<p>ID модуля в системе</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/MenuAdvancedController.php",
    "groupTitle": "Block_menu__advanced_",
    "name": "PostApiModulesV2Menu_advancedUpdate"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/menu_advanced/sort",
    "title": "Сортировка блока меню (advanced)",
    "group": "Block_menu_advanced",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_menu_advanced_id",
            "description": "<p>ID модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "items",
            "description": "<p>массив в виде items[0][id], items[0][sort_order].</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/MenuAdvancedController.php",
    "groupTitle": "Block_menu_advanced",
    "name": "PostApiModulesV2Menu_advancedSort"
  },
  {
    "type": "GET",
    "url": "/api/cart",
    "title": "Корзина пользователя",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserCartController.php",
    "groupTitle": "Cart",
    "name": "GetApiCart"
  },
  {
    "type": "POST",
    "url": "/api/cart/add",
    "title": "Добавление в корзину",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "count",
            "description": "<p>количество продуктов</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserCartController.php",
    "groupTitle": "Cart",
    "name": "PostApiCartAdd"
  },
  {
    "type": "POST",
    "url": "/api/cart/checkout",
    "title": "Оплата корзины",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserCartController.php",
    "groupTitle": "Cart",
    "name": "PostApiCartCheckout"
  },
  {
    "type": "POST",
    "url": "/api/cart/delete",
    "title": "Удаление продукта из корзины",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID обьекта в корзине</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserCartController.php",
    "groupTitle": "Cart",
    "name": "PostApiCartDelete"
  },
  {
    "type": "POST",
    "url": "/api/cart/update",
    "title": "Обновление продукта в корзине",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "count",
            "description": "<p>количество продуктов (0 &lt; n &gt; 0)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UserCartController.php",
    "groupTitle": "Cart",
    "name": "PostApiCartUpdate"
  },
  {
    "type": "GET",
    "url": "/api/catalog/categories",
    "title": "Список категорий каталога",
    "group": "Catalog",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "catalog_id",
            "description": "<p>каталог пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>сделать вывод части дерева</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/CategoryController.php",
    "groupTitle": "Catalog",
    "name": "GetApiCatalogCategories"
  },
  {
    "type": "GET",
    "url": "/api/catalog/category/update",
    "title": "Обновление категории",
    "group": "Catalog",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>имя категории</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>краткое описание</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": false,
            "field": "content",
            "description": "<p>полное описание</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>родительский раздел</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/CategoryController.php",
    "groupTitle": "Catalog",
    "name": "GetApiCatalogCategoryUpdate"
  },
  {
    "type": "POST",
    "url": "/api/catalog/category/create",
    "title": "Создание категории",
    "group": "Catalog",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>название категории</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>краткое описание</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": false,
            "field": "content",
            "description": "<p>полное описание</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>родительский раздел</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/CategoryController.php",
    "groupTitle": "Catalog",
    "name": "PostApiCatalogCategoryCreate"
  },
  {
    "type": "POST",
    "url": "/api/catalog/category/delete",
    "title": "Удаление категории",
    "group": "Catalog",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID раздела</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/CategoryController.php",
    "groupTitle": "Catalog",
    "name": "PostApiCatalogCategoryDelete"
  },
  {
    "type": "GET",
    "url": "/api/comments",
    "title": "Список комментариев для обьекта",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "o",
            "description": "<p>Класс обьекта (App\\Models\\Article)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "o_id",
            "description": "<p>ID обьекта</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "GetApiComments"
  },
  {
    "type": "GET",
    "url": "/api/comments/edit",
    "title": "Редактирование комментария",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID комментария</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "GetApiCommentsEdit"
  },
  {
    "type": "POST",
    "url": "/api/comments/add",
    "title": "Добавление комментария",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "o_id",
            "description": "<p>ID обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "parent_id",
            "description": "<p>родительский комментарий</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "o",
            "description": "<p>Имя класса обьекта (&quot;App\\Models\\Article&quot;)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>контент</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsAdd"
  },
  {
    "type": "POST",
    "url": "/api/comments/archive",
    "title": "Архивация комментариев",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "article_id",
            "description": "<p>ID статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "from_date",
            "description": "<p>Дата начала архивации (YYYY-MM-DD HH:MM:SS)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsArchive"
  },
  {
    "type": "POST",
    "url": "/api/comments/batch_change_status",
    "title": "Мультиизменение статуса комментариев",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "o",
            "description": "<p>Обьект (например App\\Models\\Article)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "o_id",
            "description": "<p>ID обьекта с комментариями</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "comments",
            "description": "<p>Комментарии. Например: comments[1, 4, 6, 88...]</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "status",
            "description": "<p>Статус комментариев (0 - подтвержден, 1 - на модерации)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsBatch_change_status"
  },
  {
    "type": "POST",
    "url": "/api/comments/batch_delete",
    "title": "Мультиудаление комментариев",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "o",
            "description": "<p>Обьект (например App\\Models\\Article)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "o_id",
            "description": "<p>ID обьекта с комментариями</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "comments",
            "description": "<p>Комментарии. Например: comments[1,4,6,88...]</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsBatch_delete"
  },
  {
    "type": "POST",
    "url": "/api/comments/batch_move",
    "title": "Мульти перенос комментариев",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "o",
            "description": "<p>Обьект (например App\\Models\\Article)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "o_id",
            "description": "<p>ID обьекта с комментариями</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "new_o",
            "description": "<p>Новый обьект (например App\\Models\\Article)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "new_o_id",
            "description": "<p>Новый ID обьекта с комментариями</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "comments",
            "description": "<p>Комментарии. Например: comments[1, 4, 6, 88...]</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsBatch_move"
  },
  {
    "type": "POST",
    "url": "/api/comments/delete",
    "title": "Удаление комментария",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID комментария</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>хеш пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsDelete"
  },
  {
    "type": "POST",
    "url": "/api/comments/moderate",
    "title": "Модерация комментария",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>comment id</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "moderated",
            "description": "<p>moderation status: 0 - false, 1 - true</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsModerate"
  },
  {
    "type": "POST",
    "url": "/api/comments/pin",
    "title": "Прикрепление комментария к статье",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID комментария</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsPin"
  },
  {
    "type": "POST",
    "url": "/api/comments/unpin",
    "title": "Открепление комментария",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID комментария</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsUnpin"
  },
  {
    "type": "POST",
    "url": "/api/comments/update",
    "title": "Обновление комментария",
    "group": "Comments",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID комментария</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>контент</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/CommentsController.php",
    "groupTitle": "Comments",
    "name": "PostApiCommentsUpdate"
  },
  {
    "type": "GET",
    "url": "/api/contacts",
    "title": "Страница контактов",
    "group": "Contacts",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ContactsController.php",
    "groupTitle": "Contacts",
    "name": "GetApiContacts"
  },
  {
    "group": "Deletables",
    "type": "GET",
    "url": "/api/deletable_objects",
    "title": "Список удаляемых обьектов",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ приложения</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/DeletableObjectsController.php",
    "groupTitle": "Deletables",
    "name": "GetApiDeletable_objects"
  },
  {
    "type": "POST",
    "url": "/api/deletable_objects/destroy",
    "title": "Удаление обьекта (Soft delete)",
    "group": "Deletables",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "object",
            "description": "<p>Тип обьекта для удаления (из /api/deletable_objects)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ приложения</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/DeletableObjectsController.php",
    "groupTitle": "Deletables",
    "name": "PostApiDeletable_objectsDestroy"
  },
  {
    "type": "GET",
    "url": "/api/domains/check",
    "title": "Проверка домена (NS, валидация)",
    "group": "Domains",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>имя домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/DomainsController.php",
    "groupTitle": "Domains",
    "name": "GetApiDomainsCheck"
  },
  {
    "type": "GET",
    "url": "/api/domains/personal",
    "title": "Список пресональных доменов",
    "group": "Domains",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/DomainsController.php",
    "groupTitle": "Domains",
    "name": "GetApiDomainsPersonal"
  },
  {
    "type": "POST",
    "url": "/api/domains/change_user",
    "title": "Изменение пользователя домена",
    "group": "Domains",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "new_user_id",
            "description": "<p>Новый пользователь</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain_name",
            "description": "<p>Имя домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/DomainsController.php",
    "groupTitle": "Domains",
    "name": "PostApiDomainsChange_user"
  },
  {
    "type": "POST",
    "url": "/api/domains/check_subdomain",
    "title": "Проверка сабдомена",
    "group": "Domains",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "domain_id",
            "description": "<p>ID домена из списка тематических доменов</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/DomainsController.php",
    "groupTitle": "Domains",
    "name": "PostApiDomainsCheck_subdomain"
  },
  {
    "type": "POST",
    "url": "/api/domains/thematic",
    "title": "Тематические домены",
    "group": "Domains",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/DomainsController.php",
    "groupTitle": "Domains",
    "name": "PostApiDomainsThematic"
  },
  {
    "type": "GET",
    "url": "/api/feedback",
    "title": "Получение формы обратной связи",
    "group": "Feedback",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/FeedbackController.php",
    "groupTitle": "Feedback",
    "name": "GetApiFeedback"
  },
  {
    "type": "GET",
    "url": "/api/feedback/fields",
    "title": "Обратная связь по ID",
    "group": "Feedback",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "feedback_id",
            "description": "<p>ID обратной связи</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/FeedbackController.php",
    "groupTitle": "Feedback",
    "name": "GetApiFeedbackFields"
  },
  {
    "type": "POST",
    "url": "/api/feedback/log",
    "title": "Лог обратной связи",
    "group": "Feedback",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/FeedbackController.php",
    "groupTitle": "Feedback",
    "name": "PostApiFeedbackLog"
  },
  {
    "type": "POST",
    "url": "/api/feedback/send",
    "title": "Отправка обратной связи",
    "group": "Feedback",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>ФИО</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>Email пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>телефон</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "message",
            "description": "<p>сообщение</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/FeedbackController.php",
    "groupTitle": "Feedback",
    "name": "PostApiFeedbackSend"
  },
  {
    "type": "POST",
    "url": "/api/forgot/change-password",
    "title": "Смена пароля",
    "group": "Forgot_password",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>User username|email|phone (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>User code</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>password</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password_confirmation",
            "description": "<p>password confirmation</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ForgotController.php",
    "groupTitle": "Forgot_password",
    "name": "PostApiForgotChangePassword"
  },
  {
    "type": "POST",
    "url": "/api/forgot/check-code",
    "title": "Проверка кода",
    "group": "Forgot_password",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>User code</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ForgotController.php",
    "groupTitle": "Forgot_password",
    "name": "PostApiForgotCheckCode"
  },
  {
    "type": "POST",
    "url": "/api/forgot/check-login",
    "title": "Проверка логина",
    "group": "Forgot_password",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "login",
            "description": "<p>Логин пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ForgotController.php",
    "groupTitle": "Forgot_password",
    "name": "PostApiForgotCheckLogin"
  },
  {
    "type": "POST",
    "url": "/api/forgot/send-code",
    "title": "Отправка кода",
    "group": "Forgot_password",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>User username|email|phone</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ForgotController.php",
    "groupTitle": "Forgot_password",
    "name": "PostApiForgotSendCode"
  },
  {
    "type": "POST",
    "url": "/api/export/site",
    "title": "Экспорт сайта",
    "group": "Import_Export",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "site_id",
            "description": "<p>siteId</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain",
            "description": "<p>(or domainName)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>AuthKey</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ExportController.php",
    "groupTitle": "Import_Export",
    "name": "PostApiExportSite"
  },
  {
    "type": "GET",
    "url": "/api/language/form",
    "title": "Форма для создания мультиязычности",
    "group": "Language",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/LanguageController.php",
    "groupTitle": "Language",
    "name": "GetApiLanguageForm"
  },
  {
    "type": "POST",
    "url": "/api/language/add",
    "title": "Добавление языка",
    "group": "Language",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "language_id",
            "description": "<p>ID языка</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/LanguageController.php",
    "groupTitle": "Language",
    "name": "PostApiLanguageAdd"
  },
  {
    "type": "POST",
    "url": "/api/language/add_domain",
    "title": "Добавление мультиязычного сайта",
    "group": "Language",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain",
            "description": "<p>Имя домена (en.domain.com или mydomain.com)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "languageId",
            "description": "<p>ID языка</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/LanguageController.php",
    "groupTitle": "Language",
    "name": "PostApiLanguageAdd_domain"
  },
  {
    "type": "POST",
    "url": "/api/language/my_domain",
    "title": "Добавление своего домена",
    "group": "Language",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain",
            "description": "<p>имя подключаемого домена</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "language_id",
            "description": "<p>ID языка</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/LanguageController.php",
    "groupTitle": "Language",
    "name": "PostApiLanguageMy_domain"
  },
  {
    "group": "Main_Menu",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "is_visible",
            "description": "<p>0 - невидимая ссылка, 1 - видимая</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID пункта меню</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/MenuController.php",
    "groupTitle": "Main_Menu",
    "name": ""
  },
  {
    "type": "POST",
    "url": "/api/menu/create",
    "title": "Создание пункта меню",
    "group": "Main_Menu",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "url",
            "description": "<p>URL</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "image",
            "description": "<p>URL картинки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort_order",
            "description": "<p>Порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>ID родителя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/MenuController.php",
    "groupTitle": "Main_Menu",
    "name": "PostApiMenuCreate"
  },
  {
    "type": "POST",
    "url": "/api/menu/delete",
    "title": "Удаление пункта меню",
    "group": "Main_Menu",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID пункта меню</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/MenuController.php",
    "groupTitle": "Main_Menu",
    "name": "PostApiMenuDelete"
  },
  {
    "type": "POST",
    "url": "/api/menu/sort",
    "title": "Сортировка меню",
    "group": "Main_Menu",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "urls",
            "description": "<p>массив в виде urls[0][id], urls[0][sort_order].</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/MenuController.php",
    "groupTitle": "Main_Menu",
    "name": "PostApiMenuSort"
  },
  {
    "type": "POST",
    "url": "/api/menu/update",
    "title": "Обновление пункта меню",
    "group": "Main_Menu",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название для блока</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID пункта меню</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "url",
            "description": "<p>URL</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "image",
            "description": "<p>URL картинки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort_order",
            "description": "<p>Порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>ID родителя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/MenuController.php",
    "groupTitle": "Main_Menu",
    "name": "PostApiMenuUpdate"
  },
  {
    "type": "POST",
    "url": "/api/menu",
    "title": "Меню для сайта",
    "group": "Menu",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/MenuController.php",
    "groupTitle": "Menu",
    "name": "PostApiMenu"
  },
  {
    "type": "GET",
    "url": "/api/pool/index",
    "title": "Get moderation articles and comments",
    "group": "Moderators",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ModerationPoolController.php",
    "groupTitle": "Moderators",
    "name": "GetApiPoolIndex"
  },
  {
    "type": "POST",
    "url": "/api/pool/answer",
    "title": "Answer on complain",
    "group": "Moderators",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID Обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "answer",
            "description": "<p>Ответ на жалобу</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ModerationPoolController.php",
    "groupTitle": "Moderators",
    "name": "PostApiPoolAnswer"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/competitive-advantages/items/add_or_update",
    "title": "Создание обновление преймущества (v2)",
    "group": "Module_Competitive_Advantages",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "advantages_id",
            "description": "<p>ID модуля преймуществ</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID блока в модуле (без ID создание, с ID обновление)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content_options",
            "description": "<p>опции контента</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>имя блока</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>описание</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>номер по порядку</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/CompetitiveAdvantagesController.php",
    "groupTitle": "Module_Competitive_Advantages",
    "name": "PostApiModulesV2CompetitiveAdvantagesItemsAdd_or_update"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/competitive-advantages/items/copy",
    "title": "Копирование преймуществ (v2)",
    "group": "Module_Competitive_Advantages",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "advantages_id",
            "description": "<p>ID модуля преймуществ</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "ids",
            "description": "<p>ID блоков в модуле</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/CompetitiveAdvantagesController.php",
    "groupTitle": "Module_Competitive_Advantages",
    "name": "PostApiModulesV2CompetitiveAdvantagesItemsCopy"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/competitive-advantages/items/delete",
    "title": "Удаление преймуществ (v2)",
    "group": "Module_Competitive_Advantages",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "advantages_id",
            "description": "<p>ID модуля преймуществ</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "ids",
            "description": "<p>ID блоков в модуле</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/CompetitiveAdvantagesController.php",
    "groupTitle": "Module_Competitive_Advantages",
    "name": "PostApiModulesV2CompetitiveAdvantagesItemsDelete"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/feedback/send",
    "title": "Отправление обратной связи (v2)",
    "group": "Module_Feedback",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "field_group_id",
            "description": "<p>ID группы полей (для модуля преймуществ, без module_id)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "fields",
            "description": "<p>Массив полей в виде: fields: [{alias: &quot;...&quot;, name: &quot;...&quot;, required: 0|1 }]</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_id",
            "description": "<p>ID модуля</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/FeedbackController.php",
    "groupTitle": "Module_Feedback",
    "name": "PostApiModulesV2FeedbackSend"
  },
  {
    "type": "GET",
    "url": "/api/modules/article/sort",
    "title": "Сортировка модуля статей",
    "group": "Module_articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID модуля статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_id",
            "description": "<p>ID модуля читаемое</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_by",
            "description": "<p>сортировка (1 - по кол-ву просмотров, 2 - по рейтингу, 3 - по кол-ву коментариев, 4 - под дате публикации)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>сортировка читаемого (1 - по возрастанию, 2 - по убыванию)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/ArticleController.php",
    "groupTitle": "Module_articles",
    "name": "GetApiModulesArticleSort"
  },
  {
    "type": "GET",
    "url": "/api/modules/articles/search",
    "title": "Поиск раздела для модуля статьи",
    "group": "Module_articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Строка для поиска</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/ArticleController.php",
    "groupTitle": "Module_articles",
    "name": "GetApiModulesArticlesSearch"
  },
  {
    "type": "GET",
    "url": "/api/modules/v2/catalog/get_filter_data",
    "title": "Выбор для фильтра каталога",
    "group": "Module_catalog",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID обьекта для фильтра</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>хеш пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/CatalogController.php",
    "groupTitle": "Module_catalog",
    "name": "GetApiModulesV2CatalogGet_filter_data"
  },
  {
    "type": "POST",
    "url": "/api/modules/catalog/create",
    "title": "Создание блока каталога",
    "group": "Module_catalog",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "content",
            "description": "<p>контент для блока</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_id",
            "description": "<p>ID модуля в системе</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_settings_id",
            "description": "<p>ID настроек модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_cell_id",
            "description": "<p>ID ячейки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_type_id",
            "description": "<p>тип строки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "position",
            "description": "<p>позиция блока 1 - Header, 2 - Footer, 3 - Content</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "filter_settings",
            "description": "<p>массив фильтров для каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "sort_options",
            "description": "<p>массив для сортировки каталога по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID обьекта для фильтра и каталога</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/CatalogController.php",
    "groupTitle": "Module_catalog",
    "name": "PostApiModulesCatalogCreate"
  },
  {
    "type": "POST",
    "url": "/api/modules/catalog/delete",
    "title": "Удаление блока каталога",
    "group": "Module_catalog",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID модуля каталога</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/CatalogController.php",
    "groupTitle": "Module_catalog",
    "name": "PostApiModulesCatalogDelete"
  },
  {
    "type": "POST",
    "url": "/api/modules/catalog/edit",
    "title": "Редактирование блока каталога",
    "group": "Module_catalog",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID модуля каталога</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/CatalogController.php",
    "groupTitle": "Module_catalog",
    "name": "PostApiModulesCatalogEdit"
  },
  {
    "type": "POST",
    "url": "/api/modules/catalog/update",
    "title": "Обновление блока каталога",
    "group": "Module_catalog",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>контент для блока</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID модуля каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Имя для блока каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_id",
            "description": "<p>ID модуля в системе</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_settings_id",
            "description": "<p>ID настроек блока</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "filter_settings",
            "description": "<p>массив фильтров для каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "sort_options",
            "description": "<p>массив для сортировки каталога по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID обьекта для фильтра и каталога</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/CatalogController.php",
    "groupTitle": "Module_catalog",
    "name": "PostApiModulesCatalogUpdate"
  },
  {
    "type": "GET",
    "url": "/api/modules/section/edit",
    "title": "Настройки для блока разделов",
    "group": "Module_section",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "module_settings_id",
            "description": "<p>данные редактирования для блока (не обязательно)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "module_id",
            "description": "<p>ID модуля разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "id",
            "description": "<p>ID раздела</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/SectionController.php",
    "groupTitle": "Module_section",
    "name": "GetApiModulesSectionEdit"
  },
  {
    "type": "GET",
    "url": "/api/modules/section/sort",
    "title": "Сортировка модуля разделов",
    "group": "Module_section",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID настроек для модуля разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_id",
            "description": "<p>ID модуля раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_by",
            "description": "<p>сортировка (1 - по заголовку, 2 - по рейтингу, 3 - по кол-ву статей, 4 - под дате публикации)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>сортировка читаемого (1 - по возрастанию, 2 - по убыванию)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/SectionController.php",
    "groupTitle": "Module_section",
    "name": "GetApiModulesSectionSort"
  },
  {
    "type": "POST",
    "url": "/api/modules/section/create",
    "title": "Создание блока разделов",
    "group": "Module_section",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_id",
            "description": "<p>ID модуля разелов</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "position",
            "description": "<p>позиция модуля (1 - Header, 2 - Footer, 3 - Content)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_cell_id",
            "description": "<p>ID ячейки строки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_type_id",
            "description": "<p>ID типа ячейки блока (расширяемый, с отступами по бокам)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "name",
            "description": "<p>название блока</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "submodule",
            "description": "<p>0|1 (для добавления в ячейку - 1 )</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_settings_id",
            "description": "<p>ID настроек для модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_by",
            "description": "<p>сортировка (1 - по заголовку, 2 - по рейтингу, 3 - по кол-ву статей, 4 - под дате публикации)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "view",
            "description": "<p>вид блока (1 - вертикальный блок, 2 - горизонтальный блок)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>сортировка читаемого (1 - по возрастанию, 2 - по убыванию)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_view",
            "description": "<p>блок список/сетка (0 - список, 1 - сетка)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/SectionController.php",
    "groupTitle": "Module_section",
    "name": "PostApiModulesSectionCreate"
  },
  {
    "type": "POST",
    "url": "/api/modules/section/delete",
    "title": "Удаление модуля раздела со строки",
    "group": "Module_section",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID модуля раздела</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/SectionController.php",
    "groupTitle": "Module_section",
    "name": "PostApiModulesSectionDelete"
  },
  {
    "type": "POST",
    "url": "/api/modules/section/update",
    "title": "Обновление блока разделов",
    "group": "Module_section",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_id",
            "description": "<p>ID настроек модуля разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID модуля разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "position",
            "description": "<p>позиция модуля (1 - Header, 2 - Footer, 3 - Content)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_cell_id",
            "description": "<p>ID ячейки строки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_type_id",
            "description": "<p>ID типа ячейки блока (расширяемый, с отступами по бокам)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "name",
            "description": "<p>название блока</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "submodule",
            "description": "<p>0|1 (для добавления в ячейку - 1 )</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_settings_id",
            "description": "<p>ID настроек для модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_by",
            "description": "<p>сортировка (1 - по заголовку, 2 - по рейтингу, 3 - по кол-ву статей, 4 - под дате публикации)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "view",
            "description": "<p>вид блока (1 - вертикальный блок, 2 - горизонтальный блок)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_view",
            "description": "<p>блок список/сетка (0 - список, 1 - сетка)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>сортировка читаемого (1 - по возрастанию, 2 - по убыванию)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/SectionController.php",
    "groupTitle": "Module_section",
    "name": "PostApiModulesSectionUpdate"
  },
  {
    "type": "POST",
    "url": "/api/modules/section/validate",
    "title": "Валидация блока разделов",
    "group": "Module_section",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "view",
            "description": "<p>вид списка разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_by",
            "description": "<p>поле для сортировки (1 - название, 2 - рейтинг, 3 - кол-во статей, 4 - дата публикации)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>направление сортировки (1 - по возрастанию, 2 - по убыванию)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "position",
            "description": "<p>позиция строки (1 - хэдер, 2 - футер, 3 - контент)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>имя блока</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_cell_id",
            "description": "<p>ID ячейки блока</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "block_type_id",
            "description": "<p>ID типа блока</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/SectionController.php",
    "groupTitle": "Module_section",
    "name": "PostApiModulesSectionValidate"
  },
  {
    "type": "POST",
    "url": "/api/modules/slide/delete",
    "title": "Удаление слайда (v2)",
    "group": "Module_slide__v2_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID слайда</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/SlideController.php",
    "groupTitle": "Module_slide__v2_",
    "name": "PostApiModulesSlideDelete"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/slide/add_or_update",
    "title": "добавление обновление слайда (v2)",
    "group": "Module_slide__v2_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "slides",
            "description": "<p>Массив слайдов с полями ниже: slides[0][sort_order], slides[0][url], slides[0][title] и тд...</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": false,
            "field": "url",
            "description": "<p>URL для слайдера</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "short_description",
            "description": "<p>Краткое описание</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "slider_type",
            "description": "<p>Тип слайдера: 1 - статический, 2 - динамический</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "content_type",
            "description": "<p>Тип контента: 1 - статьи, 2 - разделы</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "sort_by",
            "description": "<p>Сортировка, 1 - дата публикации, 2 - рейтинг, 3 - количество просмотров</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "sort_order",
            "description": "<p>Направление сортировки, 1 - ASC, 2 - DESC</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "slides_count",
            "description": "<p>Кол-во слайдов в одной группе динамического слайда</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "period",
            "description": "<p>Период, за который будут браться статьи и разделы или еще какой контент. 1 - за день, 2 - за неделю, 3 - за месяц, 4 - свой вариант выборки</p>"
          },
          {
            "group": "Parameter",
            "type": "DateTime",
            "optional": false,
            "field": "period_start",
            "description": "<p>Дата начала промежутка выборки</p>"
          },
          {
            "group": "Parameter",
            "type": "DateTime",
            "optional": false,
            "field": "period_end",
            "description": "<p>Дата конца промежутка выборки</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "publish",
            "description": "<p>Дата публикации, 1 - день, 2 - неделя, 3 - месяц, 4 - свой вариант дат</p>"
          },
          {
            "group": "Parameter",
            "type": "DateTime",
            "optional": false,
            "field": "publish_start",
            "description": "<p>Дата начала действия слайдера</p>"
          },
          {
            "group": "Parameter",
            "type": "DateTime",
            "optional": false,
            "field": "publish_end",
            "description": "<p>Дата конца дейтсвия слайдера</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "submodule",
            "description": "<p>1 - сабмодуль, 0 - нет</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "show_statistic",
            "description": "<p>1 - да, 0 - нет</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "module_slide_sort_order",
            "description": "<p>Сортировка слайдов внутри слайдера. Массив: [1...100]</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID слайда</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "module_slider_id",
            "description": "<p>ID слайдера</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/SlideController.php",
    "groupTitle": "Module_slide__v2_",
    "name": "PostApiModulesV2SlideAdd_or_update"
  },
  {
    "type": "POST",
    "url": "/api/modules/v2/slider/validate",
    "title": "Валидация слайдера (v2)",
    "group": "Module_slider__v2_",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>направление сортировки (1 - по возрастанию, 2 - по убыванию)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>имя блока</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "slider_type",
            "description": "<p>Тип слайдера (1 - статический, 2 - динамический)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "url",
            "description": "<p>URL раздела или статьи (для статического слайдера)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "image",
            "description": "<p>путь к картинке (для статического слайдера)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "short_description",
            "description": "<p>краткое описание (для статического слайдера)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "section_id",
            "description": "<p>ID раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "article_id",
            "description": "<p>ID статьи</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "slides_count",
            "description": "<p>количество слайдов (1-10 для динамического)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "content_type",
            "description": "<p>Тип контента (1 - статья, 2 - раздел)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "period",
            "description": "<p>выборка периода (1 - день, 2 - неделя, 3 - месяц, 4 - неограничено, 5 - свой вариант выборки)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "publish",
            "description": "<p>период публикации (1 - день, 2 - неделя, 3 - месяц, 4 - выбор дат)</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": false,
            "field": "publish_start",
            "description": "<p>Начало публикации</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": false,
            "field": "publish_end",
            "description": "<p>Конец публикации</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Modules/v2/SliderController.php",
    "groupTitle": "Module_slider__v2_",
    "name": "PostApiModulesV2SliderValidate"
  },
  {
    "type": "GET",
    "url": "/api/object_relations/get_card",
    "title": "Получение конкретной карточки",
    "group": "Object_Relations",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID карточки</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsRelationsController.php",
    "groupTitle": "Object_Relations",
    "name": "GetApiObject_relationsGet_card"
  },
  {
    "type": "GET",
    "url": "/api/object_relations/list",
    "title": "Получение списка готовых карточек",
    "group": "Object_Relations",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsRelationsController.php",
    "groupTitle": "Object_Relations",
    "name": "GetApiObject_relationsList"
  },
  {
    "type": "POST",
    "url": "/api/object_relations/connect",
    "title": "Создание связи",
    "group": "Object_Relations",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "from_id",
            "description": "<p>связь от карточки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "to_id",
            "description": "<p>связь до карточки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "relation",
            "description": "<p>тип связи с карточками (0-родитель, 1-ребенок, 2-брат/сестра, 3-муж/жена)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsRelationsController.php",
    "groupTitle": "Object_Relations",
    "name": "PostApiObject_relationsConnect"
  },
  {
    "type": "POST",
    "url": "/api/object_relations/disconnect",
    "title": "Удаление связи",
    "group": "Object_Relations",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "fromId",
            "description": "<p>связь от карточки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "toId",
            "description": "<p>связь до карточки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "relation",
            "description": "<p>тип связи с карточками (0-родитель, 1-ребенок, 2-брат/сестра, 3-муж/жена)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsRelationsController.php",
    "groupTitle": "Object_Relations",
    "name": "PostApiObject_relationsDisconnect"
  },
  {
    "type": "GET",
    "url": "/api/objects",
    "title": "Список карточек",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjects"
  },
  {
    "type": "GET",
    "url": "/api/objects/catalog",
    "title": "Каталог карточек",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort",
            "description": "<p>поле для сортировки (name, views)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "catalog_id",
            "description": "<p>ID каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "order",
            "description": "<p>порядок сортировки (asc, desc)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsCatalog"
  },
  {
    "type": "GET",
    "url": "/api/objects/catalogs",
    "title": "Список каталогов",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsCatalogs"
  },
  {
    "type": "GET",
    "url": "/api/objects/data",
    "title": "Получение списка готовых карточек",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>Номер страницы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsData"
  },
  {
    "type": "GET",
    "url": "/api/objects/filter",
    "title": "Данные для фильтра",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "catalog_id",
            "description": "<p>ID для каталога</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsFilter"
  },
  {
    "type": "GET",
    "url": "/api/objects/form/{CATALOG_ID}",
    "title": "Редактирование карточки",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "CATALOG_ID",
            "description": "<p>ID каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID карточки (не обязательно)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsFormCatalog_id"
  },
  {
    "type": "GET",
    "url": "/api/objects/get_data",
    "title": "Получение карточки для статей и тд",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID карточки из листинга</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsGet_data"
  },
  {
    "type": "GET",
    "url": "/api/objects/list",
    "title": "Список карточек для статьи",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsList"
  },
  {
    "type": "GET",
    "url": "/api/objects/related/{ID}",
    "title": "Похожие товары",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID карточки товара</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "v",
            "description": "<p>Версия (v1, v2)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsRelatedId"
  },
  {
    "type": "GET",
    "url": "/api/objects/search_card",
    "title": "Поиск карточки по имени",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Строка для поиска</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID карточки</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsSearch_card"
  },
  {
    "type": "GET",
    "url": "/api/objects/show_data",
    "title": "Получение конкретной карточки",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID карточки из листинга</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "GetApiObjectsShow_data"
  },
  {
    "type": "POST",
    "url": "/api/objects/cards",
    "title": "Вывод списка карточек",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsCards"
  },
  {
    "type": "POST",
    "url": "/api/objects/catalogs/delete",
    "title": "Удаление каталога с карточками",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>ID каталога</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsCatalogsDelete"
  },
  {
    "type": "POST",
    "url": "/api/objects/catalogs/{slug}-{id}",
    "title": "Каталог с карточками",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsCatalogsSlugId"
  },
  {
    "type": "POST",
    "url": "/api/objects/copy_card",
    "title": "Копирование карточки",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "card_id",
            "description": "<p>ID карточки</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsCopy_card"
  },
  {
    "type": "POST",
    "url": "/api/objects/create_catalog",
    "title": "Создание нового каталога",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "catalog_name",
            "description": "<p>Название каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "alias",
            "description": "<p>Слаг для урла</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>Описание</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_title",
            "description": "<p>SEO название</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_description",
            "description": "<p>SEO описание</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_keywords",
            "description": "<p>SEO ключевые слова</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_h1",
            "description": "<p>H1 для каталога</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsCreate_catalog"
  },
  {
    "type": "POST",
    "url": "/api/objects/delete/{ID}",
    "title": "Удаление карточки",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID созданной карточки</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsDeleteId"
  },
  {
    "type": "POST",
    "url": "/api/objects/save_form/{ID}",
    "title": "Сохранение полей для карточки",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "field_group_id",
            "description": "<p>ID группы полей для карточки</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "data",
            "description": "<p>Массив значений и полей</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "data[hidden]",
            "description": "<p>скрыть карточку или нет (0 - нет, 1 - да)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_h1",
            "description": "<p>H1 SEO</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "category_id",
            "description": "<p>ID категорий</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_title",
            "description": "<p>H1 название</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_description",
            "description": "<p>H1 описание</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "alias",
            "description": "<p>Ссылка для карточки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_keywords",
            "description": "<p>Ссылка для товара</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsSave_formId"
  },
  {
    "type": "POST",
    "url": "/api/objects/search",
    "title": "Данные для фильтра",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "fields",
            "description": "<p>Фильтр для каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort",
            "description": "<p>Сортировка (views|name)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "catalog_id",
            "description": "<p>ID каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "category_id",
            "description": "<p>ID категорий</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "order",
            "description": "<p>Порядок сортировки (asc|desc)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsSearch"
  },
  {
    "type": "POST",
    "url": "/api/objects/search_inside",
    "title": "Данные для фильтра управления каталогом",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "fields",
            "description": "<p>Фильтр для управления каталогом</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sort",
            "description": "<p>Сортировка (views|name)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "order",
            "description": "<p>Порядок сортировки (asc|desc)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsSearch_inside"
  },
  {
    "type": "POST",
    "url": "/api/objects/update",
    "title": "Обновление полей для карточки",
    "group": "Objects",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "data",
            "description": "<p>Массив значений групп форм и полей</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "data[hidden]",
            "description": "<p>скрыть карточку или нет (0 - нет, 1 - да)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID карточки</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "category_id",
            "description": "<p>ID категорий</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_h1",
            "description": "<p>H1 SEO</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_title",
            "description": "<p>H1 название</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_description",
            "description": "<p>H1 описание</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_slug",
            "description": "<p>Ссылка для товара</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Catalog/ObjectsController.php",
    "groupTitle": "Objects",
    "name": "PostApiObjectsUpdate"
  },
  {
    "type": "GET",
    "url": "/api/pages/stroke/modules/form",
    "title": "Форма для модуля",
    "group": "Page_Modules",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "module_class",
            "description": "<p>класс модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "module_id",
            "description": "<p>ID модуля</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokeModulesController.php",
    "groupTitle": "Page_Modules",
    "name": "GetApiPagesStrokeModulesForm"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/blocks/create",
    "title": "Создание блока модуля",
    "group": "Page_Modules",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_stroke_id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "module_class",
            "description": "<p>класс модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "template_id",
            "description": "<p>данные для шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content_options",
            "description": "<p>настройки контента</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "create_module",
            "description": "<p>создание модуля сразу</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokeBlocksController.php",
    "groupTitle": "Page_Modules",
    "name": "PostApiPagesStrokeBlocksCreate"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/blocks/sort",
    "title": "Сортировка блоков",
    "group": "Page_Modules",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "blocks",
            "description": "<p>Массив блоков для сортировки ( blocks[N][id]=X, blocks[N][page_stroke_id]=Y, blocks[N][sort_order]=Z... )</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokeBlocksController.php",
    "groupTitle": "Page_Modules",
    "name": "PostApiPagesStrokeBlocksSort"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/blocks/update",
    "title": "Обновление блока модуля",
    "group": "Page_Modules",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_stroke_id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>блока модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "content_options",
            "description": "<p>настройки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "template_id",
            "description": "<p>шаблон</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokeBlocksController.php",
    "groupTitle": "Page_Modules",
    "name": "PostApiPagesStrokeBlocksUpdate"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/modules/create",
    "title": "Создание модуля",
    "group": "Page_Modules",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_stroke_id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "module_class",
            "description": "<p>класс модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "settings",
            "description": "<p>Настройки для модуля,</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "content_options",
            "description": "<p>Настройки контента</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokeModulesController.php",
    "groupTitle": "Page_Modules",
    "name": "PostApiPagesStrokeModulesCreate"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/modules/delete",
    "title": "Удаление модуля",
    "group": "Page_Modules",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_stroke_id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID модуля</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokeModulesController.php",
    "groupTitle": "Page_Modules",
    "name": "PostApiPagesStrokeModulesDelete"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/modules/sort",
    "title": "Сортировка модулей",
    "group": "Page_Modules",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_stroke_id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "modules",
            "description": "<p>[{&quot;id&quot;: &quot;n&quot;, &quot;sort_order&quot;: &quot;1-x&quot;}]</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokeModulesController.php",
    "groupTitle": "Page_Modules",
    "name": "PostApiPagesStrokeModulesSort"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/modules/update",
    "title": "Обновление модуля",
    "group": "Page_Modules",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_stroke_id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "module_class",
            "description": "<p>класс модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>ID Шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "settings",
            "description": "<p>Настройки для модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "content_options",
            "description": "<p>Настройки контента</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokeModulesController.php",
    "groupTitle": "Page_Modules",
    "name": "PostApiPagesStrokeModulesUpdate"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/modules/update_content_options",
    "title": "Обновление настроек модуля (без settings)",
    "group": "Page_Modules",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_stroke_id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "module_class",
            "description": "<p>класс модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID модуля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>ID Шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "content_options",
            "description": "<p>Настройки контента</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokeModulesController.php",
    "groupTitle": "Page_Modules",
    "name": "PostApiPagesStrokeModulesUpdate_content_options"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/active",
    "title": "Активность строки",
    "group": "Page_Strokes",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "is_active",
            "description": "<p>Флаг активности (0 - неактивная, 1 - активная)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokesController.php",
    "groupTitle": "Page_Strokes",
    "name": "PostApiPagesStrokeActive"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/create",
    "title": "Создание строки",
    "group": "Page_Strokes",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "is_active",
            "description": "<p>активная неактивная строка (0 - неактивная, 1 - активная. Не обязательно.)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "position",
            "description": "<p>позиция строки (1 - шапка, 2 - подвал, 3 - контент)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>Порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "content_options",
            "description": "<p>настройки внешнего вида</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>шаблон строки</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokesController.php",
    "groupTitle": "Page_Strokes",
    "name": "PostApiPagesStrokeCreate"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/delete",
    "title": "Удаление строки",
    "group": "Page_Strokes",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokesController.php",
    "groupTitle": "Page_Strokes",
    "name": "PostApiPagesStrokeDelete"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/sort",
    "title": "Сортировка строк",
    "group": "Page_Strokes",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "strokes",
            "description": "<p>Массив строк для сортировки (strokes[N][id]=X, strokes[N][position]=Y, strokes[N][sort_order]=Z...), позиция строки- position (&quot;1-header, 2-footer, 3-content&quot;)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokesController.php",
    "groupTitle": "Page_Strokes",
    "name": "PostApiPagesStrokeSort"
  },
  {
    "type": "POST",
    "url": "/api/pages/stroke/update",
    "title": "Обновление строки",
    "group": "Page_Strokes",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "is_active",
            "description": "<p>активная неактивная строка (0 - неактивная, 1 - активная. Не обязательно.)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "position",
            "description": "<p>позиция строки (1 - шапка, 2 - контент, 3 - подвал)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sort_order",
            "description": "<p>Порядок сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID строки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>шаблон строки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "content_options",
            "description": "<p>настройки внешнего вида</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PageStrokesController.php",
    "groupTitle": "Page_Strokes",
    "name": "PostApiPagesStrokeUpdate"
  },
  {
    "type": "GET",
    "url": "/api/pages",
    "title": "Список готовых страниц",
    "group": "Pages",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "GetApiPages"
  },
  {
    "type": "GET",
    "url": "/api/pages/form",
    "title": "форма страницы",
    "group": "Pages",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "GetApiPagesForm"
  },
  {
    "type": "GET",
    "url": "/api/pages/home",
    "title": "Главная страница",
    "group": "Pages",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "GetApiPagesHome"
  },
  {
    "type": "GET",
    "url": "/api/pages/settings",
    "title": "Настройки для страниц",
    "group": "Pages",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "GetApiPagesSettings"
  },
  {
    "type": "POST",
    "url": "/api/pages/active",
    "title": "Состояние активности страницы",
    "group": "Pages",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "is_active",
            "description": "<p>активная неактивная страница (0 - неактивная, 1 - активная)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>ID страницы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "PostApiPagesActive"
  },
  {
    "type": "POST",
    "url": "/api/pages/create",
    "title": "Создание страницы",
    "group": "Pages",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "is_active",
            "description": "<p>активная неактивная страница (0 - неактивная, 1 - активная. Не обязательно.)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "is_edit_mode",
            "description": "<p>состояние редактирования (0 - нет, 1 - да. Не обязательно.)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Имя страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "slug",
            "description": "<p>урл страницы (не обязательно)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_title",
            "description": "<p>название</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_description",
            "description": "<p>описание страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_keywords",
            "description": "<p>ключевые слова</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "PostApiPagesCreate"
  },
  {
    "type": "POST",
    "url": "/api/pages/delete",
    "title": "Удаление страницы",
    "group": "Pages",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>ID страницы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "PostApiPagesDelete"
  },
  {
    "type": "POST",
    "url": "/api/pages/edit_mode",
    "title": "Состояние редактирования страницы",
    "group": "Pages",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "is_edit_mode",
            "description": "<p>состояние редактирования (0 - нет, 1 - да. Не обязательно.)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>ID страницы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "PostApiPagesEdit_mode"
  },
  {
    "type": "POST",
    "url": "/api/pages/{slug}-{id}.html",
    "title": "Просмотр страницы",
    "group": "Pages",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "PostApiPagesSlugIdHtml"
  },
  {
    "type": "POST",
    "url": "/api/pages/update",
    "title": "Обновление страницы",
    "group": "Pages",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Имя страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "is_active",
            "description": "<p>активная неактивная страница (0 - неактивная, 1 - активная. Не обязательно.)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "is_edit_mode",
            "description": "<p>состояние редактирования (0 - нет, 1 - да. Не обязательно.)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "is_home",
            "description": "<p>главная страница (0 - нет, 1 - да. Не обязательно.)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "slug",
            "description": "<p>урл страницы (не обязательно)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_title",
            "description": "<p>название</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_description",
            "description": "<p>описание страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_keywords",
            "description": "<p>ключевые слова</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "groupTitle": "Pages",
    "name": "PostApiPagesUpdate"
  },
  {
    "type": "GET",
    "url": "/api/profile/activity",
    "title": "Листинг активности пользователя",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "dates",
            "description": "<p>Массив из дат</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "limit",
            "description": "<p>Кол-во записей на страницу</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>Номер страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sortby_field",
            "description": "<p>Сортировка по полю</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sortby_order",
            "description": "<p>Направление сортировки (asc, desc)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "filter_countries",
            "description": "<p>Массив из стран (из обьекта country_options)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "filter_devices",
            "description": "<p>Массив из девайсов (из обьекта device_options)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "filter_browsers",
            "description": "<p>Массив из браузеров (из обьекта browser_options)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "filter_oc",
            "description": "<p>Массив из оп. систем (из обьекта oc_options)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "GetApiProfileActivity"
  },
  {
    "type": "GET",
    "url": "/api/profile/delete_account",
    "title": "Удаление аккаунта",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "GetApiProfileDelete_account"
  },
  {
    "type": "GET",
    "url": "/api/profile/fields",
    "title": "Поля для профиля",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "GetApiProfileFields"
  },
  {
    "type": "GET",
    "url": "/api/profile/images",
    "title": "Картинки для слайдера в профайле",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "GetApiProfileImages"
  },
  {
    "type": "GET",
    "url": "/api/profile/info",
    "title": "Информация о пользователе",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "GetApiProfileInfo"
  },
  {
    "type": "GET",
    "url": "/api/profile/statuses",
    "title": "Список моих мыслей",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>номер страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "GetApiProfileStatuses"
  },
  {
    "type": "POST",
    "url": "/api/profile/change_email",
    "title": "Изменение email",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email_old",
            "description": "<p>старый email</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email_new",
            "description": "<p>last новый email</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileChange_email"
  },
  {
    "type": "POST",
    "url": "/api/profile/change_language",
    "title": "Изменение языка системы",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "language_id",
            "description": "<p>ID языка системы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileChange_language"
  },
  {
    "type": "POST",
    "url": "/api/profile/change_password",
    "title": "Изменение пароля",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password_old",
            "description": "<p>old password</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password_new",
            "description": "<p>last new password</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password_new_confirm",
            "description": "<p>new password confirm</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>код подтверждения</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileChange_password"
  },
  {
    "type": "POST",
    "url": "/api/profile/change_phone",
    "title": "Изменение номера телефона",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone_old",
            "description": "<p>старый телефон</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone_new",
            "description": "<p>last новый телефон</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileChange_phone"
  },
  {
    "type": "POST",
    "url": "/api/profile/delete_images",
    "title": "Удаление слайдов",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileDelete_images"
  },
  {
    "type": "POST",
    "url": "/api/profile/delete_multi_field/{id}",
    "title": "Delete multi field row",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>id of the field</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileDelete_multi_fieldId"
  },
  {
    "type": "POST",
    "url": "/api/profile/get_change_code",
    "title": "Получение кода",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code_type",
            "description": "<p>тип кода (1 - email, 2 - пароль, 3 - телефон)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileGet_change_code"
  },
  {
    "type": "POST",
    "url": "/api/profile/save",
    "title": "Сохранение профайла",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "first_name",
            "description": "<p>Имя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "last_name",
            "description": "<p>Фамилия</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "middle_name",
            "description": "<p>Отчество</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "birthday",
            "description": "<p>Дата рождения (format: yyyy-mm-dd hh:mm:ss)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "native_city_id",
            "description": "<p>ID города рождения</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "marital_status_id",
            "description": "<p>ID семейного положения</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone_work",
            "description": "<p>телефон рабочий</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone_home",
            "description": "<p>телефон домашний</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sex",
            "description": "<p>пол (0-male, 1-female)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "address",
            "description": "<p>адрес</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSave"
  },
  {
    "type": "POST",
    "url": "/api/profile/save_field",
    "title": "Сохранение поля",
    "group": "Profile",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSave_field"
  },
  {
    "type": "POST",
    "url": "/api/profile/save_fields",
    "title": "Сохранение абстрактных полей",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "field_group_id",
            "description": "<p>ID группы полей</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "fields[ALIAS]",
            "description": "<p>[visibility] fields[ALIAS][value] поля для профайла. Где ALIAS - имя поля, visibility(OPTIONAL) for fields[ALIAS][visibility]: 0 - видимо для всех, 1- только для меня</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSave_fields"
  },
  {
    "type": "POST",
    "url": "/api/profile/save_images",
    "title": "Сохранение картинок",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "images",
            "description": "<p>Массив картинок</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSave_images"
  },
  {
    "type": "POST",
    "url": "/api/profile/save_personal_names",
    "title": "Сохранение ФИО",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "first_name",
            "description": "<p>first name</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "last_name",
            "description": "<p>last name</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>user name</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSave_personal_names"
  },
  {
    "type": "POST",
    "url": "/api/profile/save_status",
    "title": "Сохранение статуса",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>status</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "user_status_emotion_id",
            "description": "<p>ID Эмоции</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSave_status"
  },
  {
    "type": "POST",
    "url": "/api/profile/search/article",
    "title": "Поиск по своим статьям",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Term of search</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>User token</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSearchArticle"
  },
  {
    "type": "POST",
    "url": "/api/profile/set_field_visibility",
    "title": "Сохранение видимости поля",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID поля</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "field_group_id",
            "description": "<p>ID группы полей</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "visibility",
            "description": "<p>Видимость: 0- видимо для всех, 1- только для меня</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSet_field_visibility"
  },
  {
    "type": "POST",
    "url": "/api/profile/set_group_visibility",
    "title": "Сохранение видимости группы полей",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "field_group_id",
            "description": "<p>ID of field group for fields</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "visibility",
            "description": "<p>Visibiity of form group for user may accept: 0- visible for all, 1- visible for me, 2- visible for nobody</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSet_group_visibility"
  },
  {
    "type": "POST",
    "url": "/api/profile/set_on_homepage",
    "title": "Размещение группы на главную",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "field_group_id",
            "description": "<p>ID группы полей</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "on_homepage",
            "description": "<p>Значения: 1 - на главную, 0 - нет</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileSet_on_homepage"
  },
  {
    "type": "POST",
    "url": "/api/profile/upload-avatar",
    "title": "Upload avatar",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "avatar",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UploaderController.php",
    "groupTitle": "Profile",
    "name": "PostApiProfileUploadAvatar"
  },
  {
    "type": "GET",
    "url": "/api/profile/my-articles",
    "title": "Список моих статей",
    "group": "Profile_articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileModules/ArticlesController.php",
    "groupTitle": "Profile_articles",
    "name": "GetApiProfileMyArticles"
  },
  {
    "type": "GET",
    "url": "/api/profile/my-articles/sort",
    "title": "Сортировка моих статей",
    "group": "Profile_articles",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "field",
            "description": "<p>сортировка по полю</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "order",
            "description": "<p>направление сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "limit",
            "description": "<p>ограничение</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "view",
            "description": "<p>Вид - список 0, сетка 1</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "page",
            "description": "<p>Номер страницы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ProfileModules/ArticlesController.php",
    "groupTitle": "Profile_articles",
    "name": "GetApiProfileMyArticlesSort"
  },
  {
    "type": "POST",
    "url": "/api/rating/article/{id}/set",
    "title": "Установка рейтинга для статьи",
    "group": "Rating",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ratingValue",
            "description": "<p>value for rating</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RatingController.php",
    "groupTitle": "Rating",
    "name": "PostApiRatingArticleIdSet"
  },
  {
    "type": "POST",
    "url": "/api/rating/article/{id}/unvote",
    "title": "Отмена голоса для статьи",
    "group": "Rating",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID статьи</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RatingController.php",
    "groupTitle": "Rating",
    "name": "PostApiRatingArticleIdUnvote"
  },
  {
    "type": "POST",
    "url": "/api/rating/comment/{id}/set",
    "title": "Установка рейтинга для коментария",
    "group": "Rating",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "ratingValue",
            "description": "<p>значение рейтинга</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RatingController.php",
    "groupTitle": "Rating",
    "name": "PostApiRatingCommentIdSet"
  },
  {
    "type": "POST",
    "url": "/api/rating/comment/{id}/unvote",
    "title": "Отмена голоса для комментария",
    "group": "Rating",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID статьи</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RatingController.php",
    "groupTitle": "Rating",
    "name": "PostApiRatingCommentIdUnvote"
  },
  {
    "type": "POST",
    "url": "/api/register",
    "title": "Регистрация",
    "group": "Registration",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "login",
            "description": "<p>Username(required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>User password (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password_confirmation",
            "description": "<p>Confirm password (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain",
            "description": "<p>Domain name (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<p>User phone (required if email is empty)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>User email (required if phone is empty)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>Sms-Code (required)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RegisterController.php",
    "groupTitle": "Registration",
    "name": "PostApiRegister"
  },
  {
    "type": "POST",
    "url": "/api/register/check-code",
    "title": "Проверка кода",
    "group": "Registration",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<p>User phone (required if email is empty)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>User email (required if phone is empty)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>Sms code (required)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RegisterController.php",
    "groupTitle": "Registration",
    "name": "PostApiRegisterCheckCode"
  },
  {
    "type": "POST",
    "url": "/api/register/check-email",
    "title": "Проверка E-mail",
    "group": "Registration",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>Email</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RegisterController.php",
    "groupTitle": "Registration",
    "name": "PostApiRegisterCheckEmail"
  },
  {
    "type": "POST",
    "url": "/api/register/check-login",
    "title": "Проверка логина",
    "group": "Registration",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "login",
            "description": "<p>Username</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RegisterController.php",
    "groupTitle": "Registration",
    "name": "PostApiRegisterCheckLogin"
  },
  {
    "type": "POST",
    "url": "/api/register/check-phone",
    "title": "Проверка телефона",
    "group": "Registration",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>Телефон</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RegisterController.php",
    "groupTitle": "Registration",
    "name": "PostApiRegisterCheckPhone"
  },
  {
    "type": "POST",
    "url": "/api/register/send-code",
    "title": "Отправка кода",
    "group": "Registration",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<p>User phone (required if email is empty)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>User email (required if phone is empty)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RegisterController.php",
    "groupTitle": "Registration",
    "name": "PostApiRegisterSendCode"
  },
  {
    "type": "POST",
    "url": "/api/register/v2",
    "title": "Регистрация: Версия 2",
    "group": "Registration",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<p>Номер телефона (required if email is empty)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>E-mail (required if phone is empty)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>Код подтверждения (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "personal_domain",
            "description": "<p>персональный домен для пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RegisterController.php",
    "groupTitle": "Registration",
    "name": "PostApiRegisterV2"
  },
  {
    "type": "POST",
    "url": "/api/robots/show",
    "title": "Вывод файла robots.txt",
    "group": "SEO_module",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RobotoEditor.php",
    "groupTitle": "SEO_module",
    "name": "PostApiRobotsShow"
  },
  {
    "type": "POST",
    "url": "/api/robots/update",
    "title": "Обновление файла robots.txt",
    "group": "SEO_module",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "data",
            "description": "<p>Контент файла robots.txt</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/RobotoEditor.php",
    "groupTitle": "SEO_module",
    "name": "PostApiRobotsUpdate"
  },
  {
    "type": "GET",
    "url": "/api/search/city",
    "title": "Поиск по городам",
    "group": "Search",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>строка для поиска</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SearchController.php",
    "groupTitle": "Search",
    "name": "GetApiSearchCity"
  },
  {
    "type": "GET",
    "url": "/api/search/country",
    "title": "Поиск по странам",
    "group": "Search",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>строка для поиска</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SearchController.php",
    "groupTitle": "Search",
    "name": "GetApiSearchCountry"
  },
  {
    "type": "GET",
    "url": "/api/section/{alias}-{id}",
    "title": "Просмотр раздела",
    "group": "Sections",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "GetApiSectionAliasId"
  },
  {
    "type": "GET",
    "url": "/api/sections",
    "title": "Список всех разделов",
    "group": "Sections",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "GetApiSections"
  },
  {
    "type": "GET",
    "url": "/api/sections/form",
    "title": "Опции формы для раздела",
    "group": "Sections",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>User token</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "section_id",
            "description": "<p>Section id to edit (optional)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "GetApiSectionsForm"
  },
  {
    "type": "GET",
    "url": "/api/sections/section",
    "title": "Выборка всех разделов и статей",
    "group": "Sections",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID раздела</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "GetApiSectionsSection"
  },
  {
    "type": "GET",
    "url": "/api/sections/site",
    "title": "Список разделов по сайту",
    "group": "Sections",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "site_id",
            "description": "<p>ID сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "GetApiSectionsSite"
  },
  {
    "type": "GET",
    "url": "/api/sections/slug",
    "title": "Генерация ссылки",
    "group": "Sections",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<ul> <li>символы для алиаса</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<ul> <li>Токен ключ пользователя</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "section_id",
            "description": "<ul> <li>ID раздела (необязательное поле)</li> </ul>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "GetApiSectionsSlug"
  },
  {
    "type": "GET",
    "url": "/api/sections/sort",
    "title": "Сортировка",
    "group": "Sections",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "section_id",
            "description": "<p>Id раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Поиск по разделам</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>Страница для пагинатора</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "field",
            "description": "<p>Поле для сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "order",
            "description": "<p>Сортировка по возрастанию, по убыванию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "view",
            "description": "<p>Вывод списком или сеткой (1 - сетка, 0 - список)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "GetApiSectionsSort"
  },
  {
    "type": "POST",
    "url": "/api/sections/create",
    "title": "Создание раздела",
    "group": "Sections",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>родитель раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": true,
            "field": "content",
            "description": "<p>Описание</p>"
          },
          {
            "group": "Parameter",
            "type": "Image",
            "optional": true,
            "field": "images",
            "description": "<p>картинки для раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "filter_articles",
            "description": "<p>выводить фильтр статей</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "filter_sections",
            "description": "<p>выводить фильтр разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_rating",
            "description": "<p>показывать рейтинг раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_article_author",
            "description": "<p>показывать автора статей</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "hide_section_tags",
            "description": "<p>скрывать теги раздела в списке разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_opened",
            "description": "<p>Оставлять раздел открытым (0 - нет, 1 - да)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_articles_sort",
            "description": "<p>сортировка статей по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_articles_sort_direction",
            "description": "<p>направление сортировки статей</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_articles_view",
            "description": "<p>вид статей по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "articles_limit",
            "description": "<p>лимит статей на страницу</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_sections_sort",
            "description": "<p>сортировка разделов по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_sections_sort_direction",
            "description": "<p>направление сортировки разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_sections_view",
            "description": "<p>вид разделов по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "sections_limit",
            "description": "<p>лимит разделов на страницу</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "is_secret",
            "description": "<p>скрыть раздел</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "tags",
            "description": "<p>метки через запятую</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "filter_settings",
            "description": "<p>фильтр для каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "sort_options",
            "description": "<p>сортировка для каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "object_id",
            "description": "<p>ID паттерна карточки</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "PostApiSectionsCreate"
  },
  {
    "type": "POST",
    "url": "/api/sections/delete",
    "title": "Удаление раздела",
    "group": "Sections",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID раздела для удаления</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "PostApiSectionsDelete"
  },
  {
    "type": "POST",
    "url": "/api/sections/mass_delete",
    "title": "массовое удаление разделов",
    "group": "Sections",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "ids",
            "description": "<p>массив ID разделов</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "PostApiSectionsMass_delete"
  },
  {
    "type": "POST",
    "url": "/api/sections/update",
    "title": "Обновление раздела",
    "group": "Sections",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID раздела для обновления</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>родитель раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "other_section_id",
            "description": "<p>ID раздела для другого ресурса</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": true,
            "field": "content",
            "description": "<p>Описание</p>"
          },
          {
            "group": "Parameter",
            "type": "Image",
            "optional": true,
            "field": "images",
            "description": "<p>картинки для раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "filter_articles",
            "description": "<p>выводить фильтр статей</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "filter_sections",
            "description": "<p>выводить фильтр разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_rating",
            "description": "<p>показывать рейтинг раздела</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_article_author",
            "description": "<p>показывать автора статей</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "hide_section_tags",
            "description": "<p>скрывать теги раздела в списке разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "show_opened",
            "description": "<p>Оставлять раздел открытым (0 - нет, 1 - да)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_articles_sort",
            "description": "<p>сортировка статей по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_articles_sort_direction",
            "description": "<p>направление сортировки статей</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_articles_view",
            "description": "<p>вид статей по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "articles_limit",
            "description": "<p>лимит статей на страницу</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_sections_sort",
            "description": "<p>сортировка разделов по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_sections_sort_direction",
            "description": "<p>направление сортировки разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "filter_sections_view",
            "description": "<p>вид разделов по умолчанию</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "sections_limit",
            "description": "<p>лимит разделов на страницу</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "is_secret",
            "description": "<p>скрыть раздел</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "tags",
            "description": "<p>метки через запятую</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "filter_settings",
            "description": "<p>фильтр для каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "sort_options",
            "description": "<p>сортировка для каталога</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "object_id",
            "description": "<p>ID каталога</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SectionsController.php",
    "groupTitle": "Sections",
    "name": "PostApiSectionsUpdate"
  },
  {
    "type": "GET",
    "url": "/api/sites/breadcrumbs/form",
    "title": "форма хлебных крошек",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesBreadcrumbsForm"
  },
  {
    "type": "GET",
    "url": "/api/sites/check",
    "title": "Проверка на доступ к сайту",
    "group": "Site",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesCheck"
  },
  {
    "type": "GET",
    "url": "/api/sites/contacts/form",
    "title": "Форма для контактов сайта и редактирование",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/ContactsApi.php",
    "groupTitle": "Site",
    "name": "GetApiSitesContactsForm"
  },
  {
    "type": "GET",
    "url": "/api/sites/edit",
    "title": "Форма для создания сайта",
    "group": "Site",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesEdit"
  },
  {
    "type": "GET",
    "url": "/api/sites/feedback_settings/form",
    "title": "Форма сервисов приема данных",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/FeedbackSettingsApi.php",
    "groupTitle": "Site",
    "name": "GetApiSitesFeedback_settingsForm"
  },
  {
    "type": "GET",
    "url": "/api/sites/form",
    "title": "Форма сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesForm"
  },
  {
    "type": "GET",
    "url": "/api/sites/home",
    "title": "Главная страница",
    "group": "Site",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesHome"
  },
  {
    "type": "GET",
    "url": "/api/sites/menu/form",
    "title": "Редактирование меню сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesMenuForm"
  },
  {
    "type": "GET",
    "url": "/api/sites/menu_options/form",
    "title": "Форма для опций меню сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/MenuOptionsApi.php",
    "groupTitle": "Site",
    "name": "GetApiSitesMenu_optionsForm"
  },
  {
    "type": "GET",
    "url": "/api/sites/options/form",
    "title": "Редактирование параметров сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesOptionsForm"
  },
  {
    "type": "GET",
    "url": "/api/sites/search",
    "title": "Поиск по имени",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Символы для поиска</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesSearch"
  },
  {
    "type": "GET",
    "url": "/api/sites/seo/form",
    "title": "Форма для SEO",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/SeoApi.php",
    "groupTitle": "Site",
    "name": "GetApiSitesSeoForm"
  },
  {
    "type": "GET",
    "url": "/api/sites/settings",
    "title": "Настройки для сайта",
    "group": "Site",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesSettings"
  },
  {
    "type": "GET",
    "url": "/api/sites/slug",
    "title": "Прасинг и вывод строки для полного имени домена",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>слово для домена</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesSlug"
  },
  {
    "type": "GET",
    "url": "/api/sites/theme",
    "title": "Получение темы для сайта",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "domain",
            "description": "<p>Домен</p>"
          }
        ]
      }
    },
    "group": "Site",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesTheme"
  },
  {
    "type": "GET",
    "url": "/api/sites/tree",
    "title": "Get Sites tree",
    "group": "Site",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesTree"
  },
  {
    "type": "GET",
    "url": "/api/sites/update",
    "title": "Update",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>Родитель сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": false,
            "field": "content",
            "description": "<p>Описание сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain_name",
            "description": "<p>Имя домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain_id",
            "description": "<p>Поддомен для имени домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "slogan",
            "description": "<p>Слоган</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "copyright",
            "description": "<p>Копирайты снизу</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": false,
            "field": "articles_description",
            "description": "<p>Описание для страницы статей</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>ID шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_scheme_id",
            "description": "<p>ID шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "Hex",
            "optional": false,
            "field": "default_color",
            "description": "<p>дефолтный цвет для разделов и пр.</p>"
          },
          {
            "group": "Parameter",
            "type": "Url",
            "optional": false,
            "field": "facebook_url",
            "description": "<p>Страничка на facebook</p>"
          },
          {
            "group": "Parameter",
            "type": "Url",
            "optional": false,
            "field": "vk_url",
            "description": "<p>Страничка Вконтакте</p>"
          },
          {
            "group": "Parameter",
            "type": "Url",
            "optional": false,
            "field": "ok_url",
            "description": "<p>Страничка Одноклассники.ру</p>"
          },
          {
            "group": "Parameter",
            "type": "Url",
            "optional": false,
            "field": "twitter_url",
            "description": "<p>Страничка в twitter</p>"
          },
          {
            "group": "Parameter",
            "type": "Url",
            "optional": false,
            "field": "instagram_url",
            "description": "<p>Страничка в Instagram</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "address",
            "description": "<p>Адрес</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "work_hours",
            "description": "<p>Время работы</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>Email для связи</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "filter_articles",
            "description": "<p>Выводить фильтр статей</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "filter_sections",
            "description": "<p>Выводить фильтр разделов</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "articles_limit",
            "description": "<p>Лимит статей на страницу</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sections_limit",
            "description": "<p>Лимит разделов на страницу</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "filter_articles_sort",
            "description": "<p>Сортировка статей по полю</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "filter_articles_sort_direction",
            "description": "<p>Сортировка статей по возрастанию или убыванию (asc|desc)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "filter_sections_sort",
            "description": "<p>Сортировка разделов по полю</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "filter_sections_sort_direction",
            "description": "<p>Сортировка разделов по возрастанию или убыванию (asc|desc)</p>"
          },
          {
            "group": "Parameter",
            "type": "Base64",
            "optional": false,
            "field": "logo",
            "description": "<p>Лого для сайта в формате base64</p>"
          },
          {
            "group": "Parameter",
            "type": "Base64",
            "optional": false,
            "field": "image",
            "description": "<p>Фоновая картинка в формате base64</p>"
          },
          {
            "group": "Parameter",
            "type": "Base64",
            "optional": false,
            "field": "favicon",
            "description": "<p>favicon base64</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesUpdate"
  },
  {
    "type": "GET",
    "url": "/api/sites/userbar_options/form",
    "title": "Форма для опций юзербара",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/UserbarOptionsApi.php",
    "groupTitle": "Site",
    "name": "GetApiSitesUserbar_optionsForm"
  },
  {
    "type": "GET",
    "url": "/api/sites/v2/form",
    "title": "Редактирование сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "GetApiSitesV2Form"
  },
  {
    "type": "GET",
    "url": "/api/sites/view/form",
    "title": "Форма внешнего вида",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/ViewApi.php",
    "groupTitle": "Site",
    "name": "GetApiSitesViewForm"
  },
  {
    "type": "POST",
    "url": "/api/sites/breadcrumbs/update",
    "title": "Обновление хлебных крошек",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "breadcrumbs",
            "description": "<p>Хлебные крошки (0 - нет, 1 - да)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "breadcrumbs_options",
            "description": "<p>Слоган</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "breadcrumbs_position",
            "description": "<p>позиция хлебных крошек (0 - слева, 1 - по центру, 2 - справа)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesBreadcrumbsUpdate"
  },
  {
    "type": "POST",
    "url": "/api/sites/change_domain",
    "title": "Изменение имени сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "new_domain_name",
            "description": "<p>Новое имя домена</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "domain_id",
            "description": "<p>ID родительского домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesChange_domain"
  },
  {
    "type": "POST",
    "url": "/api/sites/contacts/save",
    "title": "Сохранение формы контактов",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/ContactsApi.php",
    "groupTitle": "Site",
    "name": "PostApiSitesContactsSave"
  },
  {
    "type": "POST",
    "url": "/api/sites/create",
    "title": "Создание сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "domain_id",
            "description": "<p>ID поддомена для сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Имя поддомена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "custom_domain",
            "description": "<p>Домен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>ID шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "slogan",
            "description": "<p>Слоган для сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название сайта</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesCreate"
  },
  {
    "type": "POST",
    "url": "/api/sites/create_domain",
    "title": "Подключение домена",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Имя домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "reserved_domain",
            "description": "<p>Имя резервного домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesCreate_domain"
  },
  {
    "type": "POST",
    "url": "/api/sites/destroy",
    "title": "Удаление сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain",
            "description": "<p>имя домена</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesDestroy"
  },
  {
    "type": "POST",
    "url": "/api/sites/feedback_settings/save",
    "title": "Сохранение сервисов приема данных",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>E-mail</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/FeedbackSettingsApi.php",
    "groupTitle": "Site",
    "name": "PostApiSitesFeedback_settingsSave"
  },
  {
    "type": "POST",
    "url": "/api/sites/filter_domains",
    "title": "Фильтр доменов по языку и тематике",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "language",
            "description": "<p>(1,2,3....) Название языка</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain_thematic_id",
            "description": "<p>ID тематики доменов</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "slug",
            "description": "<p>имя домена ([slug].domain.com)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesFilter_domains"
  },
  {
    "type": "POST",
    "url": "/api/sites/menu_options/save",
    "title": "Сохранение параметров меню сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "menu_options",
            "description": "<p>Опции меню</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/MenuOptionsApi.php",
    "groupTitle": "Site",
    "name": "PostApiSitesMenu_optionsSave"
  },
  {
    "type": "POST",
    "url": "/api/sites/options/save",
    "title": "Сохранение параметров сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "show_article_rating",
            "description": "<p>Показывать рейтинг статьи (0|1)</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "show_section_rating",
            "description": "<p>Показывать рейтинг раздела (0|1)</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "hide_article_author_inside",
            "description": "<p>Скрывать автора в статье (0|1)</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "show_article_author",
            "description": "<p>Показывать автора статьи в списке статей (0|1)</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "hide_section_tags",
            "description": "<p>не показывать теги в разделе (0|1)</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "breadcrumbs",
            "description": "<p>вывод хлебных крошек (0 - нет, 1 - да)</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "breadcrumbs_position",
            "description": "<p>позиция хлебных крошек (0 - слева, 1 - по центру, 2 - справа)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesOptionsSave"
  },
  {
    "type": "POST",
    "url": "/api/sites/search_domain",
    "title": "Поиск проверка доменного имени",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Условие поиска по доменам (test.example.com)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesSearch_domain"
  },
  {
    "type": "POST",
    "url": "/api/sites/seo/save",
    "title": "Сохранение формы SEO",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>название сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "yandex_code",
            "description": "<p>ТОЛЬКО хеш-код яндекса</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "google_code",
            "description": "<p>ТОЛЬКО хеш-код Google</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "yandex_verification",
            "description": "<p>ТОЛЬКО хеш-код Яндекс верификации сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "google_verification",
            "description": "<p>ТОЛЬКО хеш-код Google верификации сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "robots_data",
            "description": "<p>контент файла robots.txt</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_title",
            "description": "<p>Мета название</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "seo_description",
            "description": "<p>Мета описание</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/SeoApi.php",
    "groupTitle": "Site",
    "name": "PostApiSitesSeoSave"
  },
  {
    "type": "POST",
    "url": "/api/sites/update_domain",
    "title": "Обновление домена",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Имя домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "domain_thematic_id",
            "description": "<p>ID тематики домена (необязательно)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent",
            "description": "<p>ID родительского домена</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID подключаемого домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "old_name",
            "description": "<p>Старое имя домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "custom_domain",
            "description": "<p>пользовательское имя домена</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesUpdate_domain"
  },
  {
    "type": "POST",
    "url": "/api/sites/update_settings",
    "title": "Обновление настроек",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "slogan",
            "description": "<p>Слоган</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "interface_language",
            "description": "<p>Языка сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "captcha_hash",
            "description": "<p>Код авторизации для капч</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "feedback_recipients",
            "description": "<p>Получатели обратной связи (массив E-mail)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesUpdate_settings"
  },
  {
    "type": "POST",
    "url": "/api/sites/userbar_options/save",
    "title": "Сохранение параметров юзербара",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "userbar_options",
            "description": "<p>Опции меню</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/UserbarOptionsApi.php",
    "groupTitle": "Site",
    "name": "PostApiSitesUserbar_optionsSave"
  },
  {
    "type": "POST",
    "url": "/api/sites/v2/update",
    "title": "Сохранение сайта",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Название сайта</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "favicon",
            "description": "<p>Иконка</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "slogan",
            "description": "<p>Слоган</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>Аннотация</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesV2Update"
  },
  {
    "type": "POST",
    "url": "/api/sites/validate_domain",
    "title": "Валидация нового домена",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "domain",
            "description": "<p>Имя домена</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesValidate_domain"
  },
  {
    "type": "POST",
    "url": "/api/sites/validate_site",
    "title": "Валидация сайта как поддомена",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "parent_id",
            "description": "<p>ID родительского домена</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Только название поддомена</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SitesController.php",
    "groupTitle": "Site",
    "name": "PostApiSitesValidate_site"
  },
  {
    "type": "POST",
    "url": "/api/sites/view/save",
    "title": "Сохранение формы внешнего вида",
    "group": "Site",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Traits/Api/Sites/ViewApi.php",
    "groupTitle": "Site",
    "name": "PostApiSitesViewSave"
  },
  {
    "type": "GET",
    "url": "/api/storage/download/{id}",
    "title": "Скачать обьект",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageDownloadId"
  },
  {
    "type": "GET",
    "url": "/api/storage/favorite",
    "title": "Избранные Обьекты",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageFavorite"
  },
  {
    "type": "GET",
    "url": "/api/storage/files",
    "title": "список обьектов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageFiles"
  },
  {
    "type": "GET",
    "url": "/api/storage/images",
    "title": "список картинок",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "field",
            "description": "<p>Поле для сортировки (0 - title, 1 - created_at, 2 - size)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "order",
            "description": "<p>Порядок сортировки (0 - ASC, 1 - DESC)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Фильтр по имени</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageImages"
  },
  {
    "type": "GET",
    "url": "/api/storage/images/sort",
    "title": "Сортировка картинок",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "field",
            "description": "<p>Поле для сортировки (0 - title, 1 - created_at, 2 - size)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "order",
            "description": "<p>Порядок сортировки (0 - ASC, 1 - DESC)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Фильтр по имени или названию</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageImagesSort"
  },
  {
    "type": "GET",
    "url": "/api/storage/objects",
    "title": "Полный список обьектов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "field",
            "description": "<p>Поле для сортировки (0 - title, 1 - created_at, 2 - size, 3 - original_filename, 4 - favorite, 5 - id)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order",
            "description": "<p>Порядок сортировки (0 - DESC, 1 - ASC)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Фильтр по ключевому слову</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>Фильтр тегов (string, json, array)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "objectType",
            "description": "<p>Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "favorite",
            "description": "<p>Фильтр по избранным (1 - да, 0 - нет)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "without_tags",
            "description": "<p>Обьекты без тегов (1 - да)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>Номер страницы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageObjects"
  },
  {
    "type": "GET",
    "url": "/api/storage/recycle_bin",
    "title": "Список удаленных обьектов в корзине",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "field",
            "description": "<p>Поле для сортировки (0 - title, 1 - created_at, 2 - size, 3 - original_filename, 4 - favorite, 5 - id)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order",
            "description": "<p>Порядок сортировки (0 - DESC, 1 - ASC)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Фильтр по ключевому слову</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>Фильтр тегов (string, json, array)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "objectType",
            "description": "<p>Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "favorite",
            "description": "<p>Фильтр по избранным (1 - да, 0 - нет)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>Номер страницы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageRecycle_bin"
  },
  {
    "type": "GET",
    "url": "/api/storage/search",
    "title": "Поиск обьектов по тегам/именам",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>ключевое слово</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageSearch"
  },
  {
    "type": "GET",
    "url": "/api/storage/search_tag",
    "title": "Поиск по тегам",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "field",
            "description": "<p>Поле для сортировки (0 - title, 1 - created_at, 2 - size, 3 - original_filename, 4 - favorite, 5 - id)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order",
            "description": "<p>Порядок сортировки (0 - DESC, 1 - ASC)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Ключевое слово</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageSearch_tag"
  },
  {
    "type": "GET",
    "url": "/api/storage/tag_tree",
    "title": "Дерево тегов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "field",
            "description": "<p>Поле для сортировки (0 - title, 1 - created_at, 2 - size, 3 - original_filename, 4 - favorite, 5 - id)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order",
            "description": "<p>Порядок сортировки (0 - DESC, 1 - ASC)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Фильтр по ключевому слову</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>Фильтр тегов (string, json, array)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "objectType",
            "description": "<p>Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "favorite",
            "description": "<p>Фильтр по избранным (1 - да, 0 - нет)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "without_tags",
            "description": "<p>Обьекты без тегов (1 - да)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageTag_tree"
  },
  {
    "type": "GET",
    "url": "/api/storage/tags",
    "title": "Список тегов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "tags",
            "description": "<p>Фильтр тегов (string, json, array)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "recycled",
            "description": "<p>Удаленные файлы с тегами (1- с удаленными, без параметра- без удаленных файлов)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageTags"
  },
  {
    "type": "GET",
    "url": "/api/storage/totals",
    "title": "ИНформация о хранилище",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "recycled",
            "description": "<p>Удаленные файлы с тегами (1- с удаленными, без параметра- без удаленных файлов)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetApiStorageTotals"
  },
  {
    "type": "GET",
    "url": "/download_zip/{zipname}",
    "title": "Архивация обьекта",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "GetDownload_zipZipname"
  },
  {
    "type": "POST",
    "url": "/api/storage/add_base64_files",
    "title": "Добавление base64 обьектов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "files",
            "description": "<p>Массив обьектов в формате base64 или URL (files[url =&gt; ..., title =&gt; ..., description =&gt; ...,])</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageAdd_base64_files"
  },
  {
    "type": "POST",
    "url": "/api/storage/add_chunked_files",
    "title": "Добавление обьектов (Chunked)",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>Тип обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "fileName",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "totalSize",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "blob",
            "optional": false,
            "field": "data",
            "description": "<p>Данные для чанка</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "chunkPositionStart",
            "description": "<p>начало чанка</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "chunkPositionEnd",
            "description": "<p>Конец чанка</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "uploadId",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "objectType",
            "description": "<p>тип обьекта ('contact', 'link', 'event', 'file', 'image', 'audio', 'video', 'archive')</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "tags",
            "description": "<p>массив/строка тегов</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageAdd_chunked_files"
  },
  {
    "type": "POST",
    "url": "/api/storage/add_files",
    "title": "Добавление обьектов с тегами",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "files[]",
            "description": "<p>Массив обьектов</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags[]",
            "description": "<p>Теги для обьектов через запятую</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageAdd_files"
  },
  {
    "type": "POST",
    "url": "/api/storage/add_image",
    "title": "Добавление картинки в хранилище",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "file",
            "description": "<p>обьект</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content_type",
            "description": "<p>(article, section)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageAdd_image"
  },
  {
    "type": "POST",
    "url": "/api/storage/add_images",
    "title": "Добавление массива картинок в хранилище",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "files[]",
            "description": "<p>Массив обьектов</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content_type",
            "description": "<p>(article, section)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageAdd_images"
  },
  {
    "type": "POST",
    "url": "/api/storage/add_multi_tag",
    "title": "Добавление тегов через запятую",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>Имя тегов через запятую</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageAdd_multi_tag"
  },
  {
    "type": "POST",
    "url": "/api/storage/add_tag",
    "title": "Добавление тега",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Имя тега</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageAdd_tag"
  },
  {
    "type": "POST",
    "url": "/api/storage/add_tag_to_object",
    "title": "Добавление тега к обьекту",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Фильтр по ключевому слову</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>Фильтр по тегам через запятую</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "added_tags",
            "description": "<p>Новые теги</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "objectType",
            "description": "<p>Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "favorite",
            "description": "<p>Фильтр по избранным (1 - да, 0 - нет)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "add_to_all_objects",
            "description": "<p>Добавление тегов ко всем обьектам (true|false)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "object_ids",
            "description": "<p>Массив ids обьектов (необязательно)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageAdd_tag_to_object"
  },
  {
    "type": "POST",
    "url": "/api/storage/add_url",
    "title": "Добавление урла в хранилище",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "url",
            "description": "<p>URL</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "tags",
            "description": "<p>массив или строка тегов</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageAdd_url"
  },
  {
    "type": "POST",
    "url": "/api/storage/batch_delete_tags",
    "title": "Мультиудаление тегов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "ids",
            "description": "<p>Массив тегов</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageBatch_delete_tags"
  },
  {
    "type": "POST",
    "url": "/api/storage/combine_tags",
    "title": "склейка тегов для обьектов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>строка тегов через запятую или массив</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "new_tag_name",
            "description": "<p>новое имя для тегов</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageCombine_tags"
  },
  {
    "type": "POST",
    "url": "/api/storage/delete_tag",
    "title": "Удаление тега из обьекта",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID тега</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "object_id",
            "description": "<p>ID обьекта</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageDelete_tag"
  },
  {
    "type": "POST",
    "url": "/api/storage/favorite_file",
    "title": "Добавить обьект в избранное",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID обьекта</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageFavorite_file"
  },
  {
    "type": "POST",
    "url": "/api/storage/get_image_from_url",
    "title": "Добавление добавление картинки через URL",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "URL",
            "description": "<p>URL на картинку со стороннего ресурса</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageGet_image_from_url"
  },
  {
    "type": "POST",
    "url": "/api/storage/multi_download",
    "title": "Скачивание архива обьектов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Фильтр по ключевому слову</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>Фильтр по тегам через запятую</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "objectType",
            "description": "<p>Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "favorite",
            "description": "<p>Фильтр по избранным (1 - да, 0 - нет)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "ids",
            "description": "<p>Массив ids обьектов (не обязательно)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageMulti_download"
  },
  {
    "type": "POST",
    "url": "/api/storage/multi_recycle",
    "title": "Мультиудаление обьектов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Фильтр по ключевому слову</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>Фильтр по тегам через запятую</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "objectType",
            "description": "<p>Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "favorite",
            "description": "<p>Фильтр по избранным (1 - да, 0 - нет)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "delete_all",
            "description": "<p>Удаление всех обьектов</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "empty_trash",
            "description": "<p>Удаление всех обьектов из корзины</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "ids",
            "description": "<p>Массив ids обьектов (не обязательно)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageMulti_recycle"
  },
  {
    "type": "POST",
    "url": "/api/storage/restore",
    "title": "Восстановление обьекта/обьектов",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "restore_all_from_trash",
            "description": "<p>Восстановление корзины</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Фильтр по ключевому слову</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tags",
            "description": "<p>Фильтр по тегам через запятую</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "objectType",
            "description": "<p>Фильтр типу обьекта (contact, link, event, file, image, audio, video, archive)</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": false,
            "field": "favorite",
            "description": "<p>Фильтр по избранным (1 - да, 0 - нет)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "ids",
            "description": "<p>Массив ids обьектов (не обязательно)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageRestore"
  },
  {
    "type": "POST",
    "url": "/api/storage/unfavorite_file",
    "title": "Удалить обьект из избранного",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID обьекта</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageUnfavorite_file"
  },
  {
    "type": "POST",
    "url": "/api/storage/update_tag",
    "title": "Обновление имени тега",
    "group": "Storage",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>новое имя для тега</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID тега</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/StorageController.php",
    "groupTitle": "Storage",
    "name": "PostApiStorageUpdate_tag"
  },
  {
    "type": "POST",
    "url": "/api/subscribe/article",
    "title": "Подписка на статьи",
    "group": "Subscribe",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "article_id",
            "description": "<p>ID статьи</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SubscribeController.php",
    "groupTitle": "Subscribe",
    "name": "PostApiSubscribeArticle"
  },
  {
    "type": "POST",
    "url": "/api/subscribe/section",
    "title": "Подписка на разделы",
    "group": "Subscribe",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "section_id",
            "description": "<p>ID раздела</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SubscribeController.php",
    "groupTitle": "Subscribe",
    "name": "PostApiSubscribeSection"
  },
  {
    "type": "POST",
    "url": "/api/subscribe/user",
    "title": "Подписка на пользователя",
    "group": "Subscribe",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "on_user_id",
            "description": "<p>ID пользователя, на которого подписываются</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SubscribeController.php",
    "groupTitle": "Subscribe",
    "name": "PostApiSubscribeUser"
  },
  {
    "type": "POST",
    "url": "/api/subscriptions",
    "title": "Список подписок пользователя",
    "group": "Subscribe",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": false,
            "field": "field",
            "description": "<p>поле сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": false,
            "field": "order",
            "description": "<p>направление сортировки</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>номер страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "Text",
            "optional": false,
            "field": "term",
            "description": "<p>Условие поиска</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SubscribeController.php",
    "groupTitle": "Subscribe",
    "name": "PostApiSubscriptions"
  },
  {
    "type": "POST",
    "url": "/api/unsubscribe/article",
    "title": "Отписка от статей",
    "group": "Subscribe",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "article_id",
            "description": "<p>ID статьи</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SubscribeController.php",
    "groupTitle": "Subscribe",
    "name": "PostApiUnsubscribeArticle"
  },
  {
    "type": "POST",
    "url": "/api/unsubscribe/section",
    "title": "Отписка от разделов",
    "group": "Subscribe",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "section_id",
            "description": "<p>ID раздела</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SubscribeController.php",
    "groupTitle": "Subscribe",
    "name": "PostApiUnsubscribeSection"
  },
  {
    "type": "POST",
    "url": "/api/unsubscribe/user",
    "title": "Отписка от пользователя",
    "group": "Subscribe",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен ключ пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "on_user_id",
            "description": "<p>ID пользователя, на которого подписываются</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/SubscribeController.php",
    "groupTitle": "Subscribe",
    "name": "PostApiUnsubscribeUser"
  },
  {
    "type": "POST",
    "url": "/api/tags/search",
    "title": "Поиск по меткам",
    "group": "Tags",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>input name</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TagsController.php",
    "groupTitle": "Tags",
    "name": "PostApiTagsSearch"
  },
  {
    "type": "GET",
    "url": "/api/colors/edit",
    "title": "Форма цветовой схемы",
    "group": "Template_Colors",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_scheme_id",
            "description": "<p>ID цветовой схемы</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ColorsController.php",
    "groupTitle": "Template_Colors",
    "name": "GetApiColorsEdit"
  },
  {
    "type": "POST",
    "url": "/api/colors/create",
    "title": "Создание цветовой схемы",
    "group": "Template_Colors",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "colors",
            "description": "<p>Цвета</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Имя цветовой схемы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>ID шаблона</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ColorsController.php",
    "groupTitle": "Template_Colors",
    "name": "PostApiColorsCreate"
  },
  {
    "type": "POST",
    "url": "/api/colors/delete",
    "title": "Удаление цветовой схемы",
    "group": "Template_Colors",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>ID шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_scheme_id",
            "description": "<p>ID схемы шаблона</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ColorsController.php",
    "groupTitle": "Template_Colors",
    "name": "PostApiColorsDelete"
  },
  {
    "type": "POST",
    "url": "/api/colors/update",
    "title": "Обновление шаблонов",
    "group": "Template_Colors",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>имя цветовой схемы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>ID шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_scheme_id",
            "description": "<p>ID схемы шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "colors",
            "description": "<p>Цвета</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/ColorsController.php",
    "groupTitle": "Template_Colors",
    "name": "PostApiColorsUpdate"
  },
  {
    "type": "GET",
    "url": "/api/templates",
    "title": "Список шаблонов",
    "group": "Templates",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_type",
            "description": "<p>Фильтр по типу шаблона (0 - сохраненные, 1 - оплаченые, 2 - бесплатные)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TemplatesController.php",
    "groupTitle": "Templates",
    "name": "GetApiTemplates"
  },
  {
    "type": "GET",
    "url": "/api/templates/form",
    "title": "Форма для шаблонов",
    "group": "Templates",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TemplatesController.php",
    "groupTitle": "Templates",
    "name": "GetApiTemplatesForm"
  },
  {
    "type": "POST",
    "url": "/api/templates/update",
    "title": "Обновление шаблонов",
    "group": "Templates",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_id",
            "description": "<p>ID шаблона</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "template_scheme_id",
            "description": "<p>ID схемы шаблона</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TemplatesController.php",
    "groupTitle": "Templates",
    "name": "PostApiTemplatesUpdate"
  },
  {
    "type": "POST",
    "url": "/api/time/utc/{UTC_STRING}",
    "title": "Получение времени",
    "group": "Time",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "UTC_STRING",
            "description": "<p>временная зона (-+12)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TimeController.php",
    "groupTitle": "Time",
    "name": "PostApiTimeUtcUtc_string"
  },
  {
    "type": "GET",
    "url": "/api/time/utc/{UTC_STRING}",
    "title": "Получение времени",
    "group": "Time",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "UTC_STRING",
            "description": "<p>временная зона (-+12)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TimeController.php",
    "groupTitle": "Time",
    "name": "GetApiTimeUtcUtc_string"
  },
  {
    "type": "GET",
    "url": "/api/section/{title}-{id}/trash",
    "title": "Корзина для раздела",
    "group": "Trash_Bin",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TrashBinController.php",
    "groupTitle": "Trash_Bin",
    "name": "GetApiSectionTitleIdTrash"
  },
  {
    "type": "GET",
    "url": "/api/trash",
    "title": "Список удаленных обьектов",
    "group": "Trash_Bin",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TrashBinController.php",
    "groupTitle": "Trash_Bin",
    "name": "GetApiTrash"
  },
  {
    "type": "POST",
    "url": "/api/trash/articles/mass_delete",
    "title": "Массовое удаление статей",
    "group": "Trash_Bin",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "ids[]",
            "description": "<p>массив ID статей</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TrashBinController.php",
    "groupTitle": "Trash_Bin",
    "name": "PostApiTrashArticlesMass_delete"
  },
  {
    "type": "POST",
    "url": "/api/trash/delete_forever",
    "title": "Удаление обьекта навсегда",
    "group": "Trash_Bin",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>тип обьекта (берется из origin.type)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TrashBinController.php",
    "groupTitle": "Trash_Bin",
    "name": "PostApiTrashDelete_forever"
  },
  {
    "type": "POST",
    "url": "/api/trash/sections/mass_delete",
    "title": "Массовое удаление разделов",
    "group": "Trash_Bin",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "ids[]",
            "description": "<p>массив ID разделов</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TrashBinController.php",
    "groupTitle": "Trash_Bin",
    "name": "PostApiTrashSectionsMass_delete"
  },
  {
    "type": "POST",
    "url": "/api/trash/undelete",
    "title": "Восстановление обьекта",
    "group": "Trash_Bin",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Токен пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID обьекта</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<p>тип обьекта (берется из origin.type)</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/TrashBinController.php",
    "groupTitle": "Trash_Bin",
    "name": "PostApiTrashUndelete"
  },
  {
    "type": "GET",
    "url": "/api/users/search",
    "title": "Поиск по пользователю",
    "group": "Users",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>Хэш пользователя</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "term",
            "description": "<p>Ключевое слово</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/UsersController.php",
    "groupTitle": "Users",
    "name": "GetApiUsersSearch"
  },
  {
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID страницы</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page_stroke_id",
            "description": "<p>ID строки</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PagesController.php",
    "group": "_home_id_Projects_netgamer_app_netgamer_development_app_Http_Controllers_Api_PagesController_php",
    "groupTitle": "_home_id_Projects_netgamer_app_netgamer_development_app_Http_Controllers_Api_PagesController_php",
    "name": ""
  }
] });
