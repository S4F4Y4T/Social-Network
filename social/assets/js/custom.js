$(document).ready(function() {
  $(".show-in-modal").click(function(e){
    var img = $(this).attr("src");
    $("#modalShow .modal-body").html("<img src='"+img+"' class='img-responsive'>");
     $("#modalShow").modal("show");
     e.preventDefault()
  });

  $(".show-image").click(function(e){
    var img = $(this).closest(".item-img-wrap").find("img:first").attr("src");
    $("#modalShow .modal-body").html("<img src='"+img+"' class='img-responsive'>");
     $("#modalShow").modal("show");
     e.preventDefault()
  });

  //messages
  if ($('#ms-menu-trigger')[0]) {
    $('body').on('click', '#ms-menu-trigger', function() {
        $('.ms-menu').toggleClass('toggled'); 
    });
   }

   /*============ Chat sidebar ========*/
  $('.chat-sidebar, .nav-controller, .chat-sidebar a').on('click', function(event) {
      $('.chat-sidebar').toggleClass('focus');
  });

  $(".hide-chat").click(function(){
      $('.chat-sidebar').toggleClass('focus');
  });

   /*sidebar profile toggle*/
  $(".btn-toggle-menu").click(function() {
    $("#wrapper").toggleClass("toggled");
  });

  if(isNoIframeOrIframeInMyHost() == true) {
    $(".col-md-22").addClass('hidden');
  }
})

function isNoIframeOrIframeInMyHost() {
// Validation: it must be loaded as the top page, or if it is loaded in an iframe 
// then it must be embedded in my own domain.
// Info: IF top.location.href is not accessible THEN it is embedded in an iframe 
// and the domains are different.
var myresult = true;
try {
    var tophref = top.location.href;
    var tophostname = top.location.hostname.toString();
    var myhref = location.href;
    if (tophref === myhref) {
        myresult = true;
    } else if (tophostname !== "www.bootdey.com") {
        myresult = false;
    }
} catch (error) { 
  // error is a permission error that top.location.href is not accessible 
  // (which means parent domain <> iframe domain)!
    myresult = false;
}
return myresult;
}