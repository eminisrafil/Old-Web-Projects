(function($){  
  $(function(){
    $(document).foundationMediaQueryViewer();
    
    $(document).foundationAlerts();
    $(document).foundationAccordion();
    $(document).tooltips();
    $('input, textarea, fieldset').placeholder();
    
    
    
    $(document).foundationButtons();
    
    
    
    $(document).foundationNavigation();
    
    
    
    $(document).foundationCustomForms();

    
    
      console.log($(document).foundationCustomForms());
      console.log($(document).foundationButtons());
      
      $(document).foundationTabs({callback:$.foundation.customForms.appendCustomMarkup});
      
    
    
    
    $("#featured").orbit();

  });
  
})(jQuery);
