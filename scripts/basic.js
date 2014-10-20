(function ($) {

  // Change title of opening hours toggle.
  $(document).ready(function($) {
    $('.opening-hours-toggle').each(function() {
      try {
        $(this).text($(this).next('.js-opening-hours-toggle-element')[0].getAttribute('data-title'));
      } catch (e) {
        // Ignore errors - probably there was no title.
      }
    });
  });

  Drupal.behaviors.fixGroupsOnFrontpage = {
    attach: function (context) {
      var wrapper = $('body.front .group-blocks--wrapper', context).get(0);
      $(wrapper).once('innerdivs', function() {
        $(['.group-blocks--first',
          '.group-blocks--second',
          '.group-blocks--third',
          '.group-blocks--fourth']).each(function(){
          var el = $('<div>', {'class' : 'inner-div'}).html($(this.toString()).html());
          $(this.toString()).html(el);
        });
      });
    }
  };

  Drupal.behaviors.fixCollapsibleOnTingObjects = {
    attach: function (context) {
      var wrappers = $('.page-ting-object .ting-object-inner-wrapper', context);

      wrappers.each(function(){
        if (!$('.field-group-format-toggler', this).get(0)) {
          $(this).addClass('content-box');
        }
      });
    }
  };

  Drupal.behaviors.frontpagePromotions = {
    attach: function (context) {
      var promotion = $('.promotion');
      $(promotion).once('innerdivs', function() {

        var background = promotion.attr('style');
        promotion.removeAttr('style');
        promotion.parents('.topbar').attr('style', background).addClass('has-promotion');
        //

        var items = $('.element-hidden .field-name-field-links > .field-items > .field-item', promotion);

        items.each(function () {
          var item = $('<li>');

          item.append($(this).find('.field-name-field-link a').html($('.field-name-field-image img', this)));
          $('ul', promotion).append(item);
        });
      });
    }
  };

})(jQuery);
