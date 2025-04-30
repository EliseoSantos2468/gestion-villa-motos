document.addEventListener('DOMContentLoaded', function() {
    // =============================================
    // 1. VALIDACIÓN DE CAMPOS
    // =============================================
    
    // Seleccionar el formulario
    const form = document.querySelector('form');
     // Formateo automático de campos
     document.getElementById('dui_cliente').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 8) {
            value = value.substring(0, 8) + '-' + value.substring(8, 9);
        }
        e.target.value = value.substring(0, 10);
    });
    
    document.getElementById('nit_cliente').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.substring(0, 4) + '-' + value.substring(4);
        if (value.length > 11) value = value.substring(0, 11) + '-' + value.substring(11);
        if (value.length > 15) value = value.substring(0, 15) + '-' + value.substring(15);
        e.target.value = value.substring(0, 17);
    });
    
    document.getElementById('telefono_cliente').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) {
            value = value.substring(0, 4) + '-' + value.substring(4);
        }
        e.target.value = value.substring(0, 9);
    });
    
    document.querySelector('.telefono-referenciaA').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) {
            value = value.substring(0, 4) + '-' + value.substring(4);
        }
        e.target.value = value.substring(0, 9);
    });
    // Expresiones regulares para validación
    const patterns = {
        nombres: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,}$/,
        dui: /^\d{8}-\d{1}$/,
        nit: /^\d{4}-\d{6}-\d{3}-\d{1}$/,
        telefono: /^\d{4}-\d{4}$/,
        email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        barrio: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,-]{3,}$/
    };
    
    // Validar campo al perder el foco
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name || field.id;
        
        if (field.required && !value) {
            showError(field, 'Este campo es requerido');
            return false;
        }
        
        switch(fieldName) {
            case 'nombres_cliente':
            case 'apellidos_cliente':
                if (!patterns.nombres.test(value)) {
                    showError(field, 'Solo letras y espacios (mínimo 3 caracteres)');
                    return false;
                }
                break;
            case 'dui_cliente':
                if (!patterns.dui.test(value)) {
                    showError(field, 'Formato inválido (00000000-0)');
                    return false;
                }
                break;
            case 'nit_cliente':
                if (!patterns.nit.test(value)) {
                    showError(field, 'Formato inválido (0000-000000-000-0)');
                    return false;
                }
                break;
            case 'telefono_cliente':
                if (!patterns.telefono.test(value)) {
                    showError(field, 'Formato inválido (0000-0000)');
                    return false;
                }
                break;
            case 'email_cliente':
                if (!patterns.email.test(value)) {
                    showError(field, 'Correo electrónico inválido');
                    return false;
                }
                break;
            case 'barrio':
                if (!patterns.barrio.test(value)) {
                    showError(field, 'Mínimo 3 caracteres (símbolos no permitidos)');
                    return false;
                }
                break;
            case 'monto_max':
                if (isNaN(value) || value <= 0) {
                    showError(field, 'Debe ser un número positivo');
                    return false;
                }
                break;
        }
        
        clearError(field);
        return true;
    }
    
    // Mostrar error en un campo
    function showError(field, message) {
        clearError(field);
        field.classList.add('is-invalid');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }
    
    // Limpiar error de un campo
    function clearError(field) {
        field.classList.remove('is-invalid');
        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
    
    // Event listeners para validación en tiempo real
    const fieldsToValidate = [
        'nombres_cliente', 'apellidos_cliente', 'dui_cliente', 
        'nit_cliente', 'email_cliente', 'telefono_cliente', 
        'barrio', 'monto_max'
    ];
    
    fieldsToValidate.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('blur', () => validateField(field));
            field.addEventListener('input', () => {
                if (field.classList.contains('is-invalid')) {
                    validateField(field);
                }
            });
        }
    });
    
    // Validación de selects
    const selectsToValidate = ['id_clasificacion', 'id_departamento', 'id_municipio'];
    
    selectsToValidate.forEach(selectName => {
        const select = document.querySelector(`[name="${selectName}"]`);
        if (select) {
            select.addEventListener('change', () => {
                if (select.required && !select.value) {
                    showError(select, 'Este campo es requerido');
                } else {
                    clearError(select);
                }
            });
        }
    });
    
    // =============================================
    // 2. MANEJO DE REFERENCIAS
    // =============================================
    
    let referenciasCount = 0;
    const referenciasIniciales = JSON.parse(document.getElementById('referencias-data').textContent || '[]');
    const listaReferencias = document.getElementById('referencias-listaA');
    
    // Función para crear una referencia
    function crearReferencia(nombre, telefono, id = null) {
        const referenciaDiv = document.createElement('div');
        referenciaDiv.className = 'referencia-item mb-2 p-2 border rounded';
        
        // Inputs ocultos
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = `referencias[${referenciasCount}][id]`;
        inputId.value = id || '';
        
        const inputNombre = document.createElement('input');
        inputNombre.type = 'hidden';
        inputNombre.name = `referencias[${referenciasCount}][nombre_ref]`;
        inputNombre.value = nombre;
        
        const inputTelefono = document.createElement('input');
        inputTelefono.type = 'hidden';
        inputTelefono.name = `referencias[${referenciasCount}][telefono_ref]`;
        inputTelefono.value = telefono;
        
        // Elemento visible
        const texto = document.createElement('span');
        texto.className = 'me-2';
        texto.textContent = `${nombre} - ${telefono}`;
        
        // Botón eliminar
        const botonEliminar = document.createElement('button');
        botonEliminar.type = 'button';
        botonEliminar.className = 'btn btn-sm btn-danger ms-auto'; // ms-auto empuja a la derecha
        botonEliminar.innerHTML = '<span class="material-symbols-rounded">delete</span> Eliminar';
        botonEliminar.addEventListener('click', () => referenciaDiv.remove());
        
        referenciaDiv.appendChild(texto);
        referenciaDiv.appendChild(botonEliminar);
        referenciaDiv.appendChild(inputId);
        referenciaDiv.appendChild(inputNombre);
        referenciaDiv.appendChild(inputTelefono);
        
        listaReferencias.appendChild(referenciaDiv);
        referenciasCount++;
    }
    
    // Cargar referencias existentes
    function cargarReferenciasExistentes() {
        if (Array.isArray(referenciasIniciales)) {
            referenciasIniciales.forEach(ref => {
                if (ref.nombre_ref && ref.telefono_ref) {
                    crearReferencia(ref.nombre_ref, ref.telefono_ref, ref.id);
                }
            });
        }
    }
    
    // Agregar nueva referencia
    document.querySelector('.add-referenciaA').addEventListener('click', function() {
        const nombre = document.querySelector('.nombre-referenciaA').value.trim();
        const telefono = document.querySelector('.telefono-referenciaA').value.trim();
        
        if (!nombre || !telefono) {
            alert('Por favor complete ambos campos de referencia');
            return;
        }
        
        if (!/^\d{4}-\d{4}$/.test(telefono)) {
            alert('Formato de teléfono inválido (0000-0000)');
            return;
        }
        
        crearReferencia(nombre, telefono);
        document.querySelector('.nombre-referenciaA').value = '';
        document.querySelector('.telefono-referenciaA').value = '';
    });

    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validar campos normales
        fieldsToValidate.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field && !validateField(field)) {
                isValid = false;
            }
        });
        
        // Validar selects
        selectsToValidate.forEach(selectName => {
            const select = document.querySelector(`[name="${selectName}"]`);
            if (select && select.required && !select.value) {
                showError(select, 'Este campo es requerido');
                isValid = false;
            }
        });
        
        // Validar al menos una referencia
        if (listaReferencias.children.length === 0) {
            alert('Debe agregar al menos una referencia');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor corrija los errores en el formulario');
        }
    });
    
    // =============================================
    // 5. INICIALIZACIÓN
    // =============================================
    
    cargarReferenciasExistentes();
    
   
});