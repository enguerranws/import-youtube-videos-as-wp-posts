jQuery(document).ready(function() {

    ajaxGetYoutube.init(ajaxGetYoutube.query);
    jQuery('#updateCatOnChange').on('change', function() {
        ajaxGetYoutube.updateCategories('#updateCatOnChange');
    });
});

var ajaxGetYoutube = {
    query: '',
    lastID: '',
    nbPage: 0,
    trans: {},
    queryFormChanged: false,
    init: function(tag) {
        ajaxGetYoutube.insertPost();
        ajaxGetYoutube.rejectPost();
        ajaxGetYoutube.getPostIdsAndRun('#results-' + ajaxGetYoutube.nbPage, tag);
        ajaxGetYoutube.loadMore();
        ajaxGetYoutube.updateCategories('#updateCatOnChange');
        ajaxGetYoutube.checkForChange();
    },
    checkForChange: function() {
        jQuery('#queryOptions').find('input, select').on('change', function() {
            ajaxGetYoutube.queryFormChanged = true;
            ajaxGetYoutube.showAlert('needUpdate');
        });
    },
    showAlert: function(message) {
        var msg;
        if (message === "needUpdate") {
            msg = ajaxGetYoutube.trans.needUpdate;
        }
        else if (message === "mediaAdded") {
            msg = ajaxGetYoutube.trans.mediaAdded;
        }
        else if (message === "mediaRejected") {
            msg = ajaxGetYoutube.trans.mediaRejected;
        }
        jQuery('.updated-custom p').html(msg).fadeIn(function() {
            jQuery('.updated-custom').fadeOut();   
        });

    },
    updateCategories: function(el) {
        var type = jQuery(el).val();
        var data = {
            'action': 'yt_to_posts_getPostTypeCats',
            'post_type': type
        };

        jQuery.post(ajaxurl, data, function(response) {

            if (response === "empty") {
                jQuery('#catsSelect').addClass('hidden');
            } else {
                jQuery('#catsSelect').removeClass('hidden');
                jQuery('#catsSelect select').html(function() {
                    var html = "";
                    response = JSON.parse(response);

                    for (var i = 0; i < response.length; i++) {
                        if (ajaxGetYoutube.currentCat === response[i].id) {
                            html += '<option selected value="' + response[i].id + '" >' + response[i].name + '</option>';
                        } else {
                            html += '<option value="' + response[i].id + '" >' + response[i].name + '</option>';
                        }



                    }
                    return html;
                });
            }




        });
    },
    getPostIdsAndRun: function(container, tag, lastID) {
        var data = {
            'action': 'yt_to_posts_getAllPostSlug'
        };
        var ids = '';
        jQuery.post(ajaxurl, data, function(response) {

            ids = response;

            ajaxGetYoutube.getTagFeed(container, tag, ids, ajaxGetYoutube.lastID);

        });
    },
    getTagFeed: function(container, tag, ids, lastID) {

        var lastContainer;

        var args = {
            action: 'yt_to_posts_api_call',
            query: tag,
            maxNb: ajaxGetYoutube.number

        };
        if (ajaxGetYoutube.queryType === 'playlist' && ajaxGetYoutube.nbPage === 0) {
            args.nextPageToken = ajaxGetYoutube.nextPageToken;
        }
        if (ajaxGetYoutube.nbPage === 0) {
            lastContainer = '#results-0';

        } else {
            lastContainer = '#results-' + (ajaxGetYoutube.nbPage - 1);
        }

        if (ajaxGetYoutube.lastID) {
            args.lastID = ajaxGetYoutube.lastID;

            var origDate = jQuery(lastContainer).find('ul > li:last-child.result .date').text();

            origDate = origDate.split('');
            if (origDate[18] === '0') {
                origDate[18] = 9;
            } else {
                origDate[18] = origDate[18] - 1;
            }

            args.lastIdDate = origDate.join('');

        }

        jQuery.ajax({
            type: "GET",
            dataType: "JSON",
            url: ajaxurl,
            data: args
        }).done(function(data) {

            var that = jQuery(lastContainer);
            var $this;


            if (data) {
                var html = '';
                ajaxGetYoutube.nextPageToken = data.nextPageToken;
                if (ajaxGetYoutube.nbPage > 0) {

                    that.after('<div class="results" id="results-' + ajaxGetYoutube.nbPage + '" />');
                    $this = jQuery('#results-' + ajaxGetYoutube.nbPage);

                } else {
                    $this = that;
                }

                $this.html('<ul></ul>');
                for (var i = 0; i < data.items.length; i++) {


                    if (ids.indexOf(data.items[i].id) === -1) {
                        
                        html += '<li class="result" data-id="' + data.items[i].id + '"><div class="thumb"><a href="' + data.items[i].id + '" target="_blank" ><img src="' + data.items[i].thumb_url + '" /></a></div><div>' + data.items[i].title + '</div><div class="content">' + data.items[i].description + '</div><div class="date">' + data.items[i].date + '</div><div class="buttons"><a data-id="' + data.items[i].id + '" data-src="' + data.items[i].media_url + '"  data-content="' + data.items[i].description + '" data-title= "' + data.items[i].title + '" class="btn-deny button button-secondary" href="#">' + ajaxGetYoutube.trans.deny + '</a><a data-title= "' + data.items[i].title + '" data-id="' + data.items[i].id + '" data-src="' + data.items[i].media_url + '" data-content="' + data.items[i].description + '" data-date="' + data.items[i].date + '" data-embed-url="' + data.items[i].embed_url + '" data-media-url="' + data.items[i].media_url + '" data-thumbnail-url="' + data.items[i].thumb_url + '" data-user="' + data.items[i].channel_title + '" class="btn-approve button button-primary" href="#">' + ajaxGetYoutube.trans.approve + '</a></div></li>';

                    }




                }
                $this.find('ul').append(html);
                jQuery('#loadMore').removeClass('hidden');
            } else {

                alert('No results found');
            }
            if (ajaxGetYoutube.nextPageToken === null) {
                jQuery('#loadMore').addClass('hidden');
            }

        }).error(function(err) {

            alert(ajaxGetYoutube.trans.apiWrong);
        });


    },
    insertPost: function() {
        jQuery(document).on('click', '.btn-approve', function(e) {
            e.preventDefault();
            var $that = jQuery(this);
            var id = $that.attr('data-id');
            var title = $that.attr('data-title');
            var content = $that.attr('data-content');
            var imgSrc = $that.attr('data-thumbnail-url');
            var embed = $that.attr('data-embed-url');
            var mediaUrl = $that.attr('data-media-url');
            var username = $that.attr('data-user');
            var date = $that.attr('data-date');
            var data = {
                'action': 'yt_to_posts_insertPost',
                'id': id,
                'title': title,
                'content': content,
                'embed': embed,
                'imgSrc': imgSrc,
                'mediaUrl': mediaUrl,
                'username': username,
                'postType': ajaxGetYoutube.post_type,
                'date': date,
                'query': ajaxGetYoutube.query,
                'queryType': ajaxGetYoutube.queryType
            };
            jQuery('.updated-custom p').html(ajaxGetYoutube.trans.loading).parent().fadeIn();
            jQuery.post(ajaxurl, data, function(response) {

                if (response === 'ok') {
                    $that.parents('.result').fadeOut();
                    ajaxGetYoutube.showAlert('mediaAdded');
                }
            });
        });
    },
    rejectPost: function() {
        jQuery(document).on('click', '.btn-deny', function(e) {
            e.preventDefault();
            var $that = jQuery(this);
            var id = $that.attr('data-id');
            var title = 'Twitter post ' + id;
            var content = $that.attr('data-content');
            var imgSrc = $that.attr('data-src');
            var author = $that.attr('data-author');

            var data = {
                'action': 'yt_to_posts_rejectPost',
                'id': id,
                'title': title,
                'content': content,
                'imgSrc': imgSrc
            };
            jQuery('.updated-custom p').html(ajaxGetYoutube.trans.loading).parent().fadeIn();
            jQuery.post(ajaxurl, data, function(response) {
                if (response === 'ok') {
                    $that.parents('.result').fadeOut();
                    ajaxGetYoutube.showAlert('mediaRejected');
                }
            }); // wp_insert_post();
        });
    },
    loadMore: function() {
        var loadButton = jQuery('#loadMore');
        var container = '#results-' + ajaxGetYoutube.nbPage;

        loadButton.on('click', function(e) {
            ajaxGetYoutube.lastID = jQuery(container).find('ul > li:last-child.result').attr('data-id');

            e.preventDefault();
            ajaxGetYoutube.nbPage++;
            //jQuery(container).after('<div class="results" id="results-'+ajaxGetYoutube.nbPage+'" />');
            container = '#results-' + ajaxGetYoutube.nbPage;
            ajaxGetYoutube.getPostIdsAndRun(container, ajaxGetYoutube.query, ajaxGetYoutube.lastID + 1);
        });
    }
};