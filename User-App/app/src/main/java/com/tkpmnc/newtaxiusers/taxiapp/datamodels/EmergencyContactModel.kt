package com.tkpmnc.newtaxiusers.taxiapp.datamodels

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName



class EmergencyContactModel {

    @SerializedName("id")
    @Expose
    var id: String =""
    @SerializedName("name")
    @Expose
    var name: String=""
    @SerializedName("mobile_number")
    @Expose
    var mobileNumber: String=""
}
