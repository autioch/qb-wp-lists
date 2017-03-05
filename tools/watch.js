const cpx = require('cpx');
const target = require('./target');
const path = require('path');
const qbLog = require('qb-log')('simple');

const source = path.join(__dirname, '..', 'src', '**', '*');

qbLog({
  copy: {
    prefix: 'COPY',
    formatter: qbLog._chalk.green
  },
  remove: {
    prefix: 'REMOVE',
    formatter: qbLog._chalk.yellow
  },
  target: {
    prefix: 'TARGET',
    formatter: qbLog._chalk.cyan
  }
});

qbLog.target(target);
const watcher = cpx.watch(source, target, {});

watcher.on('copy', (ev) => qbLog.copy(ev.srcPath));
watcher.on('remove', (ev) => qbLog.remove(ev.path));
watcher.on('watch-error', (err) => qbLog.error(err.message));
watcher.on('watch-ready', () => {
  qbLog.info('Watching for changes...');
  qbLog.target(target);
});
