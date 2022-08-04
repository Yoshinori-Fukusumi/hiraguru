//JSファイル

'use strict';

$(function(){

//inview
$('.js-fadeUp, .js-slide').on('inview', function(){
  $(this).addClass('is-inview');
})


});
