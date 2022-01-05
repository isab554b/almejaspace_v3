<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Botiga
 */

get_header();
?>

	<div id="primary" class="content-area">
	<main id="main" class="single-site-main">
     <div class="goback_button">
		<button onclick="goBack()">Tilbage</button>
    </div>
		
		<article class="single_blog">
      <h2 class="titel_single"></h2>
			<p class="beskrivelse"></p>
      <div class="billede_container">
      <img class="billede_single" src="" alt="">
      </div>
    </article>

		</main>
 <script>
    let blog;
    const dbUrl = "https://isahilarius.dk/kea/almejaspace_v3/wp-json/wp/v2/blog/"+<?php echo get_the_ID() ?>;
     

    async function getJson() {
        const data = await fetch(dbUrl);
        blog = await data.json();
        visBlogs();
    }

    function visBlogs() {
	document.querySelector(".titel_single").textContent = blog.title.rendered;
 	document.querySelector(".billede_single").src = blog.billede.guid;
	document.querySelector(".beskrivelse").textContent = blog.beskrivelse;
	
} 

function goBack() {
  window.history.back();
}
    getJson();

</script>

</div>

<?php
do_action( 'botiga_do_sidebar' );
get_footer();
