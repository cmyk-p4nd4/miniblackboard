const express = require("express");
const app = express();
const path = require('path');
const router = express.Router();
const http = require('http');
const PORT = 3000;

router.get('/', (req, res) => {
    res.sendFile(path.join(__dirname+'/html_template.html'));
});
app.use('/', router);
app.listen(3000, function () {
    console.log(`Example app listening on port ${PORT}!`);
});