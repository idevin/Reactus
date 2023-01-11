$(function () {

    $('#side-menu').metisMenu();

});

var wysiwigOptions = {
    height: 200,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough']],
        ['other', ['table', 'hr', 'ul', 'link', 'picture']]
    ],
    lang: 'ru-RU',
    popover: {
        image: [['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
            ['float', ['floatLeft', 'floatRight', 'floatNone']],
            ['remove', ['removeMedia']]
        ]
    }
};

window.counter = 0;
window.fieldType = $('#fg_field_type');
window.setFieldCounter = function () {

    let rand = Math.floor((Math.random() * 1000000000) + 1);

    window.fieldType.after('<div class="form-group clearfix" data-id="' + rand + '"><br><label for="field_type" class="col-sm-2 control-label required">Значение  и №</label><div class="col-sm-5"><input name=values[' + rand + '][value] class="form-control form-control" type="text" data-id="' + rand + '"><input type="text" name="values[' + rand + '][sort_order]" value="0" class="form-control"  data-id=' + rand + '><input type="hidden" value="" name="values[' + rand + '][id]"></div><div class="col-sm-5" style="height:34px;padding-top: 9px;"><a href="javascript:void(0);" onclick="window.setFieldCounter();" class="add-property" data-id="' + rand + '"><span class="glyphicon glyphicon-plus"></span></a><a href="javascript:void(0);" class="remove-property" onclick="window.removeFieldCounter(' + rand + ', this);" data-id="' + rand + '"><span class="glyphicon glyphicon-trash"></span></a></div></div>');
    window.counter += 1;
};

window.removeFieldCounter = function (id, o) {
    if ($('.form-group[data-id]').length > 1) {
        $(o).parent().parent().remove();
    }
};

$(function () {

    $(window).bind("load resize", function () {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function () {
        return this.href == url;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }

    $(document).on('change', '#field_type', function () {

        if ($(this).val() == 4) {
            window.setFieldCounter();
        } else {
            $('.form-group[data-id]').remove();
        }

        return false;
    });

    $(document).on('change', '.sroles', function () {
        $('.srole').not(this).prop('checked', this.checked);
        return false;
    });

    $(document).on('change', '.sowns', function () {
        $('.sown').not(this).prop('checked', this.checked);
        return false;
    });

    $(document).on('change', '#domain_select', function () {
        var ids = [];

        $('.sown').each(function (i, value) {
            if ($(value).prop('checked') == true) {
                ids.push($(value).val());
            }
        });
        if (ids.length > 0) {
            window.location.href += '/mass_change/?ids=' + ids + '&domain=' + $(this).val();
        }
        return false;
    });

    $(document).on('change', '.sothers', function () {
        $('.sother').not(this).prop('checked', this.checked);
        return false;
    });

    $(document).on('click', '.site-tree-view', function () {
        $('.site-tree').show('fast');
        $('.site-list').hide('fast');
        return false;
    });

    $(document).on('click', '.site-list-view', function () {
        $('.site-tree').hide('fast');
        $('.site-list').show('fast');
        return false;
    });

    $(document).on('click', '.mass-delete', function () {
        var link = $(this).attr('href');
        var checkboxes = '';
        $('.sown').each(function (i, data) {
            if ($(data).prop('checked')) {
                checkboxes += $(data).val() + ',';
            }
        });
        checkboxes = checkboxes.substr(0, checkboxes.length - 1);

        if (checkboxes != '') {
            link = $(this).attr('href') + '&o=' + checkboxes
        }
        link = $(this).attr('href', link);
        // window.back = $(this).data('back');
        $.post(link.attr('href'), [], function () {
            location.reload();
        });

        return false;
    });

    $(document).on('click', '.siteId', function () {
        var page = getQueryVariable('site_id');
        var siteId = $('#site-select').val();

        if (page == null) {
            window.location.href = '/cms/menu/create?site_id=' + siteId;
            return true;
        } else {
            window.location.href = '/cms/menu/create?site_id=' + siteId;
        }
    });

    function parseQuery(queryString) {
        var query = {};
        var pairs = (queryString[0] === '?' ? queryString.substr(1) : queryString).split('&');
        for (var i = 0; i < pairs.length; i++) {
            var pair = pairs[i].split('=');
            query[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || '');
        }
        return query;
    }

    $(document).on('change', '.set-limit', function () {

        var oQuery = parseQuery(window.location.search);
        var query = '?';
        var limitQuery = getQueryVariable('limit');
        var limitExists = null;
        var limitValue = $(this).val();

        for (var item in oQuery) {

            if (item == 'limit' && limitQuery) {
                query += item + '=' + limitValue + '&';
                limitExists = true;
            } else {
                query += item + '=' + oQuery[item] + '&';
            }
        }

        if (!limitExists) {
            query += 'limit=' + limitValue + '&';
        }

        if (query.length > 1) {
            query = query.substr(0, query.length - 1);
        }

        var url = getLocation(window.location.href);
        var fullUrl = url.protocol + '//' + url.host + url.pathname + query;

        window.location.href = fullUrl;

        return false;
    });

    var getLocation = function (href) {
        var l = document.createElement("a");
        l.href = href;
        l.protocol; // => "http:"
        l.host;     // => "example.com:3000"
        l.hostname; // => "example.com"
        l.port;     // => "3000"
        l.pathname; // => "/pathname/"
        l.hash;     // => "#hash"
        l.search;   // => "?search=test"
        l.origin;   // => "http://example.com:3000"
        return l;
    };

    function getQueryVariable(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split('&');
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            if (decodeURIComponent(pair[0]) == variable) {
                return decodeURIComponent(pair[1]);
            }
        }
        return null;
    }

});