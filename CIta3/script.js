const pantallas = document.querySelectorAll('.pantalla');
const btnSiguienteFecha = document.getElementById('btnSiguienteFecha');
const btnAnteriorHora = document.getElementById('btnAnteriorHora');
const btnSiguienteHora = document.getElementById('btnSiguienteHora');
const btnAnteriorBarbero = document.getElementById('btnAnteriorBarbero');
const btnSiguienteBarbero = document.getElementById('btnSiguienteBarbero');
const btnAnteriorServicio = document.getElementById('btnAnteriorServicio');
const btnSiguienteInformacion = document.getElementById('btnSiguienteInformacion');
const btnAnteriorInformacion = document.getElementById('btnAnteriorInformacion');


let pantallaActiva = 0;
let resumenCita = "";
const idCliente=document.getElementById("idCliente").value

// Función para mostrar la siguiente pantalla
function mostrarSiguientePantalla() {
    // Obtener la fecha actual
    const fechaActual = new Date();

    // Obtener la fecha seleccionada por el usuario
    const fechaCitaString = document.getElementById('fechaCita').value;
    const fechaCita = new Date(fechaCitaString);
    fechaCita.setDate(fechaCita.getDate() + 1);
    // Validar que la fecha seleccionada no sea anterior a la fecha actual
    if (fechaCitaString === "") {
        alert("Por favor ingresa una fecha");
    } else if (fechaCita < fechaActual && fechaCita.toDateString() !== fechaActual.toDateString()) {
        alert("No puedes seleccionar una fecha anterior a la fecha actual.");
    } else {
        pantallas[pantallaActiva].classList.remove('active');
        pantallaActiva++;
        pantallas[pantallaActiva].classList.add('active');

        if (pantallaActiva === pantallas.length) {
            btnSiguienteInformacion.disabled = true;
        } else {
            btnSiguienteInformacion.disabled = false;
        }

        if (pantallaActiva > 0) {
            btnAnteriorInformacion.disabled = false;
        } else {
            btnAnteriorInformacion.disabled = true;
        }
        actualizarResumenCita();
    }
}

// Función para mostrar la pantalla anterior
function mostrarPantallaAnterior() {
    pantallas[pantallaActiva].classList.remove('active');
    pantallaActiva--;
    pantallas[pantallaActiva].classList.add('active');

    if (pantallaActiva === 0) {
        btnAnteriorInformacion.disabled = true;
    } else {
        btnAnteriorInformacion.disabled = false;
    }

    if (pantallaActiva < pantallas.length - 1) {
        btnSiguienteInformacion.disabled = false;
    } else {
        btnSiguienteInformacion.disabled = true;
    }

    actualizarResumenCita();
}

// Función para obtener horarios disponibles
function obtenerHorariosDisponibles(fecha) {
    fetch('procesar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'action': 'getHorarios',
            'fecha': fecha
        })
    })
    .then(response => response.json())
    .then(data => {
        // Actualizar la lista de horarios disponibles en el DOM
        const selectHora = document.getElementById('horaCita');
        selectHora.innerHTML = '<option value="">Selecciona una hora</option>';

        data.forEach(hora => {
            const option = document.createElement('option');
            option.value = hora;
            option.textContent = hora;
            selectHora.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error al obtener los horarios disponibles:', error);
    });
}




// Función para mostrar la pantalla de selección de barbero
function mostrarPantallaBarbero() {
    const hora = document.getElementById('horaCita').value;
    const fecha = document.getElementById('fechaCita').value;

    if (hora === "" || fecha === "") {
        alert("Por favor selecciona una fecha y una hora");
        return;
    }

    // Realizar la solicitud AJAX para obtener los trabajadores disponibles
    fetch('procesar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'action': 'getTrabajadores',
            'fecha': fecha,
            'hora': hora
        })
    })
    .then(response => response.json())
    .then(data => {
        const selectBarbero = document.getElementById('barberoSeleccionado');
        selectBarbero.innerHTML = '<option value="">Selecciona un barbero</option>';

        data.forEach(trabajador => {
            const option = document.createElement('option');
            option.value = trabajador.ID_trabajador;
            option.textContent = trabajador.nombre;
            selectBarbero.appendChild(option);
        });
        mostrarSiguientePantalla();
    })
    .catch(error => {
        console.error('Error al obtener los trabajadores disponibles:', error);
    });
}

