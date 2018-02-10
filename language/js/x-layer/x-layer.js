$(function(){
  $("#click-items").on('click', function(){
    $('#items').show();
  });

  $(".x-close").on('click', function(){
    $('.x-shade').fadeOut("slow");
  });

  $('.x-open').on('click', function(){
    $('.x-shade').fadeIn("slow");
  });
});
