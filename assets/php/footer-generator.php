<?php
// Generate a footer for a HTML document
function generateFooter($html, $path) : string {

	$htmlPieces = explode("<!--:FOOTER:-->", $html);

	$newHtml = $htmlPieces[0];

	$newHtml .= '
		<footer id="footer">

			<div class="header-container">
				<div id="footer-logo">
					<h2><a href="'.$path.'">TuffeTuffeTåg</a></h2>
					<div class="mark"></div>
				</div>
			</div>

			<div class="footer-content max-content center-content">

				<section id="footer-navigation">
					<h2>Navigation</h2>
					<div class="mark"></div>

					<ul>
						<li><a href="'.$path.'">Hem</a></li>
						<li><a href="'.$path.'resor/">Resor</a></li>
						<li><a href="'.$path.'konto/">Konto</a></li>
						<li><a href="'.$path.'kontakt/">Kontakt</a></li>
					</ul>

				</section>

				<section id="footer-social">
					<h2>Följ oss på sociala medier</h2>
					<div class="mark"></div>
					
					<ul>
						
						<li>
							<img src="'.$path.'assets/img/facebook.svg" alt="Facebook icon" class="social-icon">
							<a href="">Facebook</a>
						</li>

						<li>
							<img src="'.$path.'assets/img/twitter.svg" alt="Twitter icon" class="social-icon">
							<a href="">Twitter</a>
						</li>

					</ul>

				</section>

				<section id="footer-subscribe">
					<h2>Premuerera på vårt brev</h2>
					<div class="mark"></div>

					<form id="subscribe-form" method="POST">
						
						<input id="subscribe-form-email" class="input-icon email-icon" type="email" name="mail">
						
						<p id="subscribe-error-spot" class="error-spot"></p>

						<p id="subscribe-result">Tack för din premuration!</p>

						<button type="submit">Prenumerera</button>
						
						<img id="subscribe-loading" src="'.$path.'assets/img/loading-animation.svg" alt="loading animation">

					</form>

				</section>

			</div>
			
		</footer>
		<script>
	var footerPath = "'.$path.'";	
</script>
	';

	$newHtml .= $htmlPieces[1];

	return $newHtml;
}
?>