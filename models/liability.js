const mongoose = require("mongoose")
const liabilitySchema = new mongoose.Schema({
    name: String,
    description: String,
    value: Number
})

module.exports = mongoose.model("Liability", liabilitySchema);