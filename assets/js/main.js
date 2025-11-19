import { getAuthToken, setAuthData, logout } from '/Desarrollo-de-una-tienda-Online/assets/js/store.js';

// URL base de la API (asumiendo que está en el mismo host)
const API_URL = '/Desarrollo-de-una-tienda-Online/api/'; 

// Función para verificar la autenticación en páginas protegidas
function checkAuthentication() {
    if (!getAuthToken()) {
        alert('Sesión expirada o no iniciada. Redirigiendo al login.');
        window.location.href = '/Desarrollo-de-una-tienda-Online/login.html';
    }
}

// Lógica de Login (Usada en login.html)
export async function handleLogin(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch(API_URL + '/Desarrollo-de-una-tienda-Online/api/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // 1. Almacenar Token y Data de la tienda en LocalStorage [cite: 65, 169]
            setAuthData(data.token, data.store_data); 
            // 2. Redirigir al Dashboard [cite: 66]
            window.location.href = '/Desarrollo-de-una-tienda-Online/dashboard.html'; 
        } else {
            alert(data.error || 'Login fallido. Verifica tus credenciales.');
        }

    } catch (error) {
        console.error('Error de red durante el login:', error);
        alert('Ocurrió un error al intentar iniciar sesión.');
    }
}

// Configuración inicial al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    
    if (body.classList.contains('login-page')) {
        // En la página de login, configurar el manejador del formulario
        const loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', handleLogin);
        }
    } else {
        // En páginas protegidas, verificar la autenticación
        checkAuthentication(); 
        
        // Configurar el botón de cerrar sesión
        const logoutBtn = document.getElementById('logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', logout);
        }
    }
});