$(document).ready(function(){
 $(".accordion div.prueba:visible").hide(); 
 
$('.accordion div > h3').click(function() {
   
var comprobar = $(this).next();
$('.accordion div h3').removeClass('active');
$(this).closest('div h3').addClass('active');
if((comprobar.is('div')) && (comprobar.is(':visible'))) {
$(this).closest('div h3').removeClass('active');
comprobar.slideUp('slow');
}
if((comprobar.is('div')) && (!comprobar.is(':visible'))) {
$('.accordion div > div:visible').slideUp('normal');
comprobar.slideDown('slow');
}
});
});

