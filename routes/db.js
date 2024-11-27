//Se importa de la libreria pg, pool el cual es utilizado para realizar la conexión a la base de atos
const { Pool } = require('pg');

// Configuración de la conexión a la base de datos en la nube
const pool = new Pool({
  connectionString: "postgres://default:eVWlOCi8a4pE@ep-weathered-dew-a417d6tq-pooler.us-east-1.aws.neon.tech:5432/verceldb?sslmode=require",
});

/*
  Función para poder realizar las consultas de SQL,
  este recibe la sentencia sql y las manda para ejecutarlas
  en la base de datos.
*/
const ejecutarConsulta = async (consultaSQL) => {
  try {
    const result = await pool.query(consultaSQL);
    return result.rows; // Devuelve las filas obtenidas
  } catch (error) {
    console.error('Error al ejecutar la consulta:', error.message || error);
    throw error; // Propaga el error para manejarlo en otros lugares
  }
};

//Método para poder exportar el modulo ejecutarConsulta, 

module.exports = {
  ejecutarConsulta,
};
