const mongoose = require("mongoose");
const userSchema = new mongoose.Schema({
    firstName : String,
    lastName: String,
    age: Number,
    assets: [{
        type: mongoose.Schema.Types.ObjectId,
            ref: 'Asset'
    }],
    liabilities : [{
        type: mongoose.Schema.Types.ObjectId,
            ref: 'Liability'
    }],
    netWorth: Number
});

module.exports = mongoose.model("User", userSchema);