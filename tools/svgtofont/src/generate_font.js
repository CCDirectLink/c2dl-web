// noinspection SpellCheckingInspection
import svgtofont from 'svgtofont';

export async function generate_font(config) {

    console.log(
        `Generate font '${config.fontName}' with config:` +
        `\n${JSON.stringify(config, null, 2)}`)

    // noinspection SpellCheckingInspection
    return await svgtofont({
        src: config.inputPath,
        dist: config.outputPath,
        fontName: config.fontName,
        css: true,
        outSVGReact: true,
        outSVGPath: true,
        startUnicode: config.startUnicode,
        getIconUnicode: (name, unicode, startUnicode) => {
            const _nameSplit = name.split('-');
            const _unicodeLocation = parseInt(_nameSplit[0], 16);
            return String.fromCharCode(_unicodeLocation);
        },
        svgicons2svgfont: {
            fontHeight: 1000,
            normalize: true
        },
        typescript: true,
        svg2ttf: {
            version: config.shortVersion,
        },
        website: {
            corners: {
                url: config.github,
                width: 60,
                height: 60,
                bgColor: '#151513'
            },
            index: "unicode",
            title: config.fontName,
            favicon: config.favicon,
            logo: config.logo,
            version: config.version,
            meta: {
                description: config.description,
                keywords: "C2DL,Icon,TTF,EOT,WOFF,WOFF2,SVG"
            },
            description: ``,
            links: [
                {
                    title: "GitHub",
                    url: config.github
                },
                {
                    title: "Feedback",
                    url: [config.github, 'issues'].join('/'),
                },
                {
                    title: "Font Class",
                    url: "font-class.html"
                },
                {
                    title: "Symbol",
                    url: "symbol.html"
                },
                {
                    title: "Unicode",
                    url: "index.html"
                }
            ],
            footerInfo: config.footer
        }
    });
}
