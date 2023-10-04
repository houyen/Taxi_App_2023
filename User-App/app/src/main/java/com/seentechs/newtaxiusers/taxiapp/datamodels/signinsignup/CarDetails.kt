package com.seentechs.newtaxiusers.taxiapp.datamodels.signinsignup

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName



class CarDetails {

    @SerializedName("id")
    @Expose
    var id: String=""
    @SerializedName("carName")
    @Expose
    var carName: String=""
    @SerializedName("description")
    @Expose
    var description: String=""
}
