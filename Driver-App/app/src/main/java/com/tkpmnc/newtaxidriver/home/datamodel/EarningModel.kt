package com.tkpmnc.newtaxidriver.home.datamodel

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

import java.io.Serializable
import java.util.ArrayList



class EarningModel : Serializable {

    @SerializedName("status_message")
    @Expose
    var statusMessage: String? = null
    @SerializedName("status_code")
    @Expose
    var statusCode: String? = null
    @SerializedName("last_trip")
    @Expose
    var lastTrip: String? = null
    @SerializedName("trip_details")
    @Expose
    var tripDetails: ArrayList<EarningTripDetailsModel>? = null

/*<<<<<<< HEAD
    var earningList: EarningModel
=======
>>>>>>> origin/master*/
}

