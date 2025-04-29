document.addEventListener('DOMContentLoaded', function() {

    const camposRequeridos = document.querySelectorAll('input[required], select[required]');
    camposRequeridos.forEach(campo => {
        campo.addEventListener('input', function() {
            if (campo.value.trim() === '') {
                campo.classList.add('is-invalid');
            } else {
                campo.classList.remove('is-invalid');
            }
        });
    });

    const editarClienteModal = document.getElementById('editarClienteModal');
  editarClienteModal.addEventListener('show.bs.modal', function (event) {
    // Obtén los datos del cliente
    const button = event.relatedTarget;
    const clienteId = button.getAttribute('data-id');
    const nombres = button.getAttribute('data-nombres');
    const apellidos = button.getAttribute('data-apellidos');
    const dui = button.getAttribute('data-dui');
    const nit = button.getAttribute('data-nit');
    const idDepartamento = button.getAttribute('data-id_departamento');
    const departamentoSelect = document.getElementById('departamentoSelectE');
    const idMunicipio = button.getAttribute('data-id_municipio');
    departamentoSelect.value = idDepartamento;
    const email = button.getAttribute('data-email');
    const telefono = button.getAttribute('data-telefono');
    const barrio = button.getAttribute('data-barrio');

    // logica para visualizar las referencias
    
    const referenciasData = button.getAttribute('data-referencias');
    console.log('Referencias RAW:', referenciasData);
    const referencias = referenciasData ? JSON.parse(referenciasData) : [];
    console.log('Referencias JSON:', referencias);

    const referenciasLista = document.getElementById('referencias-listaA');
    referenciasLista.innerHTML = ''; // Limpiar antes de agregar (por si ya había)

    // Contador para los inputs
    let referenciasCount = 0;

    referencias.forEach(referencia => {
        const nombreReferencia = referencia.nombre_ref;
        const telefonoReferencia = referencia.telefono_ref;
    
        const wrapper = document.createElement('div');
        wrapper.classList.add('mb-2', 'd-flex', 'justify-content-between', 'align-items-center', 'border', 'p-2', 'rounded');
    
        // Texto visible
        const label = document.createElement('span');
        label.textContent = `Nombre: ${nombreReferencia}, Tel: ${telefonoReferencia}`;
    
        // Botón de eliminar
        const botonEliminar = document.createElement('button');
        botonEliminar.type = 'button';
        botonEliminar.className = 'btn btn-sm btn-danger';
        botonEliminar.textContent = 'Eliminar';
    
        botonEliminar.addEventListener('click', function () {
            referenciasLista.removeChild(wrapper);
        });
    
        // Inputs ocultos
        const inputNombre = document.createElement('input');
        inputNombre.type = 'hidden';
        inputNombre.name = `referencias[${referenciasCount}][nombre_ref]`;
        inputNombre.value = nombreReferencia;
    
        const inputTelefono = document.createElement('input');
        inputTelefono.type = 'hidden';
        inputTelefono.name = `referencias[${referenciasCount}][telefono_ref]`;
        inputTelefono.value = telefonoReferencia;
    
        // Ensamblar
        wrapper.appendChild(label);
        wrapper.appendChild(botonEliminar);
        wrapper.appendChild(inputNombre);
        wrapper.appendChild(inputTelefono);
    
        referenciasLista.appendChild(wrapper);
        referenciasCount++;
    });
    
    // Rellena los campos del formulario con los datos del cliente
    document.getElementById('cliente-id').value = clienteId;

    document.getElementById('nombres_cliente').value = nombres;
    document.getElementById('apellidos_cliente').value = apellidos;
    document.getElementById('dui_cliente').value = dui;
    document.getElementById('nit_cliente').value = nit;
    document.getElementById('departamentoSelectE').value = idDepartamento;
    departamentoSelect.dispatchEvent(new Event('change'));
    document.getElementById('municipioSelectE').value = idMunicipio;
    document.getElementById('email_cliente').value = email;
    document.getElementById('telefono_cliente').value = telefono;
    document.getElementById('barrio').value = barrio;
  });

    // Sistema de notificaciones
    function mostrarNotificacion(mensaje, tipo, duracion = 5000) {
        // Crear elemento de notificación
        const notificacion = document.createElement('div');
        notificacion.className = `alert alert-${tipo} notification-alert`;
        notificacion.innerHTML = mensaje;
        notificacion.style.position = 'fixed';
        notificacion.style.top = '20px';
        notificacion.style.right = '20px';
        notificacion.style.zIndex = '9999';
        notificacion.style.minWidth = '300px';
        notificacion.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        notificacion.style.transition = 'opacity 0.5s ease-in-out';
        
        // Añadir botón de cierre
        const closeButton = document.createElement('button');
        closeButton.type = 'button';
        closeButton.className = 'btn-close';
        closeButton.setAttribute('aria-label', 'Cerrar');
        closeButton.style.position = 'absolute';
        closeButton.style.right = '10px';
        closeButton.style.top = '10px';
        
        closeButton.addEventListener('click', function() {
            document.body.removeChild(notificacion);
        });
        
        notificacion.appendChild(closeButton);
        document.body.appendChild(notificacion);
        
        // Establecer temporizador para eliminar la notificación
        setTimeout(function() {
            notificacion.style.opacity = '0';
            setTimeout(function() {
                if (document.body.contains(notificacion)) {
                    document.body.removeChild(notificacion);
                }
            }, 500);
        }, duracion);
    }
    
    // Procesar notificaciones de sesión de Laravel existentes
    const procesarNotificacionesExistentes = () => {
        // Buscar alertas de éxito
        const alertasExito = document.querySelectorAll('.alert-success');
        alertasExito.forEach(alerta => {
            const mensaje = alerta.textContent.trim();
            alerta.remove(); // Eliminar la alerta estática
            mostrarNotificacion(mensaje, 'success');
        });
        
        // Buscar alertas de error
        const alertasError = document.querySelectorAll('.alert-danger');
        alertasError.forEach(alerta => {
            const mensaje = alerta.textContent.trim();
            alerta.remove(); // Eliminar la alerta estática
            mostrarNotificacion(mensaje, 'danger');
        });
        
        // Buscar alertas de advertencia
        const alertasWarning = document.querySelectorAll('.alert-warning');
        alertasWarning.forEach(alerta => {
            const mensaje = alerta.textContent.trim();
            alerta.remove(); // Eliminar la alerta estática
            mostrarNotificacion(mensaje, 'warning');
        });
    };
    
    // Ejecutar al cargar la página
    procesarNotificacionesExistentes();
    
    // Exponer la función de mostrar notificación globalmente
    window.mostrarNotificacion = mostrarNotificacion;

    // Formateo automático de DUI
    document.querySelector('input[name="dui_cliente"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 8) {
            value = value.substring(0, 8) + '-' + value.substring(8, 9);
        }
        e.target.value = value.substring(0, 10);
    });

    // Formateo automático de NIT
    document.querySelector('input[name="nit_cliente"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            // Formatear NIT: 0000-000000-000-0
            if (value.length > 4) {
                value = value.substring(0, 4) + '-' + value.substring(4);
            }
            if (value.length > 11) {
                value = value.substring(0, 11) + '-' + value.substring(11);
            }
            if (value.length > 15) {
                value = value.substring(0, 15) + '-' + value.substring(15);
            }
        }
        e.target.value = value.substring(0, 17);
    });

    // Formateo automático de teléfono
    document.querySelector('input[name="telefono_cliente"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) {
            value = value.substring(0, 4) + '-' + value.substring(4);
        }
        e.target.value = value.substring(0, 9);
    });

    // Validación para nombres y apellidos (solo letras)
    document.querySelector('input[name="nombres_cliente"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        e.target.value = value;
    });

    document.querySelector('input[name="apellidos_cliente"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        e.target.value = value;
    });

    // Formateo automático para teléfono de referencia
    document.querySelector('.telefono-referencia').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) {
            value = value.substring(0, 4) + '-' + value.substring(4);
        }
        e.target.value = value.substring(0, 9);
    });

});