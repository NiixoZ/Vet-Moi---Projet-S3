<?php
declare(strict_types=1);
require "autoload.php";

$auth = new SecureUserAuthentication();
if(!SecureUserAuthentication::isUserConnected()) header("Location: connexion.php");
$user = $auth->getUser();
if(!$user->isVeto()) header('Location: accueil.php');

$webPage = new WebPage("liste_clients");

$html= <<< HTML
<div class='d-flex align-items-center flex-column ' style='row-gap:2em; width:100%; margin-top: 2.5em;'>
    <span class='title main-ui-class'> Liste des Clients </span>

    <div class="d-flex justify-content-center flex-column main-ui-class">
        <div class="d-flex justify-content-center align-items-center" style="gap: 0.5em;">
            <label for='search-bar' style="margin: 0; font-size: 1.35em;">Nom:</label> 
            <input type="search" id="search-bar" placeholder="Rechercher..." style="padding: 10px; border-radius: 10px; width: 300px;"> 
        </div>
        <div id="liste-clients" style='padding:20px; width:100%;' class="d-flex justify-content-center align-items-center flex-column flex-grow-1"></div>
        
    </div>

</div>
HTML;
$webPage->appendJs(<<<JS
    window.onload = function() {
            new AjaxRequest({
                url: "api/getListeClients.php",
                method: 'get',
                handleAs: 'json',
                parameters: {},
                onSuccess: function (res) {
                    let listeCli = document.getElementById('liste-clients');
                    for(let i = 0; i < res.length; i++)
                    {
                        let clientName = document.createElement('span');
                        clientName.style.width = '100%';
                        clientName.style.backgroundColor = '#C9C9C9';
                        clientName.style.padding = '15px';
                        clientName.style.borderRadius = '20px';
                        clientName.style.margin = '10px';
                        let prenom = res[i]['firstName'];
                        clientName.innerText = res[i]['lastName'].toUpperCase() + " " + prenom.charAt(0).toUpperCase() + prenom.slice(1).toLowerCase();
                        clientName.onclick = function(){
                            location.href = 'fiche_client_animal.php?userId=' + res[i]['userId'] + "&animalId=null";
                            
                        }
                        listeCli.appendChild(clientName);
                    }  
                },
                onError: function (status, message) {
                }  
            });
    }
    
JS);



$webPage->appendContent($html);
echo $webPage->toHTML();