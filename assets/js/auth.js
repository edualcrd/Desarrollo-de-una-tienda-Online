import { setAuthData } from '/Desarrollo-de-una-tienda-Online/assets/js/store.js';

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }
});

async function handleLogin(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('/Desarrollo-de-una-tienda-Online/api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username, password })
        });

        const data = await response.json();

        if (data.success) {
            [cite_start]// 1. Almacenar Token y Data de la tienda [cite: 65, 169]
            setAuthData(data.token, data.store_data); 
            [cite_start]// 2. Redirigir al Dashboard [cite: 66]
            window.location.href = '/Desarrollo-de-una-tienda-Online/dashboard.html'; 
        } else {
            alert(data.error || 'Login fallido. Verifica tus credenciales.');
        }

    } catch (error) {
        console.error('Error de red durante el login:', error);
        alert('Ocurrió un error al intentar iniciar sesión.');
    }
}