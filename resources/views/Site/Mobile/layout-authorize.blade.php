<!doctype html>
<html lang="en">
@include("Site.Mobile.component-header")
<body>
<div id="loader">
	<img src="assets/site-pwa/img/loading-icon.png" alt="icon" class="loading-icon">
</div>
<div class="appHeader no-border transparent position-absolute">
	<div class="left"></div>
	<div class="pageTitle"></div>
	<div class="right"></div>
</div>
<div id="appCapsule">
	@yield("section-main")
</div>
@include("Site.Mobile.component-footer")
</body>
</html>
