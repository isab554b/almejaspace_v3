 
 <?php
/**
 * The template for displaying blog
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


get_header();?>

 
 <section id="splash_section">
		 <h2 class="titel">BLOG</h2>
	</section>

     <template>
  			<article class="blog">
				<p class="dato"></p>
                <img class="billede" src="" alt="">
				<h4 class="overskrift"></h4>
        	</article>
    </template>

 <div id="primary" class="content-area">
		<section class="blogsection">
	<main id="main" class="site-main">

	
	<div class="tekst">
		<p>Velkommen til vores blog! Her deler vi nye gode idéer, farver, guides, tips og tricks 
		til inspiration til din næste farverige begivenhed eller stylingprojekt.</p>
	</div>

    <div class="dropdown-menu">

    <div class="dropdown">
  	<button class="dropbtn-kategori">Emne &#9660</button>
    <nav class="dropdown-content-first dropdown-content" id="kategori-filtrering"><div class="filter valgt" data-kat="alle">Alle</div></nav>
    </div>

	<div class="dropdown">
  	<button class="dropbtn-kategori2">Arkiv &#9660</button>
    <nav class="dropdown-content" id="kategori2-filtrering"><div class="filter valgt" data-kat2="alle">Alle</div></nav>
    </div>


    </div>

		
        <section class="blogcontainer">
        </section>
		
        </main>
		</section>


	<script>
	let blogs; 
	let kategorier;
    let kategorier2;

    const container = document.querySelector(".blogcontainer");
    const temp = document.querySelector("template");

	let filterEmne = "alle";
	let filterArkiv = "alle";
 
	document.addEventListener("DOMContentLoaded", start);

	function start() {
		getJson();
	}

	async function getJson() {
            //hent alle custom posts: blogs
            const url = "https://isahilarius.dk/kea/almejaspace_v3/wp-json/wp/v2/blog?per_page=100";
            //hent custom category: kategori
            const katUrl = "https://isahilarius.dk/kea/almejaspace_v3/wp-json/wp/v2/emne";
             //hent custom category: kategori2
            const kat2Url = "https://isahilarius.dk/kea/almejaspace_v3/wp-json/wp/v2/arkiv";
            
            let response = await fetch(url);
            let katResponse = await fetch(katUrl);
            let kat2Response = await fetch(kat2Url);
            blogs = await response.json();
            kategorier = await katResponse.json();
            kategorier2 = await kat2Response.json();
            

            visBlogs();
            opretKnapper();
        }

		function opretKnapper(){
                kategorier.forEach(kat=>{document.querySelector("#kategori-filtrering").innerHTML += `<div class="filter" data-kat="${kat.id}">${kat.name}</div>`
            })
                kategorier2.forEach(kat2=>{document.querySelector("#kategori2-filtrering").innerHTML += `<div class="filter" data-kat2="${kat2.id}">${kat2.name}</div>`
            })

            addEventListenersToButtons();
            }


        function visBlogs() {
        container.innerHTML = "";
        blogs.forEach(blog => {
    //tjek filterKategori og filterArkiv til filtrering
        if ((filterEmne == "alle" || blog.emne.includes(parseInt(filterEmne)))
        && (filterArkiv == "alle"  || blog.arkiv.includes(parseInt(filterArkiv)))) {
        let klon = temp.cloneNode(true).content;
 	    klon.querySelector(".billede").src = blog.billede.guid;
	    klon.querySelector(".dato").textContent = blog.dato;
	    klon.querySelector(".overskrift").textContent = blog.title.rendered;
        klon.querySelector("article").addEventListener("click", ()=> {location.href = blog.link;})
        container.appendChild(klon);
                } 
            })
        }

		function addEventListenersToButtons() {
			document.querySelectorAll("#kategori-filtrering div").forEach(elm => {
                elm.addEventListener("click", filtreringKategori);
            })

            document.querySelectorAll("#kategori2-filtrering div").forEach(elm => {
                elm.addEventListener("click", filtreringKategori2);
            })           
        }



        function filtreringKategori() {
            filterEmne = this.dataset.kat;
             //fjern .valgt fra alle
            document.querySelectorAll("#kategori-filtrering .filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
            //tilføj .valgt til den valgte
            this.classList.add("valgt");
            visBlogs();
        }

		function filtreringKategori2() {
            filterArkiv = this.dataset.kat2;
            //fjern .valgt fra alle
            document.querySelectorAll("#kategori2-filtrering .filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
            //tilføj .valgt til den valgte
            this.classList.add("valgt");
            visBlogs();
        }

        getJson();

             </script>

</div>


<?php
do_action( 'botiga_do_sidebar' );
get_footer();