import path from 'path';
import { generate_font } from './generate_font.js';

const rootPath = path.resolve(process.cwd());

// Note: Can be different versions then builder version
const fonts = [
    {
        fontName: 'c2dl-iconic',
        fontVersion: '2.0.0',
        origin: 'Phosphor Icons'
    }
]

function generate_config(fontEntry) {
    const _fontName = fontEntry.fontName;
    const _fontVersion = fontEntry.fontVersion;

    return {
        version: _fontVersion,
        shortVersion: _fontVersion.replace(/\.[^.]+$/, ''),
        inputPath: path.resolve(rootPath, 'svg', _fontName),
        outputPath: path.resolve(rootPath, 'fonts', _fontName),
        fontName: _fontName,
        description: 'C2DL icon font',
        startUnicode: fontEntry.startUnicode ?? 0xEA00,
        logo: path.resolve(rootPath, 'assets', 'logo.svg'),
        favicon: path.resolve(rootPath, 'assets', 'favicon.png'),
        github: 'https://github.com/CCDirectLink/c2dl-web',
        footer: 'Licensed under MIT',
        license: 'MIT',
        author: fontEntry.origin + ' (Icons) and CCDirectLink (Font composition)',
    };
}

// Note: svgtofont can not be executed in parallel - not thread safe
async function generate_all_fonts(configs) {
    for (const config of configs) {
        await generate_font(config);
    }
}

generate_all_fonts(fonts
    .map(entry => generate_config(entry)))
    .then(() => console.log('Builds finished'));
