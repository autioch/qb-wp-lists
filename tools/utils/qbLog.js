/* eslint no-underscore-dangle: 0 */
const qbLog = require('qb-log')('simple');

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

module.exports = qbLog;
