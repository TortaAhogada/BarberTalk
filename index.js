const { Pool } = require('pg');
require('dotenv').config();

const pool = new Pool({
  connectionString: "postgres://default:eVWlOCi8a4pE@ep-weathered-dew-a417d6tq-pooler.us-east-1.aws.neon.tech:5432/verceldb?sslmode=require",
});

(async () => {
  try {
    // Conexión al pool
    const client = await pool.connect();
    console.log('Conexión exitosa a la base de datos.');

    // Consulta para obtener todos los registros de la tabla "cliente"
    const res = await client.query('SELECT * FROM cliente;');
    console.log('Registros de la tabla "cliente":', res.rows);

    // Libera el cliente
    client.release();
  } catch (err) {
    console.error('Error al realizar la consulta:', err.message || err);
  } finally {
    // Cierra el pool al finalizar
    await pool.end();
    console.log('Pool cerrado.');
  }
})();

const express = require ('express')
const app=express();

app.get('/',(req,res)=>{
    res.send('<h1>Este es el título principal de la página.</h1>')
})

const PUERTO= 5432;

app.listen(PUERTO, ()=>{
    console.log(`El servidor esta escuchando en el puerto ${PUERTO}`)
})
