<?php
/*
Template Name: Customer Home Page


*/

get_header();
?>

<div class="banner d-block" style="height: 350px; background-image: url('https://images.pexels.com/photos/3225517/pexels-photo-3225517.jpeg'); background-size: cover; background-position: center;">
    <div class="container d-flex justify-content-center">
        <div class="mask d-flex flex-column justify-content-center text-center">
            <h4 class="text-center">In need of wood?<br>We have a solution!</h4>
        </div>
    </div>
</div>

<div class="vstack gap-3 col-md-8 mx-auto mt-5">
	<h5 class="text-center">List of Locations</h5>
  <div class="pb-1">
	<h6 class="text-center text-grey-border">Select your preferred location below to get started.</h6>
</div>	

	<?php
	$taxonomy     = 'product_cat';
	$orderby      = 'name';  
	$show_count   = 0;      // 1 for yes, 0 for no
	$pad_counts   = 0;
	$hierarchical = 1;
	$title        = '';  
	$empty        = 0;

	$args = array(
			'taxonomy'     => $taxonomy,
			'orderby'      => $orderby,
			'show_count'   => $show_count,
			'pad_counts'   => $pad_counts,
			'hierarchical' => $hierarchical,
			'title_li'     => $title,
			'hide_empty'   => $empty
	);
	$all_categories = get_categories( $args );
	foreach ($all_categories as $cat) {
		if($cat->category_parent == 0) {
			$category_id = $cat->term_id;       
			#echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';
			#We do not want to show the main categories here, commenting it out

			$args2 = array(
					'taxonomy'     => $taxonomy,
					'child_of'     => 0,
					'parent'       => $category_id,
					'orderby'      => $orderby,
					'show_count'   => $show_count,
					'pad_counts'   => $pad_counts,
					'hierarchical' => $hierarchical,
					'title_li'     => $title,
					'hide_empty'   => $empty
			);
			$sub_cats = get_categories( $args2 );
				if($sub_cats) {
					$val = 0;
					foreach($sub_cats as $sub_category) {
						if($val == 0) {
							echo  '<br/><a class="btn btn-primary btn-lg active px-2" role="button" aria-pressed="true" href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a>';
							$val = 1;
						}
						else
						{
							echo  '<br/><a class="btn btn-secondary btn-lg active px-2" role="button" aria-pressed="true" href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a>';
							$val = 0;
						}
						
					}
				}
		}       
	}

	
	?>

<div class="pb-1 pt-1">
	<h6 class="text-center text-grey-border">Site is currently in test mode. Devices are currently not in place and you will not receive your items. You have been warned.</h6>
</div>

<div class="pt-5 text-center">
  <i class="bi bi-info-circle text-grey-border"></i>
</div>

<div class="tabs-to-dropdown pt-1">
  <div class="nav-wrapper d-flex align-items-center justify-content-between">
    <ul class="nav nav-pills d-none d-md-flex" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="pills-en-tab" data-toggle="pill" href="#pills-en" role="tab" aria-controls="pills-en" aria-selected="true">English</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-no-tab" data-toggle="pill" href="#pills-no" role="tab" aria-controls="pills-no" aria-selected="false">Norsk</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="pills-fi-tab" data-toggle="pill" href="#pills-fi" role="tab" aria-controls="pills-fi" aria-selected="false">Suomi</a>
      </li>
  </div>
