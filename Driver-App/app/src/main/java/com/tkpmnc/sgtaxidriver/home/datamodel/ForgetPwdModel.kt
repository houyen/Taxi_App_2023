package com.tkpmnc.sgtaxidriver.home.datamodel

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName



class ForgetPwdModel {


    @SerializedName("status_code")
    @Expose
    lateinit var statusCode: String
    @SerializedName("status_message")
    @Expose
    lateinit var statusMessage: String
    @SerializedName("otp")
    @Expose
    lateinit var otp: String

}
