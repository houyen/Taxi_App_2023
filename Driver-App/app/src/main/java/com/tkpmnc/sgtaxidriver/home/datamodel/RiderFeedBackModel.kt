package com.tkpmnc.sgtaxidriver.home.datamodel

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

import java.io.Serializable
import java.util.ArrayList


class RiderFeedBackModel : Serializable {

    @SerializedName("status_message")
    @Expose
    var statusMessage: String? = null
    @SerializedName("status_code")
    @Expose
    var statusCode: String? = null
    @SerializedName("total_pages")
    @Expose
    var totalPages: String? = null
    @SerializedName("rider_feedback")
    @Expose
    var riderFeedBack: ArrayList<RiderFeedBackArrayModel>? = null
}
