const express = require('express'); 
const routerRegistro = express.Router();
const { ejecutarConsulta } = require('./db');
const bcrypt = require('bcrypt');


// Ruta para obtener todos los registros
routerRegistro.post('/', async (req, res) => {
  const { nombre, edad, apellido1, apellido2, genero, calle, colonia, correo, telefono, contraseña, contraseña2, apodo } = req.body;

  if (!nombre || !edad || !apellido1 || !apellido2 || !genero || !calle || !colonia || !correo || !telefono || !contraseña || !contraseña2 || !apodo) {
    return res.status(400).json({ mensaje: 'Todos los campos son obligatorios' });
  }

  if (contraseña !== contraseña2) {
    return res.status(400).json({ mensaje: 'Las contraseñas no coinciden' });
  }

  if(!(/^[a-zA-Z][0-9a-zA-Z]{5,49}$/.test(apodo))){
    return res.status(400).json({ error: 'El nombre de usuario solo puede contener letras y números, sin espacios y debe ser de una extension mínima de 6 caracteres' });
  }

  if(!validarPassword(contraseña)){
    return res.status(400).json({ error: 'La contraseña debe tener al menos 10 caracteres, una mayúscula, una minúscula, un número y un carácter especial' });
  }


  try {
    const hashContraseña = await bcrypt.hash(contraseña, 10);

    const consulta = `
      SELECT registro_cliente(
        $1, $2, $3, $4, $5, $6,
        $7, $8, $9, $10, $11, $12
      ) AS resultado;
    `;

    const valores = [
      nombre, apellido1, apellido2, correo, telefono, apodo,
      hashContraseña, edad, genero, calle, "0", colonia
    ];

    const resultado = await ejecutarConsulta(consulta, valores);

    if (resultado[0].resultado === -1) {
      return res.status(400).json({ mensaje: 'El correo o nombre de usuario ya existe' });
    }

    res.status(201).json({ mensaje: 'Registro exitoso', id_cliente: resultado[0].resultado });

  } catch (error) {
    console.error('Error al registrar:', error);
    res.status(500).json({ mensaje: 'Error del servidor' });
  }
} );

function validarPassword(password){
    return(
        password.length >= 10 &&
        /[A-Z]/.test(password) &&
        /[a-z]/.test(password) &&
        /[0-9]/.test(password) &&
        /[^A-Za-z0-9\s]/.test(password)
    )
}

module.exports = routerRegistro;