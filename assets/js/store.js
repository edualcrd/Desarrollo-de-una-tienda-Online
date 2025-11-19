// Claves para LocalStorage
const STORAGE_KEYS = {
    TOKEN: 'authToken',
    STORE_DATA: 'storeData',
    CART: 'cart',
    RECENT_VIEWS: 'recentViews'
};

// --- GETTERS ---
export function getAuthToken() {
    return localStorage.getItem(STORAGE_KEYS.TOKEN);
}

export function getStoreData() {
    const data = localStorage.getItem(STORAGE_KEYS.STORE_DATA);
    return data ? JSON.parse(data) : { categorias: [], productos: [] };
}

export function getProductById(id) {
    const { productos } = getStoreData();
    return productos.find(p => p.id === parseInt(id));
}

export function getCart() {
    const cart = localStorage.getItem(STORAGE_KEYS.CART);
    return cart ? JSON.parse(cart) : [];
}

export function getRecentViews() {
    const views = localStorage.getItem(STORAGE_KEYS.RECENT_VIEWS);
    return views ? JSON.parse(views) : [];
}

// --- SETTERS / MODIFIERS ---
export function setAuthData(token, storeData) {
    localStorage.setItem(STORAGE_KEYS.TOKEN, token);
    localStorage.setItem(STORAGE_KEYS.STORE_DATA, JSON.stringify(storeData));
}

export function addToCart(product, quantity = 1) {
    let cart = getCart();
    const existing = cart.find(item => item.id === product.id);
    
    if (existing) {
        existing.quantity += quantity;
    } else {
        // Aseguramos que solo guardamos datos esenciales para la validación (id, nombre, precio)
        cart.push({ 
            id: product.id, 
            nombre: product.nombre, 
            precio: product.precio, 
            quantity: quantity 
        });
    }

    localStorage.setItem(STORAGE_KEYS.CART, JSON.stringify(cart));
    alert(`${product.nombre} añadido al carrito.`);
}

export function updateCartQuantity(productId, quantity) {
    let cart = getCart();
    const item = cart.find(i => i.id === productId);

    if (item) {
        item.quantity = quantity;
        if (item.quantity <= 0) {
            cart = cart.filter(i => i.id !== productId); // Eliminar si la cantidad es 0
        }
    }
    localStorage.setItem(STORAGE_KEYS.CART, JSON.stringify(cart));
}

export function clearCart() {
    localStorage.removeItem(STORAGE_KEYS.CART);
}

// Productos Vistos Recientemente
export function addRecentView(productId) {
    let views = getRecentViews();
    
    // Eliminar si ya existe y añadir al principio
    views = views.filter(id => id !== productId);
    views.unshift(productId); 
    
    // Limitar el historial
    if (views.length > 5) {
        views.pop();
    }

    localStorage.setItem(STORAGE_KEYS.RECENT_VIEWS, JSON.stringify(views));
}

// Cierre de sesión (Limpieza total de LocalStorage)
export function logout() {
    localStorage.removeItem(STORAGE_KEYS.TOKEN);
    localStorage.removeItem(STORAGE_KEYS.STORE_DATA);
    localStorage.removeItem(STORAGE_KEYS.RECENT_VIEWS);
    localStorage.removeItem(STORAGE_KEYS.CART);
    window.location.href = '/Desarrollo-de-una-tienda-Online/login.html';
}