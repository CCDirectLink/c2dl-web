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

function registerColorSwitcher(colorSwitcherElements, colorSwitcherIcons, main) {
    for (let colorSwitcher of colorSwitcherElements) {
        colorSwitcher.addEventListener('click', function (element) {
            element.preventDefault();
            element.stopPropagation();

            if (main.classList.contains("c2dl-colorset-system")) {
                switchColorset(colorSwitcherElements, colorSwitcherIcons, main, "c2dl-colorset-system");
            } else if (main.classList.contains("c2dl-colorset-dark")) {
                switchColorset(colorSwitcherElements, colorSwitcherIcons, main, "c2dl-colorset-dark");
            } else {
                switchColorset(colorSwitcherElements, colorSwitcherIcons, main, "c2dl-colorset-light");
            }
        });
    }
}

const colorset_mapping = {
    "c2dl-colorset-system": {
        from: "c2dl-colorset-system",
        to: "c2dl-colorset-dark",
        fromIcon: "c2dl-system-icon",
        toIcon: "c2dl-moon-icon",
        title: {
            en: "Dark colorset"
        },
        cookieTo: "dark",
    },
    "c2dl-colorset-dark": {
        from: "c2dl-colorset-dark",
        to: "c2dl-colorset-light",
        fromIcon: "c2dl-moon-icon",
        toIcon: "c2dl-sun-icon",
        title: {
            en: "Light colorset"
        },
        cookieTo: "light",
    },
    "c2dl-colorset-light": {
        from: "c2dl-colorset-light",
        to: "c2dl-colorset-system",
        fromIcon: "c2dl-sun-icon",
        toIcon: "c2dl-system-icon",
        title: {
            en: "System colorset"
        },
        cookieTo: "system",
    },
};

function switchColorsetIcon(colorSwitcherIcons, from) {
    for (let colorSwitcherIcon of colorSwitcherIcons) {
        colorSwitcherIcon.classList.remove(colorset_mapping[from].fromIcon);
        colorSwitcherIcon.classList.add(colorset_mapping[from].toIcon);
    }
}

function switchColorset(colorSwitcherElements, colorSwitcherIcons, main, from) {
    main.classList.remove(colorset_mapping[from].from);
    main.classList.add(colorset_mapping[from].to);
    document.cookie = "c2dl_colorset=" + colorset_mapping[from].cookieTo + "; Path=/; max-age=31536000; SameSite=strict"

    for (let colorSwitcher of colorSwitcherElements) {
        colorSwitcher.title = colorset_mapping[from].title.en;
    }

    switchColorsetIcon(colorSwitcherIcons, from);
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

function slidingHeader(main, headerLogo, menuBar) {
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
}

function c2dlMain() {
    console.log('CCDirectLink - init');

    let body = document.getElementById('c2dl-body');
    let main = document.getElementById('c2dl-main-app');
    let headerLogo = document.getElementById('c2dl-menu-bar-logo-1');
    let menuBar = document.getElementById('c2dl-menu-bar-nav-1');
    let colorSwitcherElements = document.getElementsByClassName('c2dl-colorset-switcher');
    let colorSwitcherIcons = document.getElementsByClassName('c2dl-colorset-icon');

    //slidingHeader(main, headerLogo, menuBar);
    registerColorSwitcher(colorSwitcherElements, colorSwitcherIcons, body);
}

document.addEventListener('DOMContentLoaded', c2dlMain);
