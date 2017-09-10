const cpx = require('cpx');
const path = require('path');
const { qbLog, config, copyHtaccess, saveBuildTime } = require('./utils');
const { source, target, extensions } = config;

qbLog.target(target);

const watchedFiles = path.join(source, '**', `*.{${extensions.join(',')}}`);

const watcher = cpx.watch(watchedFiles, target, {});

watcher.on('copy', (ev) => qbLog.copy(ev.srcPath));
watcher.on('remove', (ev) => qbLog.remove(ev.path));
watcher.on('watch-error', (err) => qbLog.error(err.message));
watcher.on('watch-ready', () => {
  qbLog.info('Watching for changes...');
  qbLog.target(target);
  copyHtaccess().then(saveBuildTime);
});
