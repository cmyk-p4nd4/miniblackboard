const express = require("express");
const ejs_a = require("ejs");
const app = express();
const path = require('path');
const router = express.Router();
const http = require('http');
const PORT = process.env.PORT || 5000

router.get('/', (req, res) => {
    res.sendFile(path.join(__dirname+'/html_template.html'));
});
app.use('/', router);
app.listen(3000, function () {
    console.log(`Example app listening on port ${PORT}!`);
});
express()
  .use(express.static(path.join(__dirname, 'public')))
  .set('views', path.join(__dirname, 'views'))
  .set('view engine', 'ejs')
  .get('/', (req, res) => res.render('html_template'))
  .listen(PORT, () => console.log(`Listening on ${ PORT }`));