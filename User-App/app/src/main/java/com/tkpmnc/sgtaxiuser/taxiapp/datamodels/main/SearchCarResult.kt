package com.tkpmnc.sgtaxiuser.taxiapp.datamodels.main

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

import java.io.Serializable
import java.util.ArrayList



class SearchCarResult : Serializable {


    @SerializedName("status_message")
    @Expose
    var statusMessage: String=""
    @SerializedName("status_code")
    @Expose
    var statusCode: String=""
    @SerializedName("nearest_car")
    @Expose
    var nearestCar: ArrayList<NearestCar> = ArrayList()
}
