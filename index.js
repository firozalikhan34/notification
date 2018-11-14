const express = require("express");
const webpush = require("web-push");
const bodyParser = require("body-parser");
const path = require("path");
const epf= require('express-php-fpm');
const app = express();
app.set('view engine', 'php');
app.all('*', function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header('Access-Control-Allow-Methods', 'PUT, GET, POST, DELETE, OPTIONS');
  res.header('Access-Control-Allow-Headers', 'Content-Type,apikey');
  //Auth Each API Request created by user.    
  next();
});

app.use(express.static(path.join(__dirname, "client")));

app.use(bodyParser.json());

const publicVapidKey ="BLzTKZ4-GKwLFYfgaz5xyVvv8KmBOu36bvvmBRP8w6wUOkcBb7p34m8iO70m4ffEYew6ZNAAtuSleEddoPCaB9E";
const privateVapidKey = "WpMmmTJILl9kR1-AHdgKL_eGQ_qDyvkvv8euLUXBvrs";

webpush.setVapidDetails(
  "mailto:test@test.com",
  publicVapidKey,
  privateVapidKey
);
app.get("/",(req,res)=>{
  res.send("i m node")
})
// Subscribe Route
app.post("/subscribe", (req, res) => {
  // Get pushSubscription object
  const subscription = req.body;
   console.log("api")
  // Send 201 - resource created
  res.status(201).json({});

  // Create payload
  const payload = JSON.stringify({ title: "Notification" });

  // Pass object into sendNotification
  webpush
    .sendNotification(subscription, payload)
    .catch(err => console.error(err));
});

const port = 5000;

app.listen(port, () => console.log(`Server started on port ${port}`));
