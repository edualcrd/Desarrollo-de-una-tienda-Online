import { getAuthToken, setAuthData, logout } from './store.js';

// URL base de la API (asumiendo que está en el mismo host)
const API_URL = 'api/'; 

// Función para verificar la autenticación en páginas protegidas
export function checkAuthentication() {
    if (!getAuthToken()) {
        alert('Sesión expirada o no iniciada. Redirigiendo al login.');
        // Usamos logout() para limpiar por si hay datos residuales
        logout(); 
    }
}

// Lógica de Login (Usada en login.html)
export async function handleLogin(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch(API_URL + 'login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // 1. Almacenar Token y Data de la tienda en LocalStorage
            setAuthData(data.token, data.store_data); 
            // 2. Redirigir al Dashboard
            window.location.href = 'dashboard.html'; 
        } else {
            // Maneja 401 (Unauthorized) del PHP
            alert(data.error || 'Login fallido. Verifica tus credenciales.');
        }

    } catch (error) {
        // Maneja errores de red o el código 500 (Internal Server Error)
        console.error('Error de red durante el login o fallo de servidor:', error);
        alert('Ocurrió un error al intentar iniciar sesión. Verifique la consola o el log del servidor.');
    }
}