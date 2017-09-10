const cpx = require('cpx');
const { qbLog, config: { target }, cpx: { selection } } = require('./utils');

qbLog.target(target);

const watcher = cpx.watch(selection, target, {});

watcher.on('copy', (ev) => qbLog.copy(ev.srcPath));
watcher.on('remove', (ev) => qbLog.remove(ev.path));
watcher.on('watch-error', (err) => qbLog.error(err.message));
watcher.on('watch-ready', () => {
  qbLog.info('Watching for backend changes...');
  qbLog.target(target);
});
