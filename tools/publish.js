const cpx = require('cpx');
const path = require('path');
const { qbLog, config, copyHtaccess, saveBuildTime } = require('./utils');
const { source, target, extensions } = config;

qbLog.target(target);

const watchedFiles = path.join(source, '**', `*.{${extensions.join(',')}}`);

cpx.copy(watchedFiles, target, (err) => {
  if (err) {
    qbLog.error(err.message);

    return;
  }
  qbLog.info('Backend files copied.');
  copyHtaccess().then(saveBuildTime);
});
