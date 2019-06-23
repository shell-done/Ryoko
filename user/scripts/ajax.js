function ajaxRequest(type, request, callback, data = null) {
  var xhr = new XMLHttpRequest();

  if(type == 'GET' && data != null) {
    request += '?' + data;
    data = null;
  }
  xhr.open(type, request, true);

  if(data)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
    switch(xhr.status) {
      case 200:
      case 201:
        callback(xhr.responseText);
        break;

      default:
        //httpErrors(xhr.status)
        ;
    }
  }

  xhr.send(data);
}

function httpErrors(errorNumber) {
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

  dispError("Connection error : " + errorNumber + "(" + HTTP_STATUS_CODES[errorNumber] + ")");
}
