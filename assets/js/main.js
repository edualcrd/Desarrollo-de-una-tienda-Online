import { checkAuthentication, handleLogin } from './auth.js';
import { logout } from './store.js';

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