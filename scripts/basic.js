
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
})(jQuery);