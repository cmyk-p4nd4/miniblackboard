const app = require("express")();
const path = require('path');
const PORT = 3000;

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname+"/html_template.html"));
});

app.listen(PORT, () => {
    console.log(`Channel created at ${PORT}`);
});