const express = require('express');
const cors = require('cors');
const cookieParser = require('cookie-parser');
const csurf = require('csurf');

const app = express();
app.use(cookieParser());

const csrfProtection = csurf({
  cookie: {
    httpOnly: true,
    secure: true, // Asegúrate de usar HTTPS en producción
    sameSite: 'None'
  }
});

app.use(cors({
  origin: 'https://barbertalk4.onrender.com',
  credentials: true
}));
app.use(express.json());

// Rutas
const routerCliente = require('./routes/cliente');
const routerRegistro = require('./routes/registro');
const routerLogin = require('./routes/login');

// ✅ NO aplicar csrfProtection globalmente a estas rutas
app.use('/registro', routerRegistro);
app.use('/cliente', routerCliente);
app.use('/iniciosesion', csrfProtection, routerLogin);

// ✅ Mantener esta ruta protegida para obtener el token CSRF
app.get('/api/csrf-token', csrfProtection, (req, res) => {
  console.log('Generando token CSRF:', req.csrfToken());  // <-- depuración aquí
  res.json({ csrfToken: req.csrfToken() });
});


app.get('/', (req, res) => {
  res.send('Bienvenido a la API de clientes');
});

// Manejador de errores CSRF
app.use((err, req, res, next) => {
  if (err.code === 'EBADCSRFTOKEN') {
    return res.status(403).json({ error: 'Token CSRF inválido o faltante' });
  }
  next(err);
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Servidor escuchando en el puerto ${PORT}`);
});

module.exports = app;
