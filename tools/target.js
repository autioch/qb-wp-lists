const fs = require('fs');
const path = require('path');
let target;

try {
  target = fs.readFileSync(path.join(__dirname, '..', 'target')).toString().replace(/(\r\n|\n|\r)/gm, '');
} catch (err) {
  console.error('`target` file not found.');
  console.error(' Create file in root directory that contains single line with  path to theme folder.');
  process.exit(1);
}

module.exports = target;
