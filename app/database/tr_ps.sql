DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `maxminmoy_duree_commandes`(
	out jmax int,
	out jmin int,
	out jmoy float(8,2))
BEGIN
	select max(tri.diff) into jmax from (SELECT id_commande as idCom, abs(datediff((SELECT date from suivi_commande where id_etat = 1 and id_commande = idCom), (SELECT date from suivi_commande where id_etat = 2 and id_commande = idCom))) as diff from suivi_commande) as tri;
	select min(tri.diff) into jmin from (SELECT id_commande as idCom, abs(datediff((SELECT date from suivi_commande where id_etat = 1 and id_commande = idCom), (SELECT date from suivi_commande where id_etat = 2 and id_commande = idCom))) as diff from suivi_commande) as tri;
	select round(avg(tri.diff),2) into jmoy from (SELECT id_commande as idCom, abs(datediff((SELECT date from suivi_commande where id_etat = 1 and id_commande = idCom), (SELECT date from suivi_commande where id_etat = 2 and id_commande = idCom))) as diff from suivi_commande) as tri;
end$$

CREATE PROCEDURE `maxminmoy_montant_commandes`(
	OUT cmax FLOAT(8,2),
	OUT cmin FLOAT(8,2),
	OUT cmoy FLOAT(8,2))
BEGIN
	select max(total) into cmax from commandes;
	select min(total) into cmin from commandes;
	select round(avg(total),2) into cmoy from commandes;
end$$

DELIMITER ;

--
-- Triggers `commandes`
--
DELIMITER $$
CREATE TRIGGER `before_delete_commande` BEFORE DELETE ON `commandes`
FOR EACH ROW begin
# Si l id de la commande avant de la delete n a pas un etat = 2 (càd expédié) dans la table suivi commande, alors message d erreur
  if old.id not in(select id_commande from suivi_commande where id_etat = 2)
  then
    signal sqlstate '45000' set message_text = "Il est impossible de supprimer une commande qui n a pas encore été expédiée";
  end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_commandes` BEFORE INSERT ON `commandes`
FOR EACH ROW BEGIN
  if (select count(suivi_commande.id_etat) from suivi_commande left join commandes on id_commande = commandes.id where client_id = new.client_id and id_commande not in(select id_commande from suivi_commande where id_etat = 2)) >= 2
  THEN
    SIGNAL SQLSTATE '45000' set MESSAGE_TEXT = "Ce client a deja 2 commandes en attente d etre expediees, il ne peut pas passer de commande";
  end if;
end
$$
DELIMITER ;

