<?php
/*
	get_liste_articles.php

	ENTREE
		numero: carte de l'utilisateur dont on veut connaitre le nom
					
	SORTIE:
		le nom de l'utilisateur
	AUTORISATION:
		all
*/



$autorise = array("zz", "bde");
function get_liste_articles($settings, $objets){
	$bdd = $objets['bdd'];
	$articles = $bdd->query("SELECT articles.*, COUNT(transactions.id) AS c FROM articles, transactions WHERE transactions.id_article = articles.id AND transactions.timestamp BETWEEN NOW() - INTERVAL 30 DAY AND NOW()   GROUP BY transactions.id_article ORDER BY c DESC");
	$retour = array();
	$retour["nb_elt"]=0;
	foreach ($articles as $r)
	{
		$retour['liste'][] = array(
			"id" => $r['id'],
			"nom" => utf8_encode($r['nom']),
			"tarif" => utf8_encode($r['tarif']),
			"img" => $r['img']
		);
		$retour["nb_elt"]++;
	}
	
	return $retour;
}
?>
