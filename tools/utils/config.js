/* eslint no-sync: 0 */
/* eslint no-process-exit: 0 */
const fs = require('fs');
const path = require('path');
const qbLog = require('./qbLog');

let target;
let extraLines;

try {
  const targetContent = fs.readFileSync(path.join(__dirname, '..', '..', 'target'), 'utf-8');

  [target, ...extraLines] = targetContent.trim().split('\n');

  if (extraLines.length) {
    qbLog.warn('Found extra lines in `target` file.');
  }
} catch (err) {
  qbLog.error('`target` file not found.');
  qbLog.error();
  qbLog.error('Create file in root directory that contains single line with  path to theme folder.');
  qbLog.error(err.message);
  process.exit(1);
}

module.exports = {
  target: target.trim(),
  project: path.join(__dirname, '..', '..'),
  source: path.join(__dirname, '..', '..', 'src'),
  buildTime: new Date().getTime(),
  isProduction: process.argv.indexOf('-p') > -1,
  extensions: ['php', 'txt']
};
