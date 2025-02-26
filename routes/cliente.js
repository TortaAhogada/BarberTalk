//Importación de las librerías utilizadas en el proyecto
const express = require('express'); 
const routerCliente = express.Router();
const { ejecutarConsulta } = require('./db');


/* 
Metodo routerCliente.get
Proposito: Obtenerlos datos de todos los clientes registrados
Parametro de entrada: Ninguno
Parametro de salida: Array de clientes con la siguiente estructura:
{
    "id_cliente": 3,
    "nombre": "joaquin",
    "primer_apellido": "guzman",
    "segundo_apellido": "loera",
    "correo": "correo@gmail.com",
    "num_telefono": "31215",
    "nom_usuario": "elchapo",
    "contraseña": "123456",
    "edad": 56,
    "sexo": "Masculino",
    "calle": "calle",
    "num_direccion": 13,
    "colonia": "delfin"
  },
Ejecución: Mediante la URL https://barber-talk.vercel.app/cliente (En la web o Postman)

Endpoint: localizado en index.js
app.use('/cliente', routerCliente);
*/
routerCliente.get('/', async (req, res) => {
  try {
    // Consulta SQL
    const consultaSQL = 'SELECT * FROM cliente;'; // Consulta SQL 
    
    /* 
      Función ejecutarConsulta()
      Función para realizar la consulta a la base de datos
      Recibe sentencias en SQL
    */
    const clientes = await ejecutarConsulta(consultaSQL); //Método ubicado en db.js

    // Responde con los datos obtenidos modificando el estado a 200
    res.status(200).send(JSON.stringify(clientes));
  } 
  /*
  Bloque para manejar un error al realizar la consulta sql
  */
  catch (error) {
    console.error('Error al manejar la solicitud:', error.message || error);
    res.status(500).json({
      success: false,
      message: 'Error al obtener los clientes',
    });
  }
});

/* 
Metodo routerCliente.get
Proposito: Obtener los datos de un cliente en especifico
Parametro de entrada: Id del cliente
Parametro de salida: Array con datos del cliente en el formato:
{
    "id_cliente": 3,
    "nombre": "joaquin",
    "primer_apellido": "guzman",
    "segundo_apellido": "loera",
    "correo": "correo@gmail.com",
    "num_telefono": "31215",
    "nom_usuario": "elchapo",
    "contraseña": "123456",
    "edad": 56,
    "sexo": "Masculino",
    "calle": "calle",
    "num_direccion": 13,
    "colonia": "delfin"
  }
Ejecución: Mediante la URL https://barber-talk.vercel.app/cliente/(id_cliente) (En la web o Postman)
Endpoint: localizado en index.js
app.use('/cliente', routerCliente);
*/
routerCliente.get('/:id', async (req, res) => {
    const { id } = req.params; // Obtén el parámetro dinámico de la URL
  
    try {
      const consultaSQL = `SELECT * FROM cliente WHERE id_cliente = ${id};`; // Consulta SQL 

      /* 
        Función ejecutarConsulta()
        Función para realizar la consulta a la base de datos
        Recibe sentencias en SQL
      */
      const cliente = await ejecutarConsulta(consultaSQL);
  
      if (cliente.length === 0) {
        // Si no se encuentra el cliente, responde con un 404
        return res.status(404).json({
          success: false,
          message: `Cliente con id ${id} no encontrado`,
        });
      }
      // Responde con los datos obtenidos modificando el estado a 200
      res.status(200).json({
        success: true,
        data: cliente[0], // Devuelve el primer (y único) registro
      });
    } 
    /*
      Bloque para manejar un error al realizar la consulta sql
    */
    catch (error) {
      console.error('Error al manejar la solicitud:', error.message || error);
      res.status(500).json({
        success: false,
        message: 'Error al obtener el cliente',
      });
    }
  });

  /* 
    Metodo routerCliente.post
    Proposito: Endpoint post para crear a un nuevo cliente
    Parametro de entrada: Todos los atributos de la tabla cliente en formato JSON:
    {
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
    }
      Parametro de salida: Mensaje de status y los datos del cliente recien agregado en el formato:
      {
        "id_cliente": 3,
        "nombre": "joaquin",
        "primer_apellido": "guzman",
        "segundo_apellido": "loera",
        "correo": "correo@gmail.com",
        "num_telefono": "31215",
        "nom_usuario": "elchapo",
        "contraseña": "123456",
        "edad": 56,
        "sexo": "Masculino",
        "calle": "calle",
        "num_direccion": 13,
        "colonia": "delfin"
      }
    Ejecución: Mediante la URL https://barber-talk.vercel.app/cliente (Postman)
    Endpoint: localizado en index.js
    app.use('/cliente', routerCliente);
  */
