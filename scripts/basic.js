
(function ($) {

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

})(jQuery);