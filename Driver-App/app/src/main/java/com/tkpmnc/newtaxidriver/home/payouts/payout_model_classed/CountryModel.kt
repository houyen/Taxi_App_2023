package com.tkpmnc.newtaxidriver.home.payouts.payout_model_classed

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName



class CountryModel {

    @SerializedName("country_id")
    @Expose
    var countryId: String=""

    @SerializedName("country_name")
    @Expose
    var countryName: String = ""
    @SerializedName("country_code")
    @Expose
    var countryCode: String = ""
}