routerCliente.post('/', async (req, res) => {
    // Se define una constante donde se extrae los datos del cuerpo de la solicitud
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
      // Consulta SQL para insertar un nuevo cliente, se utiliza los atributos definidos anteriormente
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
  
      /* 
        Función ejecutarConsulta()
        Función para realizar la consulta a la base de datos
        Recibe sentencias en SQL
      */
      const nuevoCliente = await ejecutarConsulta(consultaSQL,);
      
      // Responde con los datos obtenidos modificando el estado a 201
      res.status(201).json({
        success: true,
        message: 'Cliente creado exitosamente',
        data: nuevoCliente[0], // Retornamos el cliente recién creado
      });
    } 
    /*
      Bloque para manejar un error al realizar la consulta sql
    */
    catch (error) {
      console.error('Error al crear cliente:', error.message || error);
      res.status(500).json({
        success: false,
        message: 'Error al crear cliente',
      });
    }
  });

  /* 
    Metodo routerCliente.put
    Proposito: Endpoint put para actualizar a un cliente
    Parametro de entrada: Todos los atributos de la tabla cliente en formato JSON:
    {
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
    }
    Parametro de salida: Mensaje de status y los datos del cliente actualidado en la siguiente estructura:
    {
        "id_cliente": 3,
        "nombre": "joaquin",
        "primer_apellido": "guzman",
        "segundo_apellido": "loera",
        "correo": "correo@gmail.com",
        "num_telefono": "31215",
        "nom_usuario": "elchapo",
        "contraseña": "123456",
        "edad": 56,
        "sexo": "Masculino",
        "calle": "calle",
        "num_direccion": 13,
        "colonia": "delfin"
      }
    Ejecución: Mediante la URL https://barber-talk.vercel.app/cliente/(id_cliente) (Postman)
    Endpoint: localizado en index.js
    app.use('/cliente', routerCliente);
  */

    //Se define el router para que el cliente pueda ingresar el id_cliente en la URL
    routerCliente.put('/:id', async (req, res) => {
    
    const { id } = req.params; // Obtiene el id_cliente de los parámetros de la URL

    // Se define una constante donde se extrae los datos del cuerpo de la solicitud
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
      // Consulta SQL para insertar un nuevo cliente, se utiliza los atributos definidos anteriormente
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
      
      /* 
        Función ejecutarConsulta()
        Función para realizar la consulta a la base de datos
        Recibe sentencias en SQL
      */
      const resultado = await ejecutarConsulta(consultaSQL);
      /*
      En caso de que la respuesta tenga un longitud de 0, 
      significa que no funciono de manera correcta la ejecución en la base de datos
      */
      if (resultado.length === 0) {
        return res.status(404).json({
          success: false,
          message: `Cliente con id ${id} no encontrado`,
        });
      }
      // Responde con los datos obtenidos en la consulta y un mensaje de exito
      res.json({
        success: true,
        message: 'Cliente actualizado exitosamente',
        data: resultado[0],
      });
    } 
    /*
      Bloque para manejar un error al realizar la consulta sql
    */
    catch (error) {
      console.error('Error al actualizar cliente:', error.message || error);
      res.status(500).json({
        success: false,
        message: 'Error al actualizar cliente',
      });
    }
  });

    /* 
      Metodo routerCliente.delete
      Proposito: Endpoint delete para borrar a un cliente en especifico
      Parametro de entrada: Id del cliente
      Parametro de salida:Mensaje de status y los datos del cliente borrado en la estructura
      {
        "id_cliente": 3,
        "nombre": "joaquin",
        "primer_apellido": "guzman",
        "segundo_apellido": "loera",
        "correo": "correo@gmail.com",
        "num_telefono": "31215",
        "nom_usuario": "elchapo",
        "contraseña": "123456",
        "edad": 56,
        "sexo": "Masculino",
        "calle": "calle",
        "num_direccion": 13,
        "colonia": "delfin"
      }
      Ejecución: Mediante la URL https://barber-talk.vercel.app/cliente/(id_cliente) (Postman)
      Endpoint: localizado en index.js
      app.use('/cliente', routerCliente);
    */

    //Se define el router para que el cliente pueda ingresar el id_cliente en la URL
    routerCliente.delete('/:id', async (req, res) => {
    const { id } = req.params; // Obtiene el id_cliente de los parámetros de la URL
  
    try {
      //Se define la consulta en una constante
      const consultaSQL = `
        DELETE FROM cliente
        WHERE id_cliente = ${id}
        RETURNING *;
      `;
      
      /* 
        Función ejecutarConsulta()
        Función para realizar la consulta a la base de datos
        Recibe sentencias en SQL
      */
      const resultado = await ejecutarConsulta(consultaSQL);
      
      /*
      En caso de que la respuesta tenga un longitud de 0, 
      significa que no funciono de manera correcta la ejecución en la base de datos
      */
      if (resultado.length === 0) {
        return res.status(404).json({
          success: false,
          message: `Cliente con id ${id} no encontrado`,
        });
      }
      
      // Responde con los datos obtenidos en la consulta y un mensaje de exito
      res.json({
        success: true,
        message: `Cliente con id ${id} eliminado exitosamente`,
        data: resultado[0],
      });
    } 
    /*
      Bloque para manejar un error al realizar la consulta sql
    */
      catch (error) {
      console.error('Error al eliminar cliente:', error.message || error);
      res.status(500).json({
        success: false,
        message: 'Error al eliminar cliente',
      });
    }
  });
  
  
/*
  Método para poder exportar los routers de cliente, 
*/
module.exports = routerCliente;