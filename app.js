const express = require('express');
const app = express();
const mongoose = require("mongoose");
const bodyParser = require("body-parser");

mongoose.Promise = global.Promise;
mongoose.connect('mongodb://localhost/networth', {useNewUrlParser: true});

app.set("view engine", "ejs");
app.use(bodyParser.urlencoded({extended: true}));
app.use(express.static(__dirname + '/public'));

const User = require("./models/user");
const Asset = require("./models/asset");
const liability = require("./models/liability")

// Form to add new user to DB
app.get("/", function(req, res){
    res.render("newUser.ejs");
})


// Create new user
app.post("/", function(req, res){
    let newUser = req.body.newUser;
    User.create(newUser, function(err, user){
        if(err){
            console.log(err)
        } else{
            res.render("viewUser", {user:user})
        }
    })
})

// View All users
app.get("/allusers", function(req,res){
    User.find({}, function (err,all) {
        if(err){
            console.log(err)
        } else{
            res.render("allUsers", {allUsers:all})
        }
    })
})
// View Specific user
app.get("/users/:id/profile", function(req,res){
    User.findById(req.params.id, function(err,user){
        if(err) {
            console.log(err)
        } else{
            res.render("viewUser", {user:user})
        }
    })
})
// Add asset for specific User
app.get("/users/:id/assets/new", function(req,res){
    User.findById(req.params.id, function(req,res){

    })
})
// Create Asset for specific User

// Edit Asset for specific User

// Update Asset for specific User

// Delete Asset for specific User



// Add Liability for specific User

// Create Liability for specific User

// Edit Liability for specific User

// Update Liability for specific User


// Delete Liability for specific User

app.listen(4000, process.env.IP, function(){
    console.log("Calculate your networth!")
})