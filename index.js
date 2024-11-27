//Librería importada para poder realizar el servidor
const express = require('express');

//Constante usada para manejar el servidor
const app = express();

//Creación del router para manejar las url's
const routerCliente = require('./routes/cliente'); // Ajusta el nombre del archivo según corresponda

app.use(express.json());
// Middleware para rutas

//Utilización del router para definir la url
app.use('/cliente', routerCliente);


// Inicializar el servidor
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Servidor escuchando en el puerto ${PORT}`);
});

//Manejar una petición get en la pagina principal
app.get('/', (req,res)=>{
    res.send('<h1>Este es la pagina principal del proyecto|</h1>')
})
