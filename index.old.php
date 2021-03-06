<?php
	ini_set("display_errors", 1);
	require "./api/api.php";
?>

<!DOCTYPE HTML>
<!--
	Dimension by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Site du BDE de l'ISIMA</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<meta name="msapplication-TileColor" content="#fee"/>
        <meta name="theme-color" content="#fee">
		<meta name="Description" content="Site du BDE de l'ISIMA, découvre la vie étudiante d'un ZZ (étudiant de l'ISIMA) sur notre site !" /> 
		<meta name="Keywords" content="ISIMA, Clermont-Ferrand, Informatique, Etudiant, Vie etudiante, Clubs, Associations, <?php $clubs = api("get_liste_clubs");foreach($clubs['liste'] as $c)echo $c['nom'].", "; ?>Concours CCP, CPGE, Ingenieur, UBP, UCA, Universite Clermont-Auvergne, BREI, BNEI, plaquette alpha" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="logo">
							<img src="./images/logo.png" style="width:100%" />
						</div>
						<div class="content">
							<div class="inner">
								<h1>BDE ISIMA</h1>
								<p><!--[-->Découvre la vie étudiante d'un ZZ (étudiant de l'ISIMA) dès maintenant ! <!--]--></p>
							</div>
						</div>
						<nav>
							<ul>
								<li><a href="#actus">News</a></li>
								<li><a href="#bde">Le BDE</a></li>
								<li><a href="#clubs">Clubs</a></li>
								<li><a href="./espace_ZZ">Compte</a></li>
								<li><a href="#contact">Contact</a></li>
							</ul>
							<p><br /><a href="#actus"><em>DERNIERE NEWS: <?php echo api("get_news", array("nombre" => 1))['liste'][0]['titre']; ?></em></a></p>
						</nav>
					</header>

				<!-- Main -->
					<div id="main">

							<article id="actus">
								<?php include "pages/actus.php"; ?>
							</article>

							<article id="bde">
								<?php include "pages/bde.php"; ?>
							</article>

							<article id="clubs">
								<?php include "pages/clubs.php"; ?>
							</article>

							<article id="contact">
								<?php include "pages/contact.php"; ?>
							</article>

							<article id="zz">
								<?php include "pages/zz.php"; ?>
							</article>
							
							<article id="partenaires">
								<?php include "pages/partenaires.php"; ?>
							</article>

							<article id="details_club">
								<?php include "pages/details_club.php"; ?>
							</article>

							<article id="oubli">
								<?php include "pages/oubli.php"; ?>
							</article>

							<article id="create_account">
								<?php include "pages/create_account.php"; ?>
							</article>

					</div>

				<!-- Footer -->
					<footer id="footer">
						<p class="copyright">&copy; BDE ISIMA. Design: <a href="https://html5up.net">HTML5 UP</a>.
						<br />Créé par BDE BliZZard. <a href="#partenaires">Nos partenaires</a></p>
					</footer>

			</div>

		<!-- BG -->
			<div id="bg"></div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="assets/js/scripts.js"></script>

	</body>
</html>
