import './bootstrap';
import 'preline';

// In modern Vite setups, module scripts load asynchronously. 
// Preline's built-in `load` event listener might fail if the page finishes loading before `app.js` executes.
// This ensures `HSStaticMethods.autoInit()` always runs.
const initPreline = () => {
    if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
        window.HSStaticMethods.autoInit();
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPreline);
} else {
    // DOM already loaded, initialize immediately (or after a tick to ensure Preline is ready)
    setTimeout(initPreline, 100);
}
