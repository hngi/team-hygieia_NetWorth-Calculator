const mongoose = require("mongoose")
const assetSchema = new mongoose.Schema({
    name: String,
    description: String,
    value: Number
})

module.exports = mongoose.model("Asset", assetSchema);