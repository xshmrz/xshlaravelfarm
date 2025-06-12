<!doctype html>
<html lang="{{ config("app.locale") }}">
@include("Site.Mobile.component-header")
<body>
<div id="loader">
	<img src="assets/site-pwa/img/loading-icon.png" alt="icon" class="loading-icon">
</div>
@yield("section-main")
@include("Site.Mobile.component-footer")
</body>
</html>
