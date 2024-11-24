const { Pool } = require('pg');

// Configuración del pool de conexiones
const pool = new Pool({
  connectionString: "postgres://default:eVWlOCi8a4pE@ep-weathered-dew-a417d6tq-pooler.us-east-1.aws.neon.tech:5432/verceldb?sslmode=require",
});

// Función genérica para ejecutar consultas
const ejecutarConsulta = async (consultaSQL) => {
  try {
    const result = await pool.query(consultaSQL);
    return result.rows; // Devuelve las filas obtenidas
  } catch (error) {
    console.error('Error al ejecutar la consulta:', error.message || error);
    throw error; // Propaga el error para manejarlo en otros lugares
  }
};



module.exports = {
  ejecutarConsulta,
};
