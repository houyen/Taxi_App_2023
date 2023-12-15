package com.tkpmnc.sgtaxiuser.taxiapp.datamodels


class DriverLocation {
    var lat: String=""
    var lng: String=""

    constructor() {}

    constructor(lat: String, lng: String) {
        this.lat = lat
        this.lng = lng
    }
}
