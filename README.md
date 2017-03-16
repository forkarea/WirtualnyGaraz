# WirtualnyGaraz

Projekt strony pozwalającej na prowadzenie ewidencji swoich pojazdów.
Dla każdego pojazdu przewidziane są następujące opcje:
- prowadzenie ewidencji napraw
- prowadzenie histroii tankowań
- galeria
Dla każdego samochodu jest podsumowanie: liczba przejechanych kilometrów, suma pieniędzy wydanych na tankowania i naprawy.


## .htaccess konfiguracja
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^(.+)$ index.php?uri=$1 [QSA,L]

## nginx konfiguracja
location = /favicon.ico {
}
location / {
if (!-e $request_filename){
rewrite ^(.+)$ /index.php?uri=$1 break;
}
}


## Instalacja
1. Stwórz katalogi: cache, sessions, uploads i nadaj im chmod 777.
2. Stwórz plik .env a w nim:
BASE_DIR=
CACHE_DIR="${BASE_DIR}/cache/
DIR_VENDOR=${BASE_DIR}/vendor/
DIR_TEMPLATE=${BASE_DIR}/template/
DIR_UPLOAD=${BASE_DIR}/uploads/
DIR_TEMPLATE_CACHE=${BASE_DIR}/cache/template/
WEBSITE_NAME=
DEFAULT_REPLAY_TO=
DEFAULT_MAIL=
DATABASE_NAME=
DATABASE_USER=
DATABASE_HOST=
DATABASE_PASSOWD=