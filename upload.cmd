rsync -avz -e ssh ^
--chmod=755 ^
--exclude="/storage/app/***" ^
--exclude="/storage/framework/***" ^
--exclude="/storage/logs/***" ^
--include="/app/***" ^
--include="/bootstrap/***" ^
--include="/config/***" ^
--include="/database/***" ^
--include="/public/***" ^
--include="/resources/***" ^
--include="/routes/***" ^
--include="/storage/***" ^
--include="/tests/***" ^
--include="/.env.example" ^
--include="/artisan" ^
--include="/composer.json" ^
--include="/composer.lock" ^
--include="/dump.sql" ^
--include="/package-lock.json" ^
--include="/package.json" ^
--include="/phpunit.xml" ^
--include="/server.php" ^
--include="/webpack.mix.js" ^
--include="/yarn.lock" ^
--exclude="*" ^
. kevin@kevinpena.com:/var/www/sergio-avila/

ssh kevin@kevinpena.com "cd /var/www/sergio-avila && composer update --no-dev"
ssh kevin@kevinpena.com "cd /var/www/sergio-avila && npm install"
ssh kevin@kevinpena.com "cd /var/www/sergio-avila && npm run production"
ssh kevin@kevinpena.com "cd /var/www/sergio-avila && php artisan view:clear"
ssh kevin@kevinpena.com "cd /var/www/sergio-avila && php artisan view:cache"
ssh kevin@kevinpena.com "cd /var/www/sergio-avila && php artisan scout:import App\\\\Item"
