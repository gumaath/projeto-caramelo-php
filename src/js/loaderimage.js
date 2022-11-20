    (function($) {
      $.fn.loadImage = function(src, cb, image) {
        var self = this,
          dataSrc = $(self).attr("data-src");

        image = image || new Image();
        cb = cb || function() {};

        if (typeof src === "undefined") {
          if (dataSrc.length) {
            src = dataSrc;
          } else {
            throw new Error("You must specify the data-src on the html element or pass an image src path to loadImage()");
          }
        }
        setTimeout(function() {
          if (image.src != src)
            image.src = src;
          if (!image.complete)
            return self.loadImage(src, cb, image);
          self.attr('src', src);
          cb.call(self);
        }, 50);
      };
    })(jQuery);