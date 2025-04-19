document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const passwordInput = document.getElementById('password');
    const passwordStrength = document.querySelector('.password-strength');
    
    // Toggle password visibility
    const togglePassword = document.querySelector('.toggle-password');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const icon = this.querySelector('span');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                icon.textContent = 'visibility';
            }
        });
    }
    
    // Validación de fortaleza de contraseña
    if (passwordInput && passwordStrength) {
        passwordInput.addEventListener('input', function() {
            const strength = calculatePasswordStrength(this.value);
            const strengthBar = passwordStrength.querySelector('::after');
            
            passwordStrength.style.setProperty('--strength-width', strength.width + '%');
            passwordStrength.style.setProperty('--strength-color', strength.color);
        });
    }
    
    // Validación del formulario
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validaciones
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = passwordInput.value;
            const passwordConfirm = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;
            
            // Validar campos vacíos
            if (!name || !email || !password || !passwordConfirm) {
                alert('Por favor completa todos los campos');
                return;
            }
            
            // Validar contraseñas coincidentes
            if (password !== passwordConfirm) {
                alert('Las contraseñas no coinciden');
                return;
            }
            
            // Validar términos
            if (!terms) {
                alert('Debes aceptar los términos y condiciones');
                return;
            }
            
            // Simular envío (en producción sería una petición AJAX o form submission)
            console.log('Datos de registro:', { name, email, password });
            alert('Registro exitoso (simulación)');
            
            // Redirigir al login
            window.location.href = "{{ route('login') }}";
        });
    }
    
    // Calcular fortaleza de contraseña
    function calculatePasswordStrength(password) {
        let strength = 0;
        
        // Longitud mínima
        if (password.length >= 8) strength += 20;
        if (password.length >= 12) strength += 20;
        
        // Complejidad
        if (/[A-Z]/.test(password)) strength += 20;
        if (/[0-9]/.test(password)) strength += 20;
        if (/[^A-Za-z0-9]/.test(password)) strength += 20;
        
        // Limitar a 100%
        strength = Math.min(strength, 100);
        
        // Determinar color
        let color;
        if (strength < 40) color = 'var(--error)';
        else if (strength < 70) color = 'orange';
        else color = 'var(--success)';
        
        return { width: strength, color };
    }
});