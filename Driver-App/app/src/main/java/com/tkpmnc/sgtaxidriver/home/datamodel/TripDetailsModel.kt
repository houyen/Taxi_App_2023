package com.tkpmnc.sgtaxidriver.home.datamodel

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName
import java.io.Serializable
import java.util.*



class TripDetailsModel : Serializable {

    @SerializedName("is_pool")
    @Expose
    var isPool: Boolean = false
    @SerializedName("seats")
    @Expose
    var seats: Int = 0
    @SerializedName("vehicle_name")
    @Expose
    var vehicleName : String =""
    @SerializedName("riders")
    @Expose
    var riderDetails =  ArrayList<RiderDetailsModelList>()
}
