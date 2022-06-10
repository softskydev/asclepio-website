(function () {
  'use strict';

  // $(window).on('scroll', function () {

  //   // alert('ea');
  //   $(".modal-body .dropdown-menu.show").addClass('no-transform');


  // });

  function init() {
    // INLINE SVG
    jQuery('img.svg').each(function (i) {
      var $img = jQuery(this);
      var imgID = $img.attr('id');
      var imgClass = $img.attr('class');
      var imgURL = $img.attr('src');

      jQuery.get(imgURL, function (data) {
        var $svg = jQuery(data).find('svg');
        if (typeof imgID !== 'undefined') {
          $svg = $svg.attr('id', imgID);
        }
        if (typeof imgClass !== 'undefined') {
          $svg = $svg.attr('class', imgClass + ' replaced-svg');
        }
        $svg = $svg.removeAttr('xmlns:a');
        $img.replaceWith($svg);
      }, 'xml');
    }); // END OF INLINE SVG

    // mainLayout();
    runSlider();
    func();

  }
  init(); // END OF init()

  function mainLayout() {
    var $headerH = $('header').outerHeight(),
      $footerH = $('footer').height();
    $('main').css({
      'min-height': 'calc(100vh - ' + $footerH + 'px)',
      'padding-top': +$headerH + 'px'
    });
  }

  function runSlider() {
    $('.slider').each(function () {
      var $slider = $(this),
        $item = $slider.find('.slider__item'),
        $autoplay = ($slider.data('autoplay') == undefined) ? true : $slider.data('autoplay'),
        $margin = ($slider.data('margin') == undefined) ? 24 : $slider.data('margin');

      if ($item.length > 1) {
        $slider.owlCarousel({
          items: 1,
          loop: false,
          dots: true,
          nav: true,
          navText: ["<span><img src='../images/ic-chevron-left.svg'></span>", "<span><img src='../images/ic-chevron-right.svg'></span>"],
          autoplay: $autoplay,
          autoplayTimeout: 6000,
          autoplaySpeed: 800,
          margin: $margin,
        });
      } else {
        $slider.trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
        $slider.find('.owl-stage-outer').children().unwrap();
      }
    });

    $('.slider-nav').each(function () {
      var $slider = $(this),
        $item = $slider.find('.slider__item'),
        $margin = ($slider.data('margin') == undefined) ? 24 : $slider.data('margin');

      if ($item.length > 3) {
        $slider.owlCarousel({
          items: 1,
          loop: false,
          dots: false,
          nav: true,
          navText: ["<span><img src='../images/ic-chevron-left.svg'></span>", "<span><img src='../images/ic-chevron-right.svg'></span>"],
          autoplay: false,
          autoplayTimeout: 6000,
          autoplaySpeed: 800,
          autoWidth: true,
          margin: $margin,
        });
      } else {
        $slider.trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
        $slider.find('.owl-stage-outer').children().unwrap();
      }
    });

    $('.masthead--home').each(function () {
      var $t = $(this),
        $slider = $t.find('.slider'),
        $content = $t.find('.masthead__content');

      $slider.on('changed.owl.carousel', function (event) {
        $content.toggleClass('active')
      });
    });

    $('.block-journey').each(function () {
      var $t = $(this),
        $slider = $t.find('.slider'),
        $nav = $t.find('.block-journey__slider-nav'),
        $navItem = $nav.find('li');

      $navItem.each(function () {
        var $el = $(this),
          $data = $(this).data('item');
        $el.click(function () {
          if (!$(this).hasClass('active')) {
            $navItem.not(this).removeClass('active');
            $el.addClass('active');
            $slider.trigger('to.owl.carousel', [$data, 200]);
            $slider.find('.owl-item').addClass('transition');
            setTimeout(function () {
              $slider.find('.owl-item').removeClass('transition');
            }, 200);
          }
        });
      });

      $slider.on('changed.owl.carousel', function (e) {
        var $activeIndex = e.item.index;
        $navItem.removeClass('active');
        $navItem.eq($activeIndex).addClass('active');
        console.log($activeIndex);
      })
    });

    $('.block-accord').each(function () {
      var $t = $(this),
        $accordion = $t.find('.accordion'),
        $slider = $t.find('.slider');

      $accordion.each(function () {
        var $el = $(this),
          $card = $el.find('.card');

        $card.each(function () {
          var $data = $(this).data('item');
          $(this).click(function () {
            $slider.trigger('to.owl.carousel', [$data, 200]);
          });
        });
      });

      $slider.on('changed.owl.carousel', function (e) {
        var $activeIndex = e.item.index;
        $accordion.find('.card').removeClass('open');
        $accordion.find('.card').eq($activeIndex).addClass('open');
        $accordion.find('.card').eq($activeIndex).find('.collapse').collapse('toggle');
      });
    });
  } // end of runSlider()

  function func() {

    // STICKY HEADER
    if ($('.header').length > 0) {
      var header = $('.header'),
        pos = 10;
      $(window).on('scroll', function () {

        $(".select").selectpicker('destroy');
        var scroll = $(window).scrollTop();
        if (scroll >= pos) {
          header.addClass('sticky');
          $('body').addClass('header-stick');
          $(".select").selectpicker('destroy');
        } else {
          header.removeClass('sticky');
          $('body').removeClass('header-stick');
        }


      });
    }

    $('.icon-mobilemenu').each(function () {
      var t = $(this);
      t.click(function () {
        $('body').toggleClass('mobilemenu-show');
      })
    });

    $('.marquee').each(function () {
      var $t = $(this);
      $t.marquee({
        speed: 100,
        gap: 0,
        delayBeforeStart: 0,
        direction: 'left',
        startVisible: true,
        duplicated: true,
        pauseOnHover: true
      })
    });

    $('.accordion').each(function () {
      var $t = $(this),
        $card = $t.find('.card');

      $card.each(function () {
        var $el = $(this),
          $head = $el.find('.card-header'),
          $body = $el.find('.card-body');

        $head.click(function () {
          $card.not($el).removeClass('open');
          $el.toggleClass('open');
        });
      });
    });

    // Bootsrap Select
    $('.select').each(function () {
      $(this).selectpicker();
    });

    // $('.drop-box').each(function(){
    //   var t     = $(this),
    //       inputs = t.find('#photo'),
    //       preview = t.find('.image-preview'),
    //       del   = t.find('.del-btn');

    //   function readURL(input, prev) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();

    //         reader.onload = function (e) {
    //           preview.css('background-image', 'url(' + e.target.result + ')');
    //           preview.fadeIn();
    //           del.fadeIn();
    //         }

    //         reader.readAsDataURL(input.files[0]);
    //     }
    //   }

    //   $("#photo").change(function(){
    //     readURL(this);
    //     console.log('jalan')
    //   });

    //   del.click(function(){
    //     $(this).fadeOut();
    //     preview.fadeOut();
    //     preview.css('background-image', '');
    //     inputs.val('');
    //   })

    // });

    //Upload Photo
    $('.drop-box').each(function (e) {
      var t = $(this),
        input = t.find('.inputfile'),
        btn = t.find('.btn-upload'),
        del = t.find('.del-btn'),
        text = t.find('.filename'),
        prev = t.find('.image-preview');

      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            prev.css('background-image', 'url(' + e.target.result + ')');
          }
          reader.readAsDataURL(input.files[0]);
        }
      }

      input.change(function (e) {
        var fileName = '',
          val = $(this).val();

        if (this.files && this.files.length > 1) {
          fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
        } else if (e.target.value) {
          fileName = e.target.value.split('\\').pop();
        }

        // text.html(fileName);
        readURL(this);

        if ($(this).val() != '') {
          t.addClass('has-file');
        }

      });

      del.click(function () {
        if (prev.length != 0) {
          prev.css('background-image', '');
        }
        input.val('');
        t.removeClass('has-file');
      })

    });

  } // END of func()

})();


