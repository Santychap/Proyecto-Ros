@echo off
echo ========================================
echo PROBANDO API REST - RESTAURANT ADMIN
echo ========================================

echo.
echo 1. Probando endpoint de productos (GET)
curl -X GET http://localhost:8080/productos -H "Content-Type: application/json"

echo.
echo.
echo 2. Probando endpoint de categorias (GET)
curl -X GET http://localhost:8080/categorias -H "Content-Type: application/json"

echo.
echo.
echo 3. Probando endpoint de usuarios (GET)
curl -X GET http://localhost:8080/users -H "Content-Type: application/json"

echo.
echo.
echo ========================================
echo PRUEBAS COMPLETADAS
echo ========================================
pause