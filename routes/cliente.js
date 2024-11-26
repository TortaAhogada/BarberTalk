const express = require('express');
const routerCliente = express.Router();
const { ejecutarConsulta } = require('./db'); // Importa la función desde db.js

// Endpoint GET para obtener todos los clientes
routerCliente.get('/', async (req, res) => {
  try {
    // Consulta SQL
    const consultaSQL = 'SELECT * FROM cliente;';
    
    // Ejecuta la consulta llamando a la función genérica
    const clientes = await ejecutarConsulta(consultaSQL);

    // Responde con los datos obtenidos
    res.status(200).send(JSON.stringify(clientes));
  } catch (error) {
    console.error('Error al manejar la solicitud:', error.message || error);
    res.status(500).json({
      success: false,
      message: 'Error al obtener los clientes',
    });
  }
});

// Endpoint GET para obtener un cliente por ID
routerCliente.get('/:id', async (req, res) => {
    const { id } = req.params; // Obtén el parámetro dinámico de la URL
  
    try {
      const consultaSQL = `SELECT * FROM cliente WHERE id_cliente = ${id};`; // Consulta SQL con un parámetro
      const cliente = await ejecutarConsulta(consultaSQL); // Pasa el id como parámetro
  
      if (cliente.length === 0) {
        // Si no se encuentra el cliente, responde con un 404
        return res.status(404).json({
          success: false,
          message: `Cliente con id ${id} no encontrado`,
        });
      }
  
      res.status(200).json({
        success: true,
        data: cliente[0], // Devuelve el primer (y único) registro
      });
    } catch (error) {
      console.error('Error al manejar la solicitud:', error.message || error);
      res.status(500).json({
        success: false,
        message: 'Error al obtener el cliente',
      });
    }
  });

  // Método POST para crear un nuevo cliente
routerCliente.post('/', async (req, res) => {
    const {
      nombre,
      primer_apellido,
      segundo_apellido,
      correo,
      num_telefono,
      nom_usuario,
      contraseña,
      edad,
      sexo,
      calle,
      num_direccion,
      colonia,
    } = req.body; // Extraemos los datos del cuerpo de la solicitud
  
    try {
      // Consulta SQL para insertar un nuevo cliente
      const consultaSQL = `
        insert into Cliente (Nombre, primer_apellido, 
        segundo_apellido, correo, num_telefono, nom_usuario, 
        Contraseña, edad, sexo, calle, num_direccion, colonia) 
        values 
        ('${nombre}',
         '${primer_apellido}',
          '${segundo_apellido}',
          '${correo}',
           '${num_telefono}', 
        '${nom_usuario}', 
        '${contraseña}', 
        ${edad}, 
        '${sexo}',
        '${calle}',
        ${num_direccion},
        '${colonia}');`;
  
      // Ejecutamos la consulta con los valores recibidos
      const nuevoCliente = await ejecutarConsulta(consultaSQL,);
  
      res.status(201).json({
        success: true,
        message: 'Cliente creado exitosamente',
        data: nuevoCliente[0], // Retornamos el cliente recién creado
      });
    } catch (error) {
      console.error('Error al crear cliente:', error.message || error);
      res.status(500).json({
        success: false,
        message: 'Error al crear cliente',
      });
    }
  });

  // Método PUT para actualizar un cliente existente
routerCliente.put('/:id', async (req, res) => {
    const { id } = req.params; // Obtiene el id_cliente de los parámetros de la URL
    const {
      nombre,
      primer_apellido,
      segundo_apellido,
      correo,
      num_telefono,
      nom_usuario,
      contraseña,
      edad,
      sexo,
      calle,
      num_direccion,
      colonia,
    } = req.body; // Obtiene los datos enviados en el cuerpo de la solicitud

    try {
      const consultaSQL = `
        UPDATE cliente SET nombre = '${nombre}',
          primer_apellido = '${primer_apellido}',
          segundo_apellido = '${segundo_apellido}',
          correo = '${correo}',
          num_telefono = '${num_telefono}',
          nom_usuario = '${nom_usuario}',
          contraseña = '${contraseña}',
          edad = ${edad},
          sexo = '${sexo}',
          calle = '${calle}',
          num_direccion = ${num_direccion},
          colonia = '${colonia}'
        WHERE id_cliente = ${id}
        RETURNING *;`;
  
      const resultado = await ejecutarConsulta(consultaSQL);
        console.log(resultado[0])
      if (resultado.length === 0) {
        return res.status(404).json({
          success: false,
          message: `Cliente con id ${id} no encontrado`,
        });
      }
  
      res.json({
        success: true,
        message: 'Cliente actualizado exitosamente',
        data: resultado[0],
      });
    } catch (error) {
      console.error('Error al actualizar cliente:', error.message || error);
      res.status(500).json({
        success: false,
        message: 'Error al actualizar cliente',
      });
    }
  });

  // Método DELETE para eliminar un cliente existente
routerCliente.delete('/:id', async (req, res) => {
    const { id } = req.params; // Obtiene el id_cliente de los parámetros de la URL
  
    try {
      const consultaSQL = `
        DELETE FROM cliente
        WHERE id_cliente = ${id}
        RETURNING *;
      `;
  
      const resultado = await ejecutarConsulta(consultaSQL);
  
      if (resultado.length === 0) {
        return res.status(404).json({
          success: false,
          message: `Cliente con id ${id} no encontrado`,
        });
      }
  
      res.json({
        success: true,
        message: `Cliente con id ${id} eliminado exitosamente`,
        data: resultado[0],
      });
    } catch (error) {
      console.error('Error al eliminar cliente:', error.message || error);
      res.status(500).json({
        success: false,
        message: 'Error al eliminar cliente',
      });
    }
  });
  
  

module.exports = routerCliente;





  
  