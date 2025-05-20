const express = require('express');
const cors = require('cors'); // <--- importa cors
const cookieParser = require('cookie-parser');
const csurf = require('csurf');

const app = express();
app.use(cookieParser());

const csrfProtection = csurf({
  cookie: {
    httpOnly: true,
    secure: false,  // Cambiar a true si usas HTTPS
    sameSite: 'lax'
  }
});

app.use(cors({
  origin: 'https://barbertalk4.onrender.com/', // <--- permite peticiones desde tu frontend
  credentials: true
}));
app.use(express.json());

// Rutas
const routerCliente = require('./routes/cliente');
const routerRegistro = require('./routes/registro');
const routerLogin = require('./routes/login');


// Para las rutas que quieres proteger, agregas el middleware:
app.use('/registro', csrfProtection, routerRegistro);
app.use('/cliente', csrfProtection, routerCliente);
app.use('/login', csrfProtection, routerLogin);


// Ruta para enviar el token CSRF al frontend
app.get('/api/csrf-token', csrfProtection, (req, res) => {
  // Envía el token en json para que frontend lo use
  res.json({ csrfToken: req.csrfToken() });
});


app.get('/', (req, res) => {
  res.send('Bienvenido a la API de clientes');
});

// Manejador de errores CSRF
app.use((err, req, res, next) => {
  if (err.code === 'EBADCSRFTOKEN') {
    // Token CSRF inválido o ausente
    return res.status(403).json({ error: 'Token CSRF inválido o faltante' });
  }

  // Otros errores
  next(err);
});
 

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Servidor escuchando en el puerto ${PORT}`);
});

module.exports = app;
