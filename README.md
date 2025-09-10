cp ../docker/.env-example ../docker/.env \
cp ../docker/.env-example ./.env \
cd ../docker \ 
docker-compose up -d \
docker exec app php yii migrate --interactive 0 















ROUTES \
/orders/list - список заказов

Для посика с вводом данных необходимо после заполнения формы нажать на лупу

Для скачивания csv необходимо нажать на кнопку Export Csv под таблицей

