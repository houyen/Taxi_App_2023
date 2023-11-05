package com.tkpmnc.newtaxiusers.taxiapp.datamodels.signinsignup

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName



class SigninResult {

    @SerializedName("status_message")
    @Expose
    var statusMessage: String = ""

    @SerializedName("status_code")
    @Expose
    var statusCode: String = ""

    @SerializedName("access_token")
    @Expose
    var token: String = ""

    @SerializedName("user_id")
    @Expose
    var userId: String = ""


}
