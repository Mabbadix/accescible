<!DOCTYPE html>
<html>
<style>
html, body {height:100%;margin:0;color: red;}
#GrandeIntro {height:100%;background:url(http://www.hdwallpapersplus.com/wp-content/uploads/2012/10/Opera-Background-Blue-Swirls1.jpg) no-repeat;background-size:cover;}
#siteWrapper {margin-top:-80px;}
#siteWrapper header {height:80px;background:#000;}
#siteWrapper header.fixed {position:fixed;width:100%;top:0;left:0;}
#content {padding:60px 0;background:#0c9;}
#siteWrapper header.fixed+#content {margin-top:80px;}
#content div {width:80%;height:1500px;margin:auto;border:solid;}
</style>
<div id="GrandeIntro"></div>
<div id="siteWrapper">
<header>
  <div id="headerTop">5588</div>
  <div id="Grandenavigation"><nav>23232323</nav></div>
</header>
<section id="content">
  <div>ghghghg</div>
</section>
</div>
<script>
var header = document.querySelector("#siteWrapper header");

function scrolled(){
	var windowHeight = document.body.clientHeight,
		currentScroll = document.body.scrollTop || document.documentElement.scrollTop;

	header.className = (currentScroll >= windowHeight - header.offsetHeight) ? "fixed" : "";
}

addEventListener("scroll", scrolled, false);
</script>
</html>
