package com.tkpmnc.sgtaxidriver.home.datamodel

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

import java.io.Serializable


class DriverStatus : Serializable {

    @SerializedName("status_message")
    @Expose
    var statusMessage: String? = null
    @SerializedName("status_code")
    @Expose
    var statusCode: String? = null
    @SerializedName("driver_status")
    @Expose
    lateinit var driverStatus: String
}
