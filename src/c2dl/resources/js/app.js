function isVisible(elem, win) {
    if (!win) {
        win = window;
    }
    if (typeof win.getComputedStyle === 'undefined') {
        return false;
    }
    let display = win.getComputedStyle(elem).getPropertyValue('display');
    if (display === 'none') {
        return false;
    }
    let visibility = win.getComputedStyle(elem).getPropertyValue('visibility');
    return visibility !== 'hidden';
}

function motionReduced(win) {
    if (!win) {
        win = window;
    }
    if (typeof win.matchMedia === 'undefined') {
        return false;
    }
    return win.matchMedia("(prefers-reduced-motion: reduce)").matches;
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('CCDirectLink - init');

    let main = document.getElementById('c2dl-main-app');

    let headerLogo = document.getElementById('c2dl-menu-bar-logo-1');
    let menuBar = document.getElementById('c2dl-menu-bar-nav-1');

    let headerResizeHandler = () => {
        let pos = main.scrollTop;

        if (pos > 150) {
            headerLogo.style.width = '3em';
            headerLogo.style.height = '3em';
        }
        else {
            let visible = isVisible(menuBar);

            let size = 3;
            if (((0.02 * pos) <= 3) && (visible) && (!motionReduced())) {
                size = 6 - (0.02 * pos);
            }

            headerLogo.style.width = `${size}em`;
            headerLogo.style.height = `${size}em`;
        }
    };

    if (main.addEventListener) {
        main.addEventListener('scroll', () => {
            headerResizeHandler();
        });
    }
    if (window.addEventListener) {
        window.addEventListener('resize', () => {
            headerResizeHandler();
        });
    }
});
