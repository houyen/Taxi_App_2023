package com.tkpmnc.sgtaxiuser.taxiapp.datamodels

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName
import com.tkpmnc.sgtaxiuser.taxiapp.views.main.filter.FeaturesInCarModel

import java.io.Serializable



class RiderProfile : Serializable {

    @SerializedName("status_message")
    @Expose
    var statusMessage: String=""
    @SerializedName("status_code")
    @Expose
    var statusCode: String=""

    @SerializedName("first_name")
    @Expose
    var firstName: String=""

    @SerializedName("last_name")
    @Expose
    var lastName: String=""

    @SerializedName("is_vip")
    @Expose
    var isVip: String=""

    @SerializedName("mobile_number")
    @Expose
    var mobileNumber: String=""

    @SerializedName("profile_image")
    @Expose
    var profileImage: String=""

    @SerializedName("home")
    @Expose
    var home: String=""

    @SerializedName("work")
    @Expose
    var work: String=""

    @SerializedName("currency_symbol")
    @Expose
    var currencySymbol: String=""

    @SerializedName("currency_code")
    @Expose
    var currencyCode: String=""

    @SerializedName("wallet_amount")
    @Expose
    var walletAmount: String=""

    @SerializedName("request_options")
    @Expose
    var requestOptions: ArrayList<FeaturesInCarModel>?= ArrayList()
}
