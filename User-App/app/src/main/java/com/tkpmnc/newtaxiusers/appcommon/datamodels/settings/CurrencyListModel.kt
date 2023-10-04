package com.seentechs.newtaxiusers.appcommon.datamodels.settings

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName



class CurrencyListModel {

    @SerializedName("code")
    @Expose
    var code: String=""
    @SerializedName("symbol")
    @Expose
    var symbol: String=""
}
