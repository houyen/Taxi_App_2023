package com.tkpmnc.newtaxidriver.home.datamodel

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

import java.io.Serializable


class CarDetails : Serializable {

    @SerializedName("id")
    @Expose
    var id: Int? = null

    //Car name should not delete
    @SerializedName("car_name")
    @Expose
    var carName: String? = null

    @SerializedName("status")
    @Expose
    lateinit var status: String

}