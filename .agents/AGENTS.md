# Laravel Vite & Preline UI v4 Rules

## Preline Initialization with Vite
When using Preline UI v4 in a Laravel project using Vite (`app.js` with deferred module loading), Preline's default `window.addEventListener('load')` often fails to fire because the DOM might finish loading before the script executes. 

**Rule:** Always enforce a robust initialization in `resources/js/app.js`:
```javascript
import './bootstrap';
import 'preline';

const initPreline = () => {
    if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
        window.HSStaticMethods.autoInit();
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPreline);
} else {
    setTimeout(initPreline, 100);
}
```

## Dynamically Filtering Preline HSSelect
Preline's Advanced Select (`HSSelect`) extracts native `<option>` elements to build a custom UI. Setting `style.display = 'none'` on native `<option>` elements does not update the custom Preline UI once it is initialized.

**Rule:** To dynamically update or filter dropdown options in a Preline `HSSelect` component, you must completely rebuild the DOM wrapper to destroy ghost elements, insert a fresh `<select>` element with the desired `<option>` elements, and then re-initialize Preline.

Example workflow:
1. Store the full list of options (e.g. `allCategories`) locally via `@json` in a script block.
2. When a filter changes, wipe the entire `wrapper.innerHTML` of the container holding the `<label>` and the `<select>`.
3. Rebuild the string containing the `<select>` element and only the matching `<option>`s.
4. Set the `innerHTML` of the wrapper to this new string.
5. Call `setTimeout(() => window.HSStaticMethods.autoInit(), 10)` to allow the browser to parse the new HTML before re-initializing Preline.
