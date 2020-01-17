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

const { exec } = require('child_process');

exec('composer install', (err, stdout, stderr) => {
  if (err) {
    //some err occurred
    console.error(err)
  } else {
   // the *entire* stdout and stderr (buffered)
   console.log(`stdout: ${stdout}`);
   console.log(`stderr: ${stderr}`);
  }
});
exec('npm run dev', (err, stdout, stderr) => {
  if (err) {
    //some err occurred
    console.error(err)
  } else {
   // the *entire* stdout and stderr (buffered)
   console.log(`stdout: ${stdout}`);
   console.log(`stderr: ${stderr}`);
  }
});