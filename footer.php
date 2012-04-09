		  	</div> <!-- end of #content -->
		    
		</div> <!-- end of #main -->
		    
	</div> <!-- end of #wrap -->
	
	<nav id="mainNav">
			
		<a href="<?php echo home_url(); ?>" class="logo_sm">TEDxYYC</a>
	
    	<?php wp_nav_menu(array('theme_location' => 'primary_navigation', 'depth' => 1)); ?>
		
		<ul class="clearfix">
			<li><a href="http://twitter.com/#!/tedxyyc/">Twitter</a></li>
			<li><a href="http://www.facebook.com/TEDxYYC">Facebook</a></li>
			<li><a href="/contact/">Newsletter</a></li>
		</ul>
		
		<a href="/event-details/" class="flagNav">
			<h2>Friday May 25th 2012</h2>
			<h3>Telus Spark Science Centre</h3>
		</a>

	</nav>

	<div id="footerWrap">

	<footer class="row">
								
		<section class="navigation three columns clearfix">
			<h2>Navigation</h2>
			<?php wp_nav_menu(array(
				'theme_location' => 'footer_left',
				'menu_class' => 'left'
				));
			?>
			<?php wp_nav_menu(array(
				'theme_location' => 'footer_right',
				'menu_class' => 'left'
				));
			?>
		</section>
		
		<section class="social three columns clearfix">
			<h2>We Like To Be Social</h2>
			<?php wp_nav_menu(array(
				'theme_location' => 'footer_social',
				));
			?>
		</section>
		
		<section class="recentTweet three columns clearfix">
			<h2>The Twitterverse</h2>
			
			 <?php // custom twitter latest widget cuz others don't work
				$username = "tedxyyc";
				$prefix = "<p>";
				$suffix = "</p>";
				$feed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=1";
				
				function parse_feed($feed) {
				    $stepOne = explode("<content type=\"html\">", $feed);
				    $stepTwo = explode("</content>", $stepOne[1]);
				    $tweet = $stepTwo[0];
				    $tweet = str_replace("&lt;", "<", $tweet);
				    $tweet = str_replace("&gt;", ">", $tweet);
				    return $tweet;
				}
				
				$twitterFeed = file_get_contents($feed);
				echo stripslashes($prefix) . parse_feed($twitterFeed) . stripslashes($suffix);
			?>
			
			<span style="float:right;">TEDxYYC on <a href="http://twitter.com/tedxyyc/">Twitter.com</a></span>
				
		</section>
		
		<section class="legalStuff three columns clearfix">
			<h2>Legal Stuff</h2>
			<p>This independent TEDx event is operated under license from TED.</p>
			<p class="legal"><a href="/privacy-policy-terms-of-service/">Privacy Policy</a>   |   <a href="/privacy-policy-terms-of-service/">Terms of Use</a><br />
			© 2012 TEDxYYC. All rights reserved.</p>
		</section>
		
	</footer>

	</div> <!-- footer wrap -->

	<script>
	    window._gaq = [['_setAccount','UA-20245932-1'],['_trackPageview'],['_trackPageLoadTime']];
	    Modernizr.load({
	      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
	    });
  	</script>

<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->

</body>
</html>
