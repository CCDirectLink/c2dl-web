import path from 'path';
import { generate_font } from './generate_font.js';

const rootPath = path.resolve(process.cwd());

// Note: Can be different versions then builder version
const fonts = [
    {
        fontName: 'c2dl-iconic',
        fontVersion: '1.1.0'
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
        startUnicode: 0xea00,
        logo: path.resolve(rootPath, 'assets', 'logo.svg'),
        favicon: path.resolve(rootPath, 'assets', 'favicon.png'),
        github: 'https://github.com/CCDirectLink/c2dl-web',
        footer: 'Licensed under MIT',
        license: 'MIT',
        author: 'CCDirectLink',
    };
}

const _results = fonts
    .map(entry => generate_config(entry))
    .map(config => generate_font(config))

Promise.all(_results)
.then(() => {
    console.log('Builds finished');
});
