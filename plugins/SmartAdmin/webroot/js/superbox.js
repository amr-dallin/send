! function(a) {
    a.fn.SuperBox = function(b) {
        var c = a('<div class="superbox-show"></div>'),
            d = a('<div class="row">' +
                      '<div class="col-sm-12 col-md-6">' +
                          '<img src="" class="superbox-current-img" />' +
                      '</div>' +
                      '<div class="col-sm-12 col-md-6 superbox-imageinfo inline-block" id="imgInfoBox">' +
                          '<span>' +
                              '<p>' +
                                  '<a href="javascript:void(0);" class="btn btn-default btn-sm">' +
                                      '<i class="fa fa-clipboard" data-clipboard-text=""></i>' +
                                  '</a>' + 
                                  ' <span class="delete-btn"></span>' +
                              '</p>' +
                          '</span>' +
                      '</div>' +
                  '</div>'),
            e = a('<div class="superbox-close txt-color-white"><i class="fa fa-times fa-lg"></i></div>');
        c.append(d).append(e);
        a(".superbox-imageinfo");
        return this.each(function() {
            a(".superbox-list").click(function() {
                $this = a(this);
                var b = $this.find(".superbox-img"),
                    e = b.data("img"),
                    m = b.data('delete-link');
                d.find('.superbox-current-img').attr("src", e), a(".superbox-list").removeClass("active"), $this.addClass("active"), d.find(".fa-clipboard").attr("data-clipboard-text", e), d.find(".delete-btn").html(m), 0 == a(".superbox-current-img").css("opacity") && a(".superbox-current-img").animate({"opacity": 1}),
                a(this).next().hasClass("superbox-show") ? (c.is(":visible") && a(".superbox-list").removeClass("active"), c.toggle()) : (c.insertAfter(this).css("display", "block"), $this.addClass("active")), a("html, body").animate({
                    "scrollTop": c.position().top - b.width()
                }, "medium")
            }), a(".superbox").on("click", ".superbox-close", function() {
                a(".superbox-list").removeClass("active"), a(".superbox-current-img").animate({
                    "opacity": 0
                }, 200, function() {
                    a(".superbox-show").slideUp()
                })
            })
        })
    }
}(jQuery);



