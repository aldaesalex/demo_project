# demo_project

# En este pequeño proyecto se aplico el uso de lang, de tal manera que nuestra API podrías ser multilenguaje, para este caso usamos español e ingles.
# Al inicio se fue tedioso lo de los acentos, se descargan en codificacion ANSII, con el bloc de notas se convirtio a UTF-8
# Para ganar velocidad en tiempo de respuesta se agrego un indice al campo que se utiliza para filtrar
# Se utilizaron constantes para el manejo de códigos de error
# Para las validaciones usamos el requests, de esta forma separamos reglas de negocio y datos requeridos
# Se coloco un manejo de errores personalizados
# Se manda al log un registro en caso de que se llegue a presentar un error no controlado