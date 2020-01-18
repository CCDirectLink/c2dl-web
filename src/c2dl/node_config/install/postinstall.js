function _checkExist(file) {

}

function _validateNodeInstallation(dir, validator) {

}

function _checkComposer() {

}

function _validateComposerInstallation() {

}

function _environmentSetup() {

}

function _webpackBuild() {

}

function _init(param) {

}

const { spawn } = require('child_process');
const options = { shell: true, stdio: 'inherit' };

const composerInstall = 'composer install';
const devInstall = 'npm run dev';

spawn(composerInstall, [], options);
spawn(devInstall, [], options);
