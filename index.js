const express = require('express');
const app = express();
const routerCliente = require('./routes/cliente'); // Ajusta el nombre del archivo según corresponda

app.use(express.json());
// Middleware para rutas
app.use('/cliente', routerCliente);


// Inicia el servidor
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Servidor escuchando en el puerto ${PORT}`);
});

app.get('/', (req,res)=>{
    res.send('<h1>Este es la pagina principal del proyecto</h1>')
})
