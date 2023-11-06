package com.tkpmnc.newtaxidriver.home.datamodel

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName
import java.io.Serializable
import java.util.*



class LoginDetails : Serializable {

    @SerializedName("status_message")
    @Expose
    lateinit var statusMessage: String
    @SerializedName("status_code")
    @Expose
    lateinit var statusCode: String
    @SerializedName("access_token")
    @Expose
    lateinit var token: String
    @SerializedName("car_details")
    @Expose
    var carDetailModel: ArrayList<CarDetails>? = null
    @SerializedName("user_status")
    @Expose
    lateinit var userStatus: String
    @SerializedName("user_id")
    @Expose
    lateinit var userID: String

    @SerializedName("country_code")
    @Expose
    var country_code: String = ""
    @SerializedName("vehicle_id")
    @Expose
    lateinit var vehicleId: String
    @SerializedName("mobile_number")
    @Expose
    var mobileNumber: String= ""
    @SerializedName("company_id")
    @Expose
    lateinit var companyId: String
}