// Agregar eventos de clic a los botones
btnSiguienteFecha.addEventListener('click', function() {
    const fecha = document.getElementById('fechaCita').value;
    if (fecha) {
        obtenerHorariosDisponibles(fecha);
        mostrarSiguientePantalla();
    } else {
        alert("Por favor ingresa una fecha");
    }
});

btnSiguienteBarbero.addEventListener('click', function() {
    const barbero = document.getElementById('barberoSeleccionado').value;
    if (barbero=="") {
        alert("Por favor seleccione uno de nuestros barberos")
    }else{
        mostrarSiguientePantalla();
    }
});

// Al cargar la página
window.onload = function() {
    actualizarResumenCita();
};

// Función para enviar los datos del formulario al script PHP
function enviarDatos() {
    // Obtener los valores de los campos del formulario
    const fechaCita = document.getElementById('fechaCita').value;
    const horaCita = document.getElementById('horaCita').value;
    const barberoSeleccionado = document.getElementById('barberoSeleccionado').value;
    const servicioSeleccionado = document.querySelector('input[name="servicio"]:checked').value;

    // Crear un objeto FormData y agregar los datos
    const formData = new FormData();
    formData.append('fechaCita', fechaCita);
    formData.append('horaCita', horaCita);
    formData.append('barberoSeleccionado', barberoSeleccionado);
    formData.append('servicioSeleccionado', servicioSeleccionado);
    formData.append('idcliente', idCliente);

    // Realizar la solicitud AJAX para enviar los datos al script PHP
    fetch('insertarDatos.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(text => {
        // Imprimir la respuesta en la consola
        
    })
    .catch(error => {
        console.error('Error al enviar los datos:', error);
    });
    alert("Se registro con exito la cita :)");
    window.location.href = 'Tabla_Usuario.php';
}

// Agregar evento de clic al botón "Enviar"
document.getElementById('btnEnviar').addEventListener('click', enviarDatos);


// Agregar evento de clic al botón "Enviar"
document.getElementById('btnEnviar').addEventListener('click', enviarDatos);
document.getElementById('fechaCita').addEventListener('change', actualizarResumenCita);
document.getElementById('horaCita').addEventListener('change', actualizarResumenCita);
document.getElementById('barberoSeleccionado').addEventListener('change', actualizarResumenCita);
document.querySelector('input[name="servicio"]').addEventListener('change', actualizarResumenCita);


btnAnteriorHora.addEventListener('click', mostrarPantallaAnterior);
btnSiguienteHora.addEventListener('click', mostrarPantallaBarbero);
btnAnteriorBarbero.addEventListener('click', mostrarPantallaAnterior);
btnAnteriorServicio.addEventListener('click', mostrarPantallaAnterior);
btnSiguienteInformacion.addEventListener('click', mostrarSiguientePantalla);
btnAnteriorInformacion.addEventListener('click', mostrarPantallaAnterior);

// Función para actualizar el resumen de la cita
function actualizarResumenCita() {
    resumenCita = "";

    // Obtener información seleccionada
    const fechaCita = document.getElementById('fechaCita').value;
    const horaCita = document.getElementById('horaCita').value;
    const barberoSeleccionado = document.getElementById('barberoSeleccionado').value;
    const servicioSeleccionado = document.querySelector('input[name="servicio"]:checked').value;

    // Formatear resumen
    resumenCita += `Fecha: ${fechaCita}\n`;
    resumenCita += `Hora: ${horaCita}\n`;
    resumenCita += `Barbero: ${barberoSeleccionado}\n`;
    resumenCita += `Servicio: ${servicioSeleccionado}`;

    // Mostrar resumen en la pantalla
    const divResumenCita = document.getElementById('resumenCita');
    divResumenCita.textContent = resumenCita;
}

// Al cargar la página
window.onload = function() {
    actualizarResumenCita();
};

// Después de cada cambio en la selección
document.getElementById('fechaCita').addEventListener('change', function() {
    const fecha = this.value;
    if (fecha) {
        obtenerHorariosDisponibles(fecha);
    }
    actualizarResumenCita();
});
document.getElementById('horaCita').addEventListener('change', actualizarResumenCita);
document.getElementById('barberoSeleccionado').addEventListener('change', actualizarResumenCita);
document.querySelectorAll('input[name="servicio"]').forEach(input => {
    input.addEventListener('change', actualizarResumenCita);
});
