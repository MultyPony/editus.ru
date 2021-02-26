  <!-- SCRIPTS -->
   <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="//editus-dev.herokuapp.com/new/js/jquery-1.8.3.min.js"><\/script>')</script>
    
    <script src="//editus-dev.herokuapp.com/new/js/detectmobilebrowser.js"></script>
    <script src="//editus-dev.herokuapp.com/new/js/modernizr.js"></script>
    <script src="//editus-dev.herokuapp.com/new/js/jquery.imagesloaded.min.js"></script>
    <script src="//editus-dev.herokuapp.com/new/js/jquery.fitvids.js"></script>
    <script src="//editus-dev.herokuapp.com/new/js/google-code-prettify/prettify.js"></script>
    <script src="//editus-dev.herokuapp.com/new/js/jquery.uniform.min.js"></script>
    
    <script src="//editus-dev.herokuapp.com/new/js/main.js"></script>
    
   <script>
		// When the user scrolls the page, execute myFunction 
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("navbar");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
		
		</script>