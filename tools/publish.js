const cpx = require('cpx');
const { qbLog, config: { target }, cpx: { selection } } = require('./utils');

qbLog.target(target);

cpx.copy(selection, target, (err) => {
  if (err) {
    qbLog.error(err.message);

    return;
  }

  qbLog.info('Backend files copied.');
});
