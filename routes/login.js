//Las importaciones necesarias omaiga
const express = require('express');
const routerLogin = express.Router();
const { ejecutarConsulta } = require('./db');
const bcrypt = require('bcrypt');

//obtener primero el metodo del server.js
routerLogin.post('/', async (req, res) => {
  const { usuario, contraseña } = req.body; //almacen de usuario y contraseña

  if (!usuario || !contraseña) { //En caso que no haya datos, error
    return res.status(400).json({ mensaje: 'Usuario y contraseña son obligatorios' });
  }

  try {
    // Buscar por correo o nombre de usuario en la base de datos cliente
    const consulta = `
      SELECT * FROM cliente
      WHERE correo = $1 OR nom_usuario = $1
      LIMIT 1;
      `;
    const resultado = await ejecutarConsulta(consulta, [usuario]); //Ejecuto la consulta de db.js

    if (resultado.length === 0) { //si no hay usuario, error
      return res.status(401).json({ mensaje: 'Usuario o contraseña incorrectos' });
    }

    const cliente = resultado[0]; //Obtengo el primer resultado

    //Comparar la contraseña con bcrypt
    const match = await bcrypt.compare(contraseña, cliente.contraseña);

    if (!match) {
      return res.status(401).json({ mensaje: 'Usuario o contraseña incorrectos' });
    }

    //Si todo bien, puedes devolver los datos que necesites (sin la contraseña)
    delete cliente.contraseña; //elimina la contraseña del objeto {cliente} para no enviarla al cliente xd
    res.status(200).json({ mensaje: 'Inicio de sesión exitoso', cliente });
  } catch (error) {
    console.error('Error en login:', error);
    res.status(500).json({ mensaje: 'Error del servidor' });
  }
});

module.exports = routerLogin;