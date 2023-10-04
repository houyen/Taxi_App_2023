package com.tkpmnc.newtaxiusers.taxiapp.datamodels.main

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName



class LocationModel {

    @SerializedName("latitude")
    @Expose
    var latitude: String=""

    @SerializedName("longitude")
    @Expose
    var longitude: String=""
}
