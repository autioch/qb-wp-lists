const path = require('path');
const { extensions, source } = require('./config');

const selectionExtension = extensions.length > 1 ? `{${extensions.join(',')}}` : extensions[0];

module.exports = {
  selection: path.join(source, '**', `*.${selectionExtension}`)
};
