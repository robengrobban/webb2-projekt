<?php
// Generate a nav for a HTML document
function generateNav($html, $path) : string {

	$htmlPieces = explode("<!--:NAV:-->", $html);

	$newHtml = $htmlPieces[0];

	if ( isLoggedIn() ) {
		$newHtml .= '
	
		<nav>
			<div class="max-content center-content" id="nav-flex-container">
				<div id="nav-header">
					<div id="nav-logo">
						<a href="'.$path.'">TuffeTuffeTåg</a>
					</div>
					<div id="hamburger-menu">
						<img src="'.$path.'assets/img/hamburger-menu.svg" alt="hamburger menu">
					</div>
				</div>
				<ul id="nav-content">
					'.(isAdmin($path) ? '<li><a class="nav-item itemhide" href="'.$path.'admin/">Admin</a></li>' : '').'
					<li><a class="nav-item itemhide" href="'.$path.'resor/">Resor</a></li>
					<li><a class="nav-item itemhide" href="'.$path.'konto/">Konto</a></li>
					<li><a class="nav-item itemhide" href="'.$path.'?logout">Logga ut</a></li>
					<li><a class="nav-item itemhide" href="'.$path.'kontakt/">Kontakt</a></li>
				</ul>
			</div>
		</nav>
		
		';
	}
	else {
		$newHtml .= '
		
		<nav>
			<div class="max-content center-content" id="nav-flex-container">
				<div id="nav-header">
					<div id="nav-logo">
						<a href="'.$path.'">TuffeTuffeTåg</a>
					</div>
					<div id="hamburger-menu">
						<img src="'.$path.'assets/img/hamburger-menu.svg" alt="hamburger menu">
					</div>
				</div>
				<ul id="nav-content">
					<li><a class="nav-item itemhide" href="'.$path.'resor/">Resor</a></li>
					<li><a class="nav-item itemhide" href="'.$path.'logga-in/">Logga in</a></li>
					<li><a class="nav-item itemhide" href="'.$path.'skapa-konto/">Skapa konto</a></li>
					<li><a class="nav-item itemhide" href="'.$path.'kontakt/">Kontakt</a></li>
				</ul>
			</div>
		</nav>
		
		';
	}

	$newHtml .= $htmlPieces[1];

	return $newHtml;
}
?>