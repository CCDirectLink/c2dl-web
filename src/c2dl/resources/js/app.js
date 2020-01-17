function isVisible(elem, win) {
    if (!win) {
        win = window;
    }
    let display = win.getComputedStyle(elem).getPropertyValue('display');
    if (display === 'none') {
        return false;
    }
    let visibility = win.getComputedStyle(elem).getPropertyValue('visibility');
    return visibility !== 'hidden';
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
            if (((0.02 * pos) <= 3) && (visible)) {
                size = 6 - (0.02 * pos);
            }

            headerLogo.style.width = `${size}em`;
            headerLogo.style.height = `${size}em`;
        }
    };

    main.addEventListener('scroll', () => {
        headerResizeHandler();
    });
    window.addEventListener('resize', () => {
        headerResizeHandler();
    });
});
