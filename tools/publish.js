const cpx = require('cpx');
const path = require('path');
const qbLog = require('qb-log')('simple');

const source = path.join(__dirname, '..', 'src', '**', '*');
const target = path.join(__dirname, '..', 'publish');

qbLog.info('Build to: ');
qbLog.empty(target);

cpx.copy(source, target, (err) => {
  if (err) {
    qbLog.error(err.message);

    return;
  }
  qbLog.info('Build complete.');
});
