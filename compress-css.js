const CleanCSS = require('clean-css');
const path = require('path');
const fs = require('fs');

// 指定需要压缩的 CSS 文件
const cssFiles = [
    path.join(__dirname, 'Public', 'Theme', 'assets', 'css', 'ticket.css'),
    path.join(__dirname, 'Public', 'Theme', 'assets', 'css', 'index.css'),
];

cssFiles.forEach(filePath => {
    const minFilePath = filePath.replace('.css', '.min.css');

    fs.readFile(filePath, 'utf8', (err, data) => {
        if (err) {
            console.error(`Error reading file: ${err.message}`);
            return;
        }

        const output = new CleanCSS().minify(data);
        if (output.errors.length > 0) {
            console.error(`Error compressing file: ${output.errors.join(', ')}`);
            return;
        }

        fs.writeFile(minFilePath, output.styles, err => {
            if (err) {
                console.error(`Error writing minified file: ${err.message}`);
                return;
            }
            console.log(`Compressed ${path.basename(filePath)} to ${path.basename(minFilePath)}`);
        });
    });
});
