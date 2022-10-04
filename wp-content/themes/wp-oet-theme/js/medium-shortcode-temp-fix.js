jQuery(document).ready(function(){
  //convert h1 to h2 for accessibility compliance
  jQuery('.medium-wrapper h1').contents().unwrap().wrap('<h2/>');
});