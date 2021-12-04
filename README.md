# Autor: Joaquín Quero Torres

Para la resolución del reto se ha seguido una solución basada en el paradigma de arquitectura hexagonal o DDD. Para ello, se han distinguido los siguientes módulos principales:

Elevators: referente a los ascensores
Floors: referente a las plantas
Logs: referente a donde se va a guardar la información
Sequences: referente a las secuencias
Simulations: referente a las simulaciones

Dependiendo del módulo y sus necesidades este podrá contemplar los siguientes directorios:

Domain: con la definición de la entidad, puerto del repositorio, value objects y servicios de dominio
Application: con los servicios de aplicación o casos de uso indicados en la prueba.
Infraestructura: compuesta por el adaptador al repositorio del dominio y los controladores para las llamadas a los endpoints
Además se ha creado un módulo adicional, Shared, que contiene aspectos a compartir en los otros módulos.

Para ejecutar, inicalmente hay que construir y levantar el contenedor de docker. Para ello, vamos a la capeta docker del proyecto y ejecutamos:

docker-compose up --build

Una vez esté el contenedor funcionando, hay que acceder a él para instalar las dependencias:

docker exec -it nombre-contenedor bash

Dentro del contenedor, para facilitar la ejecución de determinados comandos, se ha creado un makefile, de tal manera que:

Instalar las dependencias:
make deps

Ejecutar las pruebas:
make tests

Ejecutar el phpstan
make phpstan

Debido a las necesidades de tiempo ha sido imposible realizar en una primera instancia los tests. 