package com.seentechs.newtaxidriver.home.datamodel

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

import java.io.Serializable



class EarningTripDetailsModel : Serializable {

    @SerializedName("created_at")
    @Expose
    var createdAt: String? = null
    @SerializedName("day")
    @Expose
    var day: String? = null
    @SerializedName("daily_fare")
    @Expose
    var dailyFare: String? = null
}
