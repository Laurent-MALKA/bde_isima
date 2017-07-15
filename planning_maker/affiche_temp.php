<?php
include("inc/bdd.php");
if(empty($_GET['echange']))$_GET['echange']=null;
if(empty($_GET['c_id']))$_GET['c_id']=null;
if(!empty($_GET['echange']) && !empty($_GET['echange2']) && !empty($_GET['c_id']) && !empty($_GET['c_id2']))
{
	$bdd->query('UPDATE planning_temp SET m_id='.$_GET['echange2'].' WHERE c_id='.$_GET['c_id'].' AND m_id='.$_GET['echange']);
	$bdd->query('UPDATE planning_temp SET m2_id='.$_GET['echange2'].' WHERE c_id='.$_GET['c_id'].' AND m2_id='.$_GET['echange']);

	$bdd->query('UPDATE planning_temp SET m_id='.$_GET['echange'].' WHERE c_id='.$_GET['c_id2'].' AND m_id='.$_GET['echange2']);
	$bdd->query('UPDATE planning_temp SET m2_id='.$_GET['echange'].' WHERE c_id='.$_GET['c_id2'].' AND m2_id='.$_GET['echange2']);
	
	header("location:./affiche_temp.php");
}

include "inc/head.php";
?>

	<a class="menu" href="genere_planning.php">Générer un planning temporaire</a>
	<a class="menu" href="get_from_def.php" onclick="return confirm('ATTENTION: cela ne prend pas en compte les nouvelles disponibilités des membres')">Reprendre le planning definitif et l'éditer</a>
	<?php
		if(isset($_GET['valider'])) echo '<a class="menu" href="affiche_temp.php">Annuler</a><a  class="menu" href="valider_planning.php">Confirmer la validation</a> <em><strong>Attention:</strong> cela efface l\'ancien planning !</em>';
		else echo '<a  class="menu" href="affiche_temp.php?valider=true">Valider ce planning</a>';

		
			echo "<br />";
			
			if(isset($_GET['echange'])){
				echo"<strong>Choisir avec qui échanger</strong><br />";
				echo "Echange en cours: ";
				$membre = $bdd->query("SELECT m_nom FROM membres WHERE m_id=".$_GET['echange']);
				foreach($membre as $m)echo $m["m_nom"]." ";
				$creneaux = $bdd->query("SELECT c_deb,c_fin FROM creneaux WHERE c_id=".$_GET['c_id']);
				foreach($creneaux as $c)echo $c["c_deb"]." &rarr; ".$c["c_fin"];
			}
			else echo"<strong>Cliquer sur quelqu'un pour un échange</strong>";
			function dispo($day, $bdd){
				$creneaux = $bdd->query("SELECT * FROM creneaux WHERE c_jour=".$day." ORDER BY c_deb");
				foreach($creneaux as $c){
					$dispo=False;
					$d = $bdd->query("SELECT membres.m_nom, membres.m_id FROM planning_temp, membres WHERE (planning_temp.m_id=membres.m_id OR planning_temp.m2_id=membres.m_id) AND c_id=".$c['c_id']."");
					if(isset($_GET['echange']))
					{
						$d = $bdd->query("SELECT membres.m_nom, membres.m_id FROM planning_temp, membres WHERE (planning_temp.m_id=membres.m_id OR planning_temp.m2_id=membres.m_id) AND c_id=".$c['c_id']." AND NOT (planning_temp.m_id=".$_GET['echange']." OR planning_temp.m2_id=".$_GET['echange'].")  AND EXISTS (SELECT 1 FROM dispos WHERE (dispos.m_id=".$_GET['echange'].") AND dispos.c_id=".$c['c_id'].")");
					}


					$aaa=0;
					foreach($d as $i){
						$dispo=True;
						if(isset($_GET['echange']))
						{
							$dispo=False;
							$disponible=$bdd->query("SELECT c_id FROM dispos WHERE c_id=".$_GET['c_id']." AND m_id=".$i['m_id']);
							foreach($disponible as $hjazfj)$dispo=True;
							if($dispo)
							{
								$disponible=$bdd->query("SELECT m_id, m2_id FROM planning_temp WHERE c_id=".$_GET['c_id']." ");
								foreach($disponible as $hjazfj){
									if($hjazfj['m_id']==$i['m_id'])$dispo=False;
									if($hjazfj['m2_id']==$i['m_id'])$dispo=False;
								}
							}
						}
						if($dispo){
							if($aaa==0)echo "<br /><label for='dispo_".$c['c_id']."'>".$c['c_deb']." &rarr; ".$c['c_fin']."</label>";
							echo "<a href='affiche_temp.php?echange=".$i['m_id']."&c_id=".$c['c_id']."&echange2=".$_GET['echange']."&c_id2=".$_GET['c_id']."'>".$i['m_nom']."</a> ";
							$aaa++;
						}
					}
				}
			}
//			echo "<table style='width:100%;'><tr>";
//			echo "<td>Lundi</td><td>Mardi</td><td>Mercredi</td><td>Jeudi</td><td>Vendredi</td><td>Samedi</td><td>Dimanche</td></tr><tr>";
			echo "<br /><br />";
                        if(!isset($_GET['echange']))echo "<br />";
			for($i=0;$i<7;$i++){	
echo "<div style='width:100%; max-width:300px;height:300px;margin:32px; padding:16px; float:left;box-shadow:2px 2px 5px grey'>";
			        echo "<strong>".$jours[$i]."</strong>";
				dispo($i, $bdd);
				echo "</div>";	
			}
			
			?>
		       
			<?php
			if(isset($_GET['echange'])){
                                echo "<div style='width:100%; max-width:300px;height:300px;margin:32px; padding:16px; float:left;box-shadow:2px 2px 5px grey'><strong>Echanger avec</strong><br />";
				$d = $bdd->query("SELECT membres.m_nom,dispos.m_id FROM dispos, membres WHERE c_id=".$_GET['c_id']." AND dispos.m_id = membres.m_id AND NOT dispos.m_id=".$_GET['echange']);
				foreach($d as $dd){
					$disponible=$bdd->query("SELECT m_id, m2_id FROM planning_temp WHERE c_id=".$_GET['c_id']." ");
					$dispo=True;
					foreach($disponible as $hjazfj){
						if($hjazfj['m_id']==$dd['m_id'])$dispo=False;
						if($hjazfj['m2_id']==$dd['m_id'])$dispo=False;
					}
					if($dispo)echo "<a href='affiche_temp.php?echange=".$_GET['echange']."&c_id=".$_GET['c_id']."&echange2=".$dd['m_id']."&c_id2=-1'>".$dd['m_nom']."</a> <br />";
				}
                           echo "</div>";
			}
			function compter_perm($id, $bdd){
				$a = $bdd->query("SELECT p_id, c_poids FROM planning_temp, creneaux WHERE (m_id=".$id." OR m2_id=".$id.") AND planning_temp.c_id=creneaux.c_id");
				$i=0;
				foreach($a as $b)$i+=$b['c_poids'];
				return $i;
			}
			echo "</div>";
			$membres = $bdd->query("SELECT * FROM membres ORDER BY m_nom");
                        echo "<div style='width:100%; max-width:300px;height:300px;margin:32px; padding:16px; float:left;box-shadow:2px 2px 5px grey'><strong>Compteur de perms</strong><br />";
			foreach($membres as $mb){
				$min = compter_perm($mb['m_id'], $bdd);
				$heures = intval(floatval($min)/60.0);
				$min = $min - 60*$heures;
				if($min<10)$min="0".$min;
				echo $mb['m_nom']." ".$heures."h".$min."<br />";
			}
	?>
		
