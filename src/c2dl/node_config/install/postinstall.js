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

const dotenv = require('dotenv');
const envConfig = dotenv.config();

const { spawn } = require('child_process');
const options = { shell: true, stdio: 'inherit' };

const composerInstall = 'composer install';
const devInstall = 'npm run dev';
const prodInstall = 'npm run production';

spawn(composerInstall, [], options);

let prodEnvironment = true;

if ((!envConfig.error) && (typeof envConfig.parsed.NODE_ENV === 'string') && (envConfig.parsed.NODE_ENV === 'development')) {
	prodEnvironment = false;
}

if (prodEnvironment) {
	spawn(prodInstall, [], options);
}
else {
	spawn(devInstall, [], options);
}
