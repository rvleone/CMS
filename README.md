# CMS
## Traduzir para portugues BR
Instalação
Scaffold do diretório lang
php artisan lang:publish
Instale o pacote
composer require lucascudo/laravel-pt-br-localization --dev
Publique as traduções
php artisan vendor:publish --tag=laravel-pt-br-localization
Configure o Framework para utilizar 'pt_BR' como linguagem padrão
// Altere Linha 85 do arquivo config/app.php para:
'locale' => 'pt_BR'

// Para versões 11.x altere a linha 8 do arquivo .env
APP_LOCALE=pt_BR
