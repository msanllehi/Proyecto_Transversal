@echo off
echo Insertando productos de ejemplo en la base de datos...
mysql -u root -h localhost opinions_db < src\main\resources\data-products.sql
echo Productos insertados correctamente.
pause
