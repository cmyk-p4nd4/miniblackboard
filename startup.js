const preq = require("express")();
const PORT = process.env.PORT || 3000;

preq.get("", (req, res) => {
    res.send("Ready!");
});

preq.listen(PORT, () => {
    console.log(`Channel created at ${PORT}`);
});