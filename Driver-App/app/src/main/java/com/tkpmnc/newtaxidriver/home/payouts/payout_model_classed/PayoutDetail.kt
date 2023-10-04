package com.tkpmnc.newtaxidriver.home.payouts.payout_model_classed

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName



class PayoutDetail {

    @SerializedName("payout_id")
    @Expose
    var payoutId: String=""
    @SerializedName("user_id")
    @Expose
    var userId: String=""

    @SerializedName("payout_method")
    @Expose
    var payoutMethod: String=""

    @SerializedName("paypal_email")
    @Expose
    var paypalEmail: String=""

    @SerializedName("set_default")
    @Expose
    var isDefault: String=""

    @SerializedName("icon")
    @Expose
    var icon: String=""

}
