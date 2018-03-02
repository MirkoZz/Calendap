<?php
// Controle si un client est connecté
function customerConnected()
{
  if(!isset($_SESSION['customer']))
  {
    return false;
  }
  else
  {
    return true;
  }
}

// Controle si un professionnel est connecté
function professionalConnected()
{
  if(!isset($_SESSION['professional']))
  {
    return false;
  }
  else
  {
    return true;
  }
}


// classe active pour les liens du menu
function currentClass($currentUrl)
{
  $url = 'http://http://www.fredericroth.fr/projets/projet-final/' . $_SERVER['PHP_SELF'];

  if($currentUrl == $url)
  {
    echo 'current';
  }
}

// Controle l'extension des photos
function fileCheck()
{
  // récupération de l'extension du fichier
  $extension = strrchr($_FILES['picture']['name'], '.');
  $extension = strtolower(substr($extension, 1));

  // exetensions autorisées
  $validExtensionTab= array('gif', 'jpg', 'jpeg', 'png', 'svg');

  $extensionCheck = in_array($extension, $validExtensionTab);

  return $extensionCheck;
}