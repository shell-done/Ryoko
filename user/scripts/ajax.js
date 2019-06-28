// \file ajax.js
// Contient les fonctions permettant d'effectuer des requêtes Ajax

// Envoie une requête ajax
// \param type Type de requête HTTP
// \param request Requête Ajax à effectuer
// \param callback Fonction à appeler lors de la réception de la réponse
// \param data Données à envoyer
// \author Thibault Napoléon
function ajaxRequest(type, request, callback, data = null) {
  var xhr = new XMLHttpRequest(); // Créer la requête

  if(type == 'GET' && data != null) { // Si le type est 'GET', on ajoute la data à la fin de l'url
    request += '?' + data;
    data = null;
  }
  xhr.open(type, request, true);

  if(data) // Définition du header de la requête
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
    switch(xhr.status) {
      case 200:
      case 201:
        callback(xhr.responseText); // Si pas d'erreur, on appelle la fonction de callback
        break;

      default: // En cas d'erreur, on l'affiche
        showAjaxErrors(xhr.status);
    }
  }

  xhr.send(data); // Envoie des données
}

function showAjaxErrors(errorNumber) {
  // Liste des principales erreurs php
  var HTTP_STATUS_CODES = {
    '400' : 'Bad Request',
    '401' : 'Unauthorized',
    '402' : 'Payment Required',
    '403' : 'Forbidden',
    '404' : 'Not Found',
    '405' : 'Method Not Allowed',
    '406' : 'Not Acceptable',
    '407' : 'Proxy Authentication Required',
    '408' : 'Request Timeout',
    '409' : 'Conflict',
    '410' : 'Gone',
    '411' : 'Length Required',
    '412' : 'Precondition Failed',
    '413' : 'Request Entity Too Large',
    '414' : 'Request-URI Too Long',
    '415' : 'Unsupported Media Type',
    '416' : 'Requested Range Not Satisfiable',
    '417' : 'Expectation Failed',
    '500' : 'Internal Server Error',
    '501' : 'Not Implemented',
    '502' : 'Bad Gateway',
    '503' : 'Service Unavailable',
    '504' : 'Gateway Timeout',
    '505' : 'HTTP Version Not Supported'
  };

  // Affichage d'un popup d'info signalant l'erreur
  showInfo(
    "Erreur lors de la requête au serveur",
    `<b>Code d'état HTTP : ` + errorNumber + ` - ` + HTTP_STATUS_CODES[errorNumber] + `</b><br /><br />
     <p>
        Une erreur est survenue lors d'une requête au serveur. <br />
        Merci de réessayer dans quelques minutes. <br />
        Si l'erreur persiste, veuillez contacter l'administrateur du site.
     </p>`,
    true);
}