</div>

  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-en" role="tabpanel" aria-labelledby="pills-en-tab">
      <div class="container-fluid">
        <h1 class="mb-3 font-weight-bold">Vedogvarer - Buy firewood online, collect immediately.</h1>
        <h2 class="mb-2"><i class="bi bi-clock-history"></i> 24/7 Service</h2>
        <p>Vedogvarer offers high-quality Norwegian firewood and other camping supplies all around the clock. Buy online using Vipps or your credit card, then pick up from your selected device.</p>
        <h2 class="mb-2"><i class="bi bi-graph-up-arrow"></i> High Quality</h2>
        <p>Guaranteed high quality. Your order will be dry even during the harshest weather conditions.</p>
        <h2 class="mb-2"><i class="bi bi-tree"></i> Renewable Wood</h2>
        <p>We sell wood from renewable forests only. The firewood is often of mixed varieties. See product info for more information.</p>
        <h2 class="mb-2"><i class="bi bi-pin-map"></i> Multiple Diverse Locations</h2>
        <p>Select your pick-up location above. These locations currently include Tverrvik, Norway. More to come!</p>
        <h2 class="mb-2"><i class="bi bi-wallet2"></i> Safe to Use</h2>
        <p>All purchases are processed through WooCommerce and official providers. In case your purchase is unsuccessful, please contact us!</p>
        <h2 class="mb-2"><i class="bi bi-cash-coin"></i> Support charities and small, local organizations</h2>
        <p>Most purchases will also support a local organization and help them keep running. They might, for example, support a children's football team! This information will be listed on the store page.</p>
      </div>
    </div>
    <div class="tab-pane fade" id="pills-no" role="tabpanel" aria-labelledby="pills-no-tab">
      <div class="container-fluid">
        <h1 class="mb-3 font-weight-bold">Vedogvarer - Kjøp ved på nett, hent umiddelbart.</h1>
        <h2 class="mb-2"><i class="bi bi-clock-history"></i> 24/7 Service</h2>
        <p>Vedogvarer tilbyr norsk ved og annet campingutstyr av høy kvalitet hele døgnet. Kjøp på nett med Vipps eller kredittkort, og hent på valgt enhet.</p>
        <h2 class="mb-2"><i class="bi bi-graph-up-arrow"></i> Høy kvalitet</h2>
        <p>Garantert høy kvalitet. Bestillingen din vil være tørr selv under de tøffeste værforhold.</p>
        <h2 class="mb-2"><i class="bi bi-tree"></i> Fornybart trevirke</h2>
        <p>Vi selger kun ved fra fornybare skoger. Veden er ofte av blandede sorter. Se produktinfo for mer informasjon.</p>
        <h2 class="mb-2"><i class="bi bi-pin-map"></i> Flere forskjellige lokasjoner</h2>
        <p>Velg hentested ovenfor. Disse stedene inkluderer for øyeblikket Tverrvik, Norge. Flere kommer!</p>
        <h2 class="mb-2"><i class="bi bi-wallet2"></i> Trygt å bruke</h2>
        <p>Alle kjøp behandles gjennom WooCommerce og offisielle leverandører. Hvis kjøpet ditt ikke lykkes, vennligst kontakt oss!</p>
        <h2 class="mb-2"><i class="bi bi-cash-coin"></i> Støtt veldedige organisasjoner og små, lokale organisasjoner</h2>
        <p>De fleste kjøp vil også støtte en lokal organisasjon og hjelpe dem med å holde driften i gang. De kan for eksempel støtte et fotballag for barn! Denne informasjonen vil bli oppført på butikksiden.</p>
      </div>
    </div>
    <div class="tab-pane fade" id="pills-fi" role="tabpanel" aria-labelledby="pills-fi-tab">
      <div class="container-fluid">
        <h1 class="mb-3 font-weight-bold">Vedogvarer - Osta polttopuuta verkossa, nouda pisteestä heti.</h1>
        <h2 class="mb-2"><i class="bi bi-clock-history"></i> 24/7 Service</h2>
        <p>Vedogvarer tarjoaa laadukkaita norjalaisia polttopuita ja muita retkeilytarvikkeita ympäri vuorokauden. Osta verkossa Vippsillä tai luottokortilla ja nouda sitten valitsemastasi laitteesta.</p>
        <h2 class="mb-2"><i class="bi bi-graph-up-arrow"></i> Korkea laatu</h2>
        <p>Takuunalaista korkeaa laatua. Tilauksesi pysyy kuivana kovimmissakin sääolosuhteissa.</p>
        <h2 class="mb-2"><i class="bi bi-tree"></i> Uusiutuva puu</h2>
        <p>Myymme puuta vain uusiutuvista metsistä. Polttopuut ovat usein sekalajikkeita. Katso lisätietoja tuotetiedoista.</p>
        <h2 class="mb-2"><i class="bi bi-pin-map"></i> Useita erilaisia sijainteja</h2>
        <p>Valitse noutopaikkasi yllä. Näihin sijainteihin kuuluu tällä hetkellä Tverrvik, Norja. Lisää on tulossa!</p>
        <h2 class="mb-2"><i class="bi bi-wallet2"></i> Turvallinen käyttää</h2>
        <p>Kaikki ostokset käsitellään WooCommercen ja virallisten palveluntarjoajien kautta. Jos ostoksesi ei onnistu, ota meihin yhteyttä!</p>
        <h2 class="mb-2"><i class="bi bi-cash-coin"></i> Tue hyväntekeväisyysjärjestöjä ja pieniä, paikallisia järjestöjä</h2>
        <p> Useimmat ostokset tukevat myös jotain paikallista järjestöä ja auttavat heitä jatkamaan toimintaansa. Ne voivat esimerkiksi tukea lasten jalkapallojoukkuetta! Tämä tieto mainitaan kaupan sivulla.</p>
      </div>
    </div>
  </div>
</div>

<div class="pb-3 pt-3">
	<h6 class="pt-5 text-center text-grey-border">This site has been originally written in English. All other translations are automatically generated by Google Translate. DeepL was used to translate certain pages.</h6>
</div>

	</main><!-- #main -->

	<script>
		//image urls - using free images from pexels but hosted to imgur so they should stay alive :). now in 480x480p
        const imageUrls = [
            'https://i.imgur.com/qu61ahL.jpeg',
            'https://i.imgur.com/zgvIE7L.jpeg',
            'https://i.imgur.com/y8zbLOx.jpeg',
            'https://i.imgur.com/ONv5Aq0.jpeg',
            'https://i.imgur.com/UUojpJQ.jpeg',
            'https://i.imgur.com/M8UquLf.jpeg',
            'https://i.imgur.com/ROApIMK.jpeg',
            'https://i.imgur.com/6s9LYzT.jpeg',
            'https://i.imgur.com/MIH4899.jpeg',
            'https://i.imgur.com/8GanbJC.jpeg',
            'https://i.imgur.com/zhYvrQJ.jpeg',
            'https://i.imgur.com/TjYgbrH.jpeg',
            'https://i.imgur.com/ZgjsaOT.jpeg',
            'https://i.imgur.com/hgWw8VA.jpeg',
            'https://i.imgur.com/hHjtQbg.jpeg'
        ];

        // Function to set one of these images as BG
        function setRandomBackgroundImage() {
            const randomIndex = Math.floor(Math.random() * imageUrls.length);
            const selectedImageUrl = imageUrls[randomIndex];
            document.querySelector('.banner').style.backgroundImage = `url('${selectedImageUrl}')`;
        }

        // Call the function on page load
        window.onload = setRandomBackgroundImage;
    </script>

<?php
get_sidebar();
get_footer();