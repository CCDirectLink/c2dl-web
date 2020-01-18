const { spawn } = require('child_process');
let argv = require('minimist')(process.argv.slice(2));

function runDevServer(host, port)
{
	const command = `php -S ${host}:${port}`;
	const options = { cwd: 'public/www-c2dl/', shell: true, stdio: 'inherit' };

	console.log('Starting server...');

	spawn(command, [], options);

}

let port = '8000';
let host = 'localhost'

console.log(argv);

if (argv['port']) {
	port = argv['port'];
}

if (argv['host']) {
	host = argv['host'];
}

runDevServer(host, port);