//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiIiwic291cmNlcyI6WyJtYWluLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiAoKSB7XHJcbiAgJ3VzZSBzdHJpY3QnO1xyXG5cclxuICBmdW5jdGlvbiBpbml0KCkge1xyXG4gICAgLy8gSU5MSU5FIFNWR1xyXG4gICAgalF1ZXJ5KCdpbWcuc3ZnJykuZWFjaChmdW5jdGlvbiAoaSkge1xyXG4gICAgICB2YXIgJGltZyA9IGpRdWVyeSh0aGlzKTtcclxuICAgICAgdmFyIGltZ0lEID0gJGltZy5hdHRyKCdpZCcpO1xyXG4gICAgICB2YXIgaW1nQ2xhc3MgPSAkaW1nLmF0dHIoJ2NsYXNzJyk7XHJcbiAgICAgIHZhciBpbWdVUkwgPSAkaW1nLmF0dHIoJ3NyYycpO1xyXG5cclxuICAgICAgalF1ZXJ5LmdldChpbWdVUkwsIGZ1bmN0aW9uIChkYXRhKSB7XHJcbiAgICAgICAgdmFyICRzdmcgPSBqUXVlcnkoZGF0YSkuZmluZCgnc3ZnJyk7XHJcbiAgICAgICAgaWYgKHR5cGVvZiBpbWdJRCAhPT0gJ3VuZGVmaW5lZCcpIHtcclxuICAgICAgICAgICRzdmcgPSAkc3ZnLmF0dHIoJ2lkJywgaW1nSUQpO1xyXG4gICAgICAgIH1cclxuICAgICAgICBpZiAodHlwZW9mIGltZ0NsYXNzICE9PSAndW5kZWZpbmVkJykge1xyXG4gICAgICAgICAgJHN2ZyA9ICRzdmcuYXR0cignY2xhc3MnLCBpbWdDbGFzcyArICcgcmVwbGFjZWQtc3ZnJyk7XHJcbiAgICAgICAgfVxyXG4gICAgICAgICRzdmcgPSAkc3ZnLnJlbW92ZUF0dHIoJ3htbG5zOmEnKTtcclxuICAgICAgICAkaW1nLnJlcGxhY2VXaXRoKCRzdmcpO1xyXG4gICAgICB9LCAneG1sJyk7XHJcbiAgICB9KTsvLyBFTkQgT0YgSU5MSU5FIFNWR1xyXG5cclxuICAgIC8vIG1haW5MYXlvdXQoKTtcclxuICAgIHJ1blNsaWRlcigpO1xyXG4gICAgZnVuYygpO1xyXG5cclxuICB9IGluaXQoKTsgLy8gRU5EIE9GIGluaXQoKVxyXG5cclxuICBmdW5jdGlvbiBtYWluTGF5b3V0KCkge1xyXG4gICAgdmFyICRoZWFkZXJIID0gJCgnaGVhZGVyJykub3V0ZXJIZWlnaHQoKSxcclxuICAgICAgJGZvb3RlckggPSAkKCdmb290ZXInKS5oZWlnaHQoKTtcclxuICAgICQoJ21haW4nKS5jc3MoeyAnbWluLWhlaWdodCc6ICdjYWxjKDEwMHZoIC0gJyArICRmb290ZXJIICsgJ3B4KScsICdwYWRkaW5nLXRvcCc6ICskaGVhZGVySCArICdweCcgfSk7XHJcbiAgfVxyXG5cclxuICBmdW5jdGlvbiBydW5TbGlkZXIoKSB7XHJcbiAgICAkKCcuc2xpZGVyJykuZWFjaChmdW5jdGlvbiAoKSB7XHJcbiAgICAgIHZhciAkc2xpZGVyID0gJCh0aGlzKSxcclxuICAgICAgICAkaXRlbSA9ICRzbGlkZXIuZmluZCgnLnNsaWRlcl9faXRlbScpLFxyXG4gICAgICAgICRhdXRvcGxheSA9ICgkc2xpZGVyLmRhdGEoJ2F1dG9wbGF5JykgPT0gdW5kZWZpbmVkKSA/IHRydWUgOiAkc2xpZGVyLmRhdGEoJ2F1dG9wbGF5JyksXHJcbiAgICAgICAgJG1hcmdpbiA9ICgkc2xpZGVyLmRhdGEoJ21hcmdpbicpID09IHVuZGVmaW5lZCkgPyAyNCA6ICRzbGlkZXIuZGF0YSgnbWFyZ2luJyk7XHJcblxyXG4gICAgICBpZiAoJGl0ZW0ubGVuZ3RoID4gMSkge1xyXG4gICAgICAgICRzbGlkZXIub3dsQ2Fyb3VzZWwoe1xyXG4gICAgICAgICAgaXRlbXM6IDEsXHJcbiAgICAgICAgICBsb29wOiBmYWxzZSxcclxuICAgICAgICAgIGRvdHM6IHRydWUsXHJcbiAgICAgICAgICBuYXY6IHRydWUsXHJcbiAgICAgICAgICBuYXZUZXh0OiBbXCI8c3Bhbj48aW1nIHNyYz0nLi4vaW1hZ2VzL2ljLWNoZXZyb24tbGVmdC5zdmcnPjwvc3Bhbj5cIiwgXCI8c3Bhbj48aW1nIHNyYz0nLi4vaW1hZ2VzL2ljLWNoZXZyb24tcmlnaHQuc3ZnJz48L3NwYW4+XCJdLFxyXG4gICAgICAgICAgYXV0b3BsYXk6ICRhdXRvcGxheSxcclxuICAgICAgICAgIGF1dG9wbGF5VGltZW91dDogNjAwMCxcclxuICAgICAgICAgIGF1dG9wbGF5U3BlZWQ6IDgwMCxcclxuICAgICAgICAgIG1hcmdpbjogJG1hcmdpbixcclxuICAgICAgICB9KTtcclxuICAgICAgfSBlbHNlIHtcclxuICAgICAgICAkc2xpZGVyLnRyaWdnZXIoJ2Rlc3Ryb3kub3dsLmNhcm91c2VsJykucmVtb3ZlQ2xhc3MoJ293bC1jYXJvdXNlbCBvd2wtbG9hZGVkJyk7XHJcbiAgICAgICAgJHNsaWRlci5maW5kKCcub3dsLXN0YWdlLW91dGVyJykuY2hpbGRyZW4oKS51bndyYXAoKTtcclxuICAgICAgfVxyXG4gICAgfSk7XHJcblxyXG4gICAgJCgnLnNsaWRlci1uYXYnKS5lYWNoKGZ1bmN0aW9uICgpIHtcclxuICAgICAgdmFyICRzbGlkZXIgPSAkKHRoaXMpLFxyXG4gICAgICAgICRpdGVtID0gJHNsaWRlci5maW5kKCcuc2xpZGVyX19pdGVtJyksXHJcbiAgICAgICAgJG1hcmdpbiA9ICgkc2xpZGVyLmRhdGEoJ21hcmdpbicpID09IHVuZGVmaW5lZCkgPyAyNCA6ICRzbGlkZXIuZGF0YSgnbWFyZ2luJyk7XHJcblxyXG4gICAgICBpZiAoJGl0ZW0ubGVuZ3RoID4gMykge1xyXG4gICAgICAgICRzbGlkZXIub3dsQ2Fyb3VzZWwoe1xyXG4gICAgICAgICAgaXRlbXM6IDEsXHJcbiAgICAgICAgICBsb29wOiBmYWxzZSxcclxuICAgICAgICAgIGRvdHM6IGZhbHNlLFxyXG4gICAgICAgICAgbmF2OiB0cnVlLFxyXG4gICAgICAgICAgbmF2VGV4dDogW1wiPHNwYW4+PGltZyBzcmM9Jy4uL2ltYWdlcy9pYy1jaGV2cm9uLWxlZnQuc3ZnJz48L3NwYW4+XCIsIFwiPHNwYW4+PGltZyBzcmM9Jy4uL2ltYWdlcy9pYy1jaGV2cm9uLXJpZ2h0LnN2Zyc+PC9zcGFuPlwiXSxcclxuICAgICAgICAgIGF1dG9wbGF5OiBmYWxzZSxcclxuICAgICAgICAgIGF1dG9wbGF5VGltZW91dDogNjAwMCxcclxuICAgICAgICAgIGF1dG9wbGF5U3BlZWQ6IDgwMCxcclxuICAgICAgICAgIGF1dG9XaWR0aDp0cnVlLFxyXG4gICAgICAgICAgbWFyZ2luOiAkbWFyZ2luLFxyXG4gICAgICAgIH0pO1xyXG4gICAgICB9IGVsc2Uge1xyXG4gICAgICAgICRzbGlkZXIudHJpZ2dlcignZGVzdHJveS5vd2wuY2Fyb3VzZWwnKS5yZW1vdmVDbGFzcygnb3dsLWNhcm91c2VsIG93bC1sb2FkZWQnKTtcclxuICAgICAgICAkc2xpZGVyLmZpbmQoJy5vd2wtc3RhZ2Utb3V0ZXInKS5jaGlsZHJlbigpLnVud3JhcCgpO1xyXG4gICAgICB9XHJcbiAgICB9KTtcclxuXHJcbiAgICAkKCcubWFzdGhlYWQtLWhvbWUnKS5lYWNoKGZ1bmN0aW9uICgpIHtcclxuICAgICAgdmFyICR0ID0gJCh0aGlzKSxcclxuICAgICAgICAkc2xpZGVyID0gJHQuZmluZCgnLnNsaWRlcicpLFxyXG4gICAgICAgICRjb250ZW50ID0gJHQuZmluZCgnLm1hc3RoZWFkX19jb250ZW50Jyk7XHJcblxyXG4gICAgICAkc2xpZGVyLm9uKCdjaGFuZ2VkLm93bC5jYXJvdXNlbCcsIGZ1bmN0aW9uIChldmVudCkge1xyXG4gICAgICAgICRjb250ZW50LnRvZ2dsZUNsYXNzKCdhY3RpdmUnKVxyXG4gICAgICB9KTtcclxuICAgIH0pO1xyXG5cclxuICAgICQoJy5ibG9jay1qb3VybmV5JykuZWFjaChmdW5jdGlvbiAoKSB7XHJcbiAgICAgIHZhciAkdCA9ICQodGhpcyksXHJcbiAgICAgICAgJHNsaWRlciA9ICR0LmZpbmQoJy5zbGlkZXInKSxcclxuICAgICAgICAkbmF2ID0gJHQuZmluZCgnLmJsb2NrLWpvdXJuZXlfX3NsaWRlci1uYXYnKSxcclxuICAgICAgICAkbmF2SXRlbSA9ICRuYXYuZmluZCgnbGknKTtcclxuXHJcbiAgICAgICRuYXZJdGVtLmVhY2goZnVuY3Rpb24gKCkge1xyXG4gICAgICAgIHZhciAkZWwgPSAkKHRoaXMpLFxyXG4gICAgICAgICAgJGRhdGEgPSAkKHRoaXMpLmRhdGEoJ2l0ZW0nKTtcclxuICAgICAgICAkZWwuY2xpY2soZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgaWYgKCEkKHRoaXMpLmhhc0NsYXNzKCdhY3RpdmUnKSkge1xyXG4gICAgICAgICAgICAkbmF2SXRlbS5ub3QodGhpcykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xyXG4gICAgICAgICAgICAkZWwuYWRkQ2xhc3MoJ2FjdGl2ZScpO1xyXG4gICAgICAgICAgICAkc2xpZGVyLnRyaWdnZXIoJ3RvLm93bC5jYXJvdXNlbCcsIFskZGF0YSwgMjAwXSk7XHJcbiAgICAgICAgICAgICRzbGlkZXIuZmluZCgnLm93bC1pdGVtJykuYWRkQ2xhc3MoJ3RyYW5zaXRpb24nKTtcclxuICAgICAgICAgICAgc2V0VGltZW91dChmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgICAgJHNsaWRlci5maW5kKCcub3dsLWl0ZW0nKS5yZW1vdmVDbGFzcygndHJhbnNpdGlvbicpO1xyXG4gICAgICAgICAgICB9LCAyMDApO1xyXG4gICAgICAgICAgfVxyXG4gICAgICAgIH0pO1xyXG4gICAgICB9KTtcclxuXHJcbiAgICAgICRzbGlkZXIub24oJ2NoYW5nZWQub3dsLmNhcm91c2VsJywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICB2YXIgJGFjdGl2ZUluZGV4ID0gZS5pdGVtLmluZGV4O1xyXG4gICAgICAgICRuYXZJdGVtLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcclxuICAgICAgICAkbmF2SXRlbS5lcSgkYWN0aXZlSW5kZXgpLmFkZENsYXNzKCdhY3RpdmUnKTtcclxuICAgICAgICBjb25zb2xlLmxvZygkYWN0aXZlSW5kZXgpO1xyXG4gICAgICB9KVxyXG4gICAgfSk7XHJcblxyXG4gICAgJCgnLmJsb2NrLWFjY29yZCcpLmVhY2goZnVuY3Rpb24gKCkge1xyXG4gICAgICB2YXIgJHQgPSAkKHRoaXMpLFxyXG4gICAgICAgICRhY2NvcmRpb24gPSAkdC5maW5kKCcuYWNjb3JkaW9uJyksXHJcbiAgICAgICAgJHNsaWRlciA9ICR0LmZpbmQoJy5zbGlkZXInKTtcclxuXHJcbiAgICAgICRhY2NvcmRpb24uZWFjaChmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyICRlbCA9ICQodGhpcyksXHJcbiAgICAgICAgICAkY2FyZCA9ICRlbC5maW5kKCcuY2FyZCcpO1xyXG5cclxuICAgICAgICAkY2FyZC5lYWNoKGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgIHZhciAkZGF0YSA9ICQodGhpcykuZGF0YSgnaXRlbScpO1xyXG4gICAgICAgICAgJCh0aGlzKS5jbGljayhmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgICRzbGlkZXIudHJpZ2dlcigndG8ub3dsLmNhcm91c2VsJywgWyRkYXRhLCAyMDBdKTtcclxuICAgICAgICAgIH0pO1xyXG4gICAgICAgIH0pO1xyXG4gICAgICB9KTtcclxuXHJcbiAgICAgICRzbGlkZXIub24oJ2NoYW5nZWQub3dsLmNhcm91c2VsJywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICB2YXIgJGFjdGl2ZUluZGV4ID0gZS5pdGVtLmluZGV4O1xyXG4gICAgICAgICRhY2NvcmRpb24uZmluZCgnLmNhcmQnKS5yZW1vdmVDbGFzcygnb3BlbicpO1xyXG4gICAgICAgICRhY2NvcmRpb24uZmluZCgnLmNhcmQnKS5lcSgkYWN0aXZlSW5kZXgpLmFkZENsYXNzKCdvcGVuJyk7XHJcbiAgICAgICAgJGFjY29yZGlvbi5maW5kKCcuY2FyZCcpLmVxKCRhY3RpdmVJbmRleCkuZmluZCgnLmNvbGxhcHNlJykuY29sbGFwc2UoJ3RvZ2dsZScpO1xyXG4gICAgICB9KTtcclxuICAgIH0pO1xyXG4gIH0vLyBlbmQgb2YgcnVuU2xpZGVyKClcclxuXHJcbiAgZnVuY3Rpb24gZnVuYygpIHtcclxuXHJcbiAgICAvLyBTVElDS1kgSEVBREVSXHJcbiAgICBpZiAoJCgnLmhlYWRlcicpLmxlbmd0aCA+IDApIHtcclxuICAgICAgdmFyIGhlYWRlciA9ICQoJy5oZWFkZXInKSxcclxuICAgICAgICBwb3MgPSAxMDtcclxuICAgICAgJCh3aW5kb3cpLm9uKCdzY3JvbGwnLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyIHNjcm9sbCA9ICQod2luZG93KS5zY3JvbGxUb3AoKTtcclxuICAgICAgICBpZiAoc2Nyb2xsID49IHBvcykge1xyXG4gICAgICAgICAgaGVhZGVyLmFkZENsYXNzKCdzdGlja3knKTtcclxuICAgICAgICAgICQoJ2JvZHknKS5hZGRDbGFzcygnaGVhZGVyLXN0aWNrJyk7XHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgIGhlYWRlci5yZW1vdmVDbGFzcygnc3RpY2t5Jyk7XHJcbiAgICAgICAgICAkKCdib2R5JykucmVtb3ZlQ2xhc3MoJ2hlYWRlci1zdGljaycpO1xyXG4gICAgICAgIH1cclxuICAgICAgfSk7XHJcbiAgICB9XHJcblxyXG4gICAgJCgnLmljb24tbW9iaWxlbWVudScpLmVhY2goZnVuY3Rpb24oKXtcclxuICAgICAgdmFyIHQgPSAkKHRoaXMpO1xyXG4gICAgICB0LmNsaWNrKGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgJCgnYm9keScpLnRvZ2dsZUNsYXNzKCdtb2JpbGVtZW51LXNob3cnKTtcclxuICAgICAgfSlcclxuICAgIH0pO1xyXG5cclxuICAgICQoJy5tYXJxdWVlJykuZWFjaChmdW5jdGlvbiAoKSB7XHJcbiAgICAgIHZhciAkdCA9ICQodGhpcyk7XHJcbiAgICAgICR0Lm1hcnF1ZWUoe1xyXG4gICAgICAgIHNwZWVkOiAxMDAsXHJcbiAgICAgICAgZ2FwOiAwLFxyXG4gICAgICAgIGRlbGF5QmVmb3JlU3RhcnQ6IDAsXHJcbiAgICAgICAgZGlyZWN0aW9uOiAnbGVmdCcsXHJcbiAgICAgICAgc3RhcnRWaXNpYmxlOiB0cnVlLFxyXG4gICAgICAgIGR1cGxpY2F0ZWQ6IHRydWUsXHJcbiAgICAgICAgcGF1c2VPbkhvdmVyOiB0cnVlXHJcbiAgICAgIH0pXHJcbiAgICB9KTtcclxuXHJcbiAgICAkKCcuYWNjb3JkaW9uJykuZWFjaChmdW5jdGlvbiAoKSB7XHJcbiAgICAgIHZhciAkdCA9ICQodGhpcyksXHJcbiAgICAgICAgJGNhcmQgPSAkdC5maW5kKCcuY2FyZCcpO1xyXG5cclxuICAgICAgJGNhcmQuZWFjaChmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgdmFyICRlbCA9ICQodGhpcyksXHJcbiAgICAgICAgICAkaGVhZCA9ICRlbC5maW5kKCcuY2FyZC1oZWFkZXInKSxcclxuICAgICAgICAgICRib2R5ID0gJGVsLmZpbmQoJy5jYXJkLWJvZHknKTtcclxuXHJcbiAgICAgICAgJGhlYWQuY2xpY2soZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgJGNhcmQubm90KCRlbCkucmVtb3ZlQ2xhc3MoJ29wZW4nKTtcclxuICAgICAgICAgICRlbC50b2dnbGVDbGFzcygnb3BlbicpO1xyXG4gICAgICAgIH0pO1xyXG4gICAgICB9KTtcclxuICAgIH0pO1xyXG5cclxuICAgIC8vIEJvb3RzcmFwIFNlbGVjdFxyXG4gICAgJCgnLnNlbGVjdCcpLmVhY2goZnVuY3Rpb24oKXtcclxuICAgICAgJCh0aGlzKS5zZWxlY3RwaWNrZXIoKTtcclxuICAgIH0pO1xyXG5cclxuICAgIC8vICQoJy5kcm9wLWJveCcpLmVhY2goZnVuY3Rpb24oKXtcclxuICAgIC8vICAgdmFyIHQgICAgID0gJCh0aGlzKSxcclxuICAgIC8vICAgICAgIGlucHV0cyA9IHQuZmluZCgnI3Bob3RvJyksXHJcbiAgICAvLyAgICAgICBwcmV2aWV3ID0gdC5maW5kKCcuaW1hZ2UtcHJldmlldycpLFxyXG4gICAgLy8gICAgICAgZGVsICAgPSB0LmZpbmQoJy5kZWwtYnRuJyk7XHJcblxyXG4gICAgLy8gICBmdW5jdGlvbiByZWFkVVJMKGlucHV0LCBwcmV2KSB7XHJcbiAgICAvLyAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XHJcbiAgICAvLyAgICAgICAgIHZhciByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xyXG5cclxuICAgIC8vICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uIChlKSB7XHJcbiAgICAvLyAgICAgICAgICAgcHJldmlldy5jc3MoJ2JhY2tncm91bmQtaW1hZ2UnLCAndXJsKCcgKyBlLnRhcmdldC5yZXN1bHQgKyAnKScpO1xyXG4gICAgLy8gICAgICAgICAgIHByZXZpZXcuZmFkZUluKCk7XHJcbiAgICAvLyAgICAgICAgICAgZGVsLmZhZGVJbigpO1xyXG4gICAgLy8gICAgICAgICB9XHJcblxyXG4gICAgLy8gICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChpbnB1dC5maWxlc1swXSk7XHJcbiAgICAvLyAgICAgfVxyXG4gICAgLy8gICB9XHJcblxyXG4gICAgLy8gICAkKFwiI3Bob3RvXCIpLmNoYW5nZShmdW5jdGlvbigpe1xyXG4gICAgLy8gICAgIHJlYWRVUkwodGhpcyk7XHJcbiAgICAvLyAgICAgY29uc29sZS5sb2coJ2phbGFuJylcclxuICAgIC8vICAgfSk7XHJcblxyXG4gICAgLy8gICBkZWwuY2xpY2soZnVuY3Rpb24oKXtcclxuICAgIC8vICAgICAkKHRoaXMpLmZhZGVPdXQoKTtcclxuICAgIC8vICAgICBwcmV2aWV3LmZhZGVPdXQoKTtcclxuICAgIC8vICAgICBwcmV2aWV3LmNzcygnYmFja2dyb3VuZC1pbWFnZScsICcnKTtcclxuICAgIC8vICAgICBpbnB1dHMudmFsKCcnKTtcclxuICAgIC8vICAgfSlcclxuXHJcbiAgICAvLyB9KTtcclxuXHJcbiAgICAvL1VwbG9hZCBQaG90b1xyXG4gICAgJCgnLmRyb3AtYm94JykuZWFjaChmdW5jdGlvbihlKXtcclxuICAgICAgdmFyIHQgICAgICAgICA9ICQodGhpcyksXHJcbiAgICAgICAgICBpbnB1dCAgICAgPSB0LmZpbmQoJy5pbnB1dGZpbGUnKSxcclxuICAgICAgICAgIGJ0biAgICAgICA9IHQuZmluZCgnLmJ0bi11cGxvYWQnKSxcclxuICAgICAgICAgIGRlbCAgICAgICA9IHQuZmluZCgnLmRlbC1idG4nKSxcclxuICAgICAgICAgIHRleHQgICAgICA9IHQuZmluZCgnLmZpbGVuYW1lJyksXHJcbiAgICAgICAgICBwcmV2ICAgICAgPSB0LmZpbmQoJy5pbWFnZS1wcmV2aWV3Jyk7XHJcblxyXG4gICAgICBmdW5jdGlvbiByZWFkVVJMKGlucHV0KSB7XHJcbiAgICAgICAgaWYgKGlucHV0LmZpbGVzICYmIGlucHV0LmZpbGVzWzBdKSB7XHJcbiAgICAgICAgICB2YXIgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcclxuICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgICAgICBwcmV2LmNzcygnYmFja2dyb3VuZC1pbWFnZScsICd1cmwoJysgZS50YXJnZXQucmVzdWx0ICsnKScpO1xyXG4gICAgICAgICAgfVxyXG4gICAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoaW5wdXQuZmlsZXNbMF0pO1xyXG4gICAgICAgIH1cclxuICAgICAgfVxyXG5cclxuICAgICAgaW5wdXQuY2hhbmdlKGZ1bmN0aW9uKGUpe1xyXG4gICAgICAgIHZhciBmaWxlTmFtZSA9ICcnLFxyXG4gICAgICAgICAgICB2YWwgPSAkKHRoaXMpLnZhbCgpO1xyXG5cclxuICAgICAgICBpZih0aGlzLmZpbGVzICYmIHRoaXMuZmlsZXMubGVuZ3RoID4gMSl7XHJcbiAgICAgICAgICBmaWxlTmFtZSA9ICh0aGlzLmdldEF0dHJpYnV0ZSggJ2RhdGEtbXVsdGlwbGUtY2FwdGlvbicgKSB8fCAnJykucmVwbGFjZSgne2NvdW50fScsIHRoaXMuZmlsZXMubGVuZ3RoKTtcclxuICAgICAgICB9IGVsc2UgaWYoZS50YXJnZXQudmFsdWUpIHtcclxuICAgICAgICAgIGZpbGVOYW1lID0gZS50YXJnZXQudmFsdWUuc3BsaXQoICdcXFxcJyApLnBvcCgpO1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgLy8gdGV4dC5odG1sKGZpbGVOYW1lKTtcclxuICAgICAgICByZWFkVVJMKHRoaXMpO1xyXG5cclxuICAgICAgICBpZigkKHRoaXMpLnZhbCgpICE9ICcnKXtcclxuICAgICAgICAgIHQuYWRkQ2xhc3MoJ2hhcy1maWxlJyk7XHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgfSk7XHJcblxyXG4gICAgICBkZWwuY2xpY2soZnVuY3Rpb24oKXtcclxuICAgICAgICBpZihwcmV2Lmxlbmd0aCAhPSAwKXtcclxuICAgICAgICAgIHByZXYuY3NzKCdiYWNrZ3JvdW5kLWltYWdlJywgJycpO1xyXG4gICAgICAgIH1cclxuICAgICAgICBpbnB1dC52YWwoJycpO1xyXG4gICAgICAgIHQucmVtb3ZlQ2xhc3MoJ2hhcy1maWxlJyk7XHJcbiAgICAgIH0pXHJcblxyXG4gICAgfSk7XHJcblxyXG4gIH0vLyBFTkQgb2YgZnVuYygpXHJcblxyXG59KSgpO1xyXG4iXSwiZmlsZSI6Im1haW4uanMifQ==

//# sourceMappingURL=main.js.map