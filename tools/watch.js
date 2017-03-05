const cpx = require('cpx');
const target = require('./target');
const path = require('path');
const qbLog = require('qb-log')('simple');

const source = path.join(__dirname, '..', 'src', '**', '*');

qbLog.info('Watching will copy files from to:');
qbLog.empty(source);
qbLog.empty(target);

qbLog({
  copy: {
    prefix: 'COPY',
    formatter: qbLog._chalk.green
  },
  remove: {
    prefix: 'REMOVE',
    formatter: qbLog._chalk.yellow
  }
});

const watcher = cpx.watch(source, target, {});

watcher.on('copy', (ev) => qbLog.copy(ev.srcPath));
watcher.on('remove', (ev) => qbLog.remove(ev.path));
watcher.on('watch-raedy', () => qbLog.info('Starting watch'));
watcher.on('watch-error', (err) => qbLog.error(err.message));
