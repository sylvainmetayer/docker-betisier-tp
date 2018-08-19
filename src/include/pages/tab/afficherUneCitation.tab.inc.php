<?php
$moyenneVote = $voteManager->getMoyenneVote($citation->getCitationNum());
$detailsPersonne = $personneManager->getPersonne($citation->getCitationPerNum());
$etudiant = $personneManager->getPersonne($citation->getCitationPerNumEtu());

?> <tr>
  <td> <?php echo $detailsPersonne->getPerNom()." ". $detailsPersonne->getPerPrenom(); ?> </td>
  <td> <?php echo $citation->getCitationLibelle(); ?> </td>
  <td> <?php echo getFrenchDate($citation->getCitationDate()); ?> </td>
  <td> <?php $moyenneVote ? print number_format($moyenneVote, 2) : print "-" ;?> </td>

  <?php if (isConnected() && $personneManager->isEtudiant(getPersonneConnectee()->getPerNum())) { ?>
  <td>
  <?php
  if (!$voteManager->isPerNumDejaVote(getPersonneConnectee()->getPerNum(), $citation->getCitationNum())) { ?>
    <a href="index.php?page=<?php echo VOTER_CITATIONS; ?>&amp;id=<?php echo $citation->getCitationNum(); ?>"> <img alt="Voter !" src="image/modifier.png" title="Voter pour cette citation"/></a>
  <?php } else {
    $voteEtudiant = $voteManager->getVoteEtudiant(getPersonneConnectee()->getPerNum(), $citation->getCitationNum());
    $valeurVote = $voteEtudiant->getVotValeur();
    ?>
    <img alt="Deja vote !" src="image/erreur.png"/>&nbsp;Votre note : <?php empty($valeurVote) ? print "0" : print number_format($voteEtudiant->getVotValeur(), 2);
  }
  ?>
  </td>
  <?php }

  if (isConnected() && getPersonneConnectee()->isPerAdmin()) {
    $dateValide = $citation->getCitationDateValide();
    $pernumValide = $citation->getCitationPerNumValide();
    if ($citation->getCitationPerNumValide() != NULL) {
        $validePar = $personneManager->getPersonne($citation->getCitationPerNumValide());
    } ?>
  <td> <?php echo $etudiant->getPerNom()." ".$etudiant->getPerPrenom();  ?> </td>
  <td> <?php (!empty($dateValide) && !empty($pernumValide)) ? print $validePar->getPerNom()." ".$validePar->getPerPrenom() : print "-"; ?> </td>
  <td>
  <?php

  if (empty($dateValide) && empty($pernumValide)) {
    //OUI donc les deux images
    ?>
    <a href="index.php?page=<?php echo VALIDER_CITATIONS."&amp;cit_num=".$citation->getCitationNum()."&amp;cit_valide=1"; ?>" title="Approuver cette citation">
      <img src="image/valid.png" alt="Approuver la citation"/>
    </a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="index.php?page=<?php echo VALIDER_CITATIONS."&amp;cit_num=".$citation->getCitationNum()."&amp;cit_valide=zero"; ?>" title="Refuser cette citation">
      <img src="image/erreur.png" alt="Refuser la citation"/>
    </a>
    <?php
  } else {
    $citationValide = $citation->getCitationValide();
    if (empty($citationValide) && !empty($dateValide)) {
      ?>
      <img src="image/non-approuver.png" alt="Citation déjà modérée, et refusée !" title="Citation déjà modérée, et refusée !"/>
      <?php
    } else {
      ?>
      <img src="image/approuvee.ico" alt="Citation déjà modérée, et approuvée !" title="Citation déjà modérée, et approuvée !"/>
      <?php
    }

  }
  ?>
  </td>
  <td> <a href="index.php?page=<?php echo SUPPRIMER_CITATIONS; ?>&amp;id=<?php echo $citation->getCitationNum(); ?>" title="Supprimer cette citation"> <img src="image/erase.png" alt="Effacer"/> </a></td>
  <?php } ?>
  </tr>
