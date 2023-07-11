const path = require('path');
const pkg = require('../package.json');
const generate_font = require("./generate_font");
const rootPath = path.resolve(process.cwd());
const fontName = 'c2dl-iconic';
// can be != tool version (package.json)
const fontVersion = '1.0.0';

const config = {
    version: fontVersion,
    shortVersion: fontVersion.replace(/\.[^.]+$/, ''),
    inputPath: path.resolve(rootPath, 'svg', fontName),
    outputPath: path.resolve(rootPath, 'fonts', fontName),
    fontName: fontName,
    description: 'C2DL icon font',
    startUnicode: 0xea00,
    logo: path.resolve(rootPath, 'assets', 'logo.svg'),
    favicon: path.resolve(rootPath, 'assets', 'favicon.png'),
    github: 'https://github.com/CCDirectLink/c2dl-web',
    footer: 'Licensed under MIT',
    license: 'MIT',
    author: 'CCDirectLink',
};

generate_font(config)
.then(() => {
    console.log('Build finished');
});